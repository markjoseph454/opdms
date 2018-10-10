<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Mss;
use App\Mssclassification;
use App\User;
use App\Cashrecieptno;
use App\Cashidsale;
use App\Sales;
use App\ConvertNumberToWord;
use App\Cashmanualsale;
use App\Cashcredintials;
use App\Cashincomecategory;
use App\Cashincomesubcategory;
use App\Cashincome;
use PDF;
use DNS1D;
use DB;
use Carbon;
use Auth;
use Session;

class CashierreportController extends Controller
{
            
      public function dailyreport(Request $request)
      {
        if ($request->exporttype == "EXCELL") {
          return redirect('exporttransactiontoexcell')->withInput();
        }
            // dd($request);
            if ($request->mortype == 'INCOME') {
            $data =  DB::select("SELECT h.void,
                                                      DATE(h.created_at) as dates, 
                                      h.or_no as numbers,
                                                      i.last_name, i.first_name, i.middle_name,
                                                      ('HOSPITAL ID') as particulars,
                                                  h.price as total,
                                      h.price as other,
                                      (' ') as medicines,
                                      (' ') as medical,
                                      (' ') as laboratory,
                                      (' ') as radiology,
                                      (' ') as cardiology,
                                      ('hospital id') as type
                                          FROM cashidsale h
                                          LEFT JOIN patients i ON h.patients_id = i.id
                                          LEFT JOIN users j ON h.users_id = j.id
                                          WHERE date(h.created_at) = ?
                                          AND h.users_id = ?
                                          GROUP BY h.or_no
                                          UNION 
                                          SELECT o.void,
                                            DATE(o.created_at) as dates,
                                            o.or_no as numbers,
                                            p.last_name, p.first_name, p.middle_name,
                                      (CASE 
                                          WHEN t.id IN(6,11,13)
                                          THEN s.sub_category
                                          ELSE t.category
                                       END) as particulars,
                                                  (CASE 
                                          WHEN o.discount 
                                          THEN SUM((o.qty * o.price) - o.discount)
                                          ELSE SUM((o.qty * o.price) - 0)
                                       END) as total,
                                      (CASE 
                                          WHEN t.id IN(1, 2, 3, 4, 5, 7, 8, 13, 14, 15, 17, 18, 19)
                                          THEN (CASE 
                                                      WHEN o.discount 
                                                      THEN SUM((o.qty * o.price) - o.discount)
                                                      ELSE SUM((o.qty * o.price) - 0)
                                                 END) 
                                          ELSE  ' '
                                      END) as other,
                                      (' ') as medicines,
                                      (CASE 
                                          WHEN t.id IN(9) 
                                          THEN SUM((o.qty * o.price) - o.discount)
                                          ELSE ' '
                                      END) as medical,
                                      (CASE 
                                          WHEN t.id = 10 
                                          THEN SUM((o.qty * o.price) - o.discount)
                                          ELSE ' '
                                       END) as laboratory,
                                      (CASE 
                                          WHEN t.id IN(6,11) 
                                          THEN SUM((o.qty * o.price) - o.discount)
                                          ELSE ' '
                                       END) as radiology,
                                      (CASE 
                                          WHEN t.id IN(12) 
                                          THEN SUM((o.qty * o.price) - o.discount)
                                          ELSE ' '
                                       END) as cardiology,
                                       ('income') as type 
                                          FROM cashincome o
                                          LEFT JOIN patients p ON o.patients_id = p.id
                                          LEFT JOIN mss q ON o.mss_id = q.id
                                          LEFT JOIN users r ON o.users_id = r.id
                              LEFT JOIN cashincomesubcategory s ON o.category_id = s.id
                              LEFT JOIN cashincomecategory t ON s.cashincomecategory_id = t.id
                              WHERE date(o.created_at) = ?
                                          AND o.users_id = ?
                                          GROUP BY o.or_no, t.id
                              ORDER BY numbers ASC
                                          ", [$request->transdate, Auth::user()->id, 
                                                $request->transdate, Auth::user()->id, 
                                                $request->transdate, Auth::user()->id, 
                                                $request->transdate, Auth::user()->id]);
           
            }elseif ($request->mortype == 'MEDICINE') {
                  $data = DB::select("SELECT a.void,
                                                      DATE(a.created_at) as dates,
                                                      a.or_no as numbers, 
                                                  e.last_name, e.first_name, e.middle_name,
                                                  ('DRUGS AND MEDICINES') as particulars,
                                     (CASE 
                                          WHEN f.discount 
                                          THEN SUM((b.qty * a.price) - ((b.qty * a.price) * f.discount)) 
                                          ELSE SUM(b.qty * a.price)  
                                      END) as total,
                                                 (' ') as other,
                                   (CASE 
                                          WHEN f.discount 
                                          THEN SUM((b.qty * a.price) - ((b.qty * a.price) * f.discount)) 
                                          ELSE SUM(b.qty * a.price)  
                                    END) as medicines,
                                   (' ') as medical,
                                   (' ') as laboratory,
                                   (' ') as radiology,
                                   (' ') as cardiology,
                                   ('pharmacy') as type
                                          FROM sales a
                                          LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id 
                                          LEFT JOIN requisition c ON b.requisition_id = c.id
                                          LEFT JOIN ancillary_items d ON c.item_id = d.id
                                          LEFT JOIN patients e ON c.patients_id = e.id
                                          LEFT JOIN mss f ON a.mss_id = f.id
                                          LEFT JOIN users g ON a.users_id = g.id
                                          WHERE date(a.created_at) = ?
                                          -- AND a.mss_id NOT IN(9,10,11,12,13)
                                          -- AND a.price > 0
                                          AND a.users_id = ?
                            GROUP BY a.or_no",  
                            [$request->transdate, Auth::user()->id]);
                  }

            if ($request->mortype == 'INCOME') {      
            $style = array('width' => 0.1, 'color' => array(0, 0, 0));
            PDF::SetTitle('CASHIER DAILY REPORT');
            // PDF::IncludeJS("print();");
            PDF::SetAutoPageBreak(TRUE, 0);
            PDF::AddPage('L', 'LEGAL');

            PDF::SetFont('Times','B',11);
            PDF::text(140,5,'REPORT OF COLLECTIONS AND DEPOSITS');
            PDF::SetFont('helvetica',11);
            PDF::text(10,15,'Entitty Name:');
            PDF::text(10,25,'Fund:');
            PDF::text(180,15,'Report No.');
            PDF::SetXY(220,15);
            PDF::Cell(25,5,"".$request->mreportno."",0,0,'C');
            PDF::text(180,20,'Sheet No.');
            PDF::text(225,20,''.PDF::getAliasNumPage().' of '.PDF::getAliasNbPages().'');
            PDF::SetXY(220,20);
            PDF::Cell(28,5,"",0,0,'C');/*================pageno*/


            PDF::text(180,25,'Date:');
            PDF::Line(55, 20, 125, 20, $style);
            PDF::Line(55, 25, 125, 25, $style);

            PDF::Line(220, 20, 245, 20, $style);
            PDF::Line(220, 25, 245, 25, $style);
            PDF::text(220,25,Carbon::parse($request->transdate)->format('M. d, Y'));
            PDF::Line(220, 30, 245, 30, $style);

            PDF::SetFont('','B');
            PDF::text(55,15,'EASTERN VISAYAS REGIONAL MEDICAL CENTER');
            PDF::text(10,30,'HOSPITAL INCOME (LBP)');

        /*==============================END OF HEADER==================================*/
       
            PDF::SetFont('Times','B',10);
            PDF::SetXY(10,35);
            PDF::MultiCell(50,20,"\nOfficial Receipt/\nReport of Collections\nby Sub-Collector",1,'C',false);
            PDF::Cell(22,5,"DATE",1,0,'C');
            PDF::SetFont('helvetica','',10);
            PDF::SetXY(32,55);
            PDF::Cell(28,5,"NUMBER",1,0,'C');
            PDF::SetXY(60,35);
            PDF::SetFont('helvetica','',7);
            PDF::MultiCell(17,25,"\n\n\n\n\nResponsibilty\nCenter\nCode",1,'C',false);
            PDF::SetXY(77,35);
            PDF::SetFont('Times','',11);
            PDF::MultiCell(50,25,"\n\n\n\nPayor",1,'C',false);
            PDF::SetXY(77+50,35);
            PDF::MultiCell(45,25,"\n\n\n\nParticulars",1,'C',false);
            PDF::SetXY(77+95,35);
            PDF::SetFont('Times','',8);
            PDF::MultiCell(23,25,"\n\n\n\n\n\nMFO/PAP",1,'C',false);
            PDF::SetXY(77+95+23,35);
            PDF::SetFont('Times','',11);
            PDF::Cell(150,5,"AMOUNT",1,0,'C');
            PDF::SetXY(77+95+23,40);
            PDF::SetFont('Helvetica','B',11);
            PDF::MultiCell(25,20,"TOTAL\nPER\nOR",1,'C',false);
            PDF::SetXY(77+95+23+25,40);
            PDF::SetFont('Times','',9);
            PDF::MultiCell(25,20,"\n\nOTHER\nFEES\n(4020217099)",1,'C',false);
            PDF::SetXY(77+95+23+50,40);
            PDF::SetFont('Helvetica','B',6.5);
            PDF::MultiCell(25,20,"\nMEDICAL FEES \n- PHYSICAL MEDICINE &\n REHABILITATION\n SERVICES\n(4020217009)",1,'C',false);
            PDF::SetXY(77+95+23+75,40);
            PDF::SetFont('Helvetica','B',9);
            PDF::MultiCell(25,20,"\nLABORATORY",1,'C',false);
            PDF::SetXY(77+95+23+100,40);
            PDF::SetFont('Helvetica','',9);
            PDF::MultiCell(25,20,"\nRADIOLOGY",1,'C',false);
            PDF::SetXY(77+95+23+125,40);
            PDF::SetFont('Helvetica','',9);
            PDF::MultiCell(25,20,"\nCARDIOLOGY",1,'C',false);

            /*============================END OF TABLE HEADER=================================*/
            $i = 0;
            $y = PDF::GetY();
            PDF::SetXY(10,$y);
            if (count($data) > 0) {
              PDF::Cell(22,5,Carbon::parse($data[0]->dates)->format('m/d/Y'),1,0,'C');/*==========date*/
            }else{
              PDF::Cell(22,5,"",1,0,'C');/*==========date*/
            }
                  
            $total = 0;
            $other = 0;
            $medical = 0;
            $laboratory = 0;
            $radiology = 0;
            $cardiology = 0;
            // dd(count($data));
            foreach ($data as $list) {
                   if ($i == 29 || $i == 60 || $i == 91 || $i == 122 || $i == 153 || $i == 184 || $i == 215 || $i == 246 || $i == 277 || $i == 308 || $i == 339 || $i == 370) {
                      PDF::SetAutoPageBreak(TRUE, 0);
                      PDF::AddPage('L', 'LEGAL');

                      PDF::SetFont('Times','B',11);
                      PDF::text(140,5,'REPORT OF COLLECTIONS AND DEPOSITS');
                      PDF::SetFont('helvetica',11);
                      PDF::text(10,15,'Entitty Name:');
                      PDF::text(10,25,'Fund:');
                      PDF::text(180,15,'Report No.');
                      PDF::SetXY(220,15);
                      PDF::Cell(25,5,"".$request->mreportno."",0,0,'C');
                      PDF::text(180,20,'Sheet No.');
                      PDF::text(225,20,''.PDF::getAliasNumPage().' of '.PDF::getAliasNbPages().'');
                      PDF::SetXY(220,20);
                      PDF::Cell(28,5,"",0,0,'C');/*================pageno*/


                      PDF::text(180,25,'Date:');
                      PDF::Line(55, 20, 125, 20, $style);
                      PDF::Line(55, 25, 125, 25, $style);

                      PDF::Line(220, 20, 245, 20, $style);
                      PDF::Line(220, 25, 245, 25, $style);
                      PDF::text(220,25,Carbon::parse($request->transdate)->format('M. d, Y'));
                      PDF::Line(220, 30, 245, 30, $style);

                      PDF::SetFont('','B');
                      PDF::text(55,15,'EASTERN VISAYAS REGIONAL MEDICAL CENTER');
                      PDF::text(10,30,'HOSPITAL INCOME (LBP)');
                        $y = 35;
                  }
                  
                  PDF::SetFont('Helvetica','',9);
                  PDF::SetXY(10,$y);
                  PDF::Cell(22,5,'',1,0,'C');/*==========date*/

                  PDF::SetXY(10+22,$y);
                  if ($list->numbers == "7880778" || $list->numbers == "7911130" || $list->numbers == "7918724") {
                  PDF::Cell(28,5,$list->numbers.' - Check',1,0,'C');/*===========number*/
                  }else{
                  PDF::Cell(28,5,$list->numbers,1,0,'C');/*===========number*/
                  }

                  PDF::SetXY(10+50,$y);
                  PDF::Cell(17,5,"",1,0,'C');/*============rcc*/

                  PDF::SetXY(10+50+17,$y);
                  PDF::Cell(50,5,"".$list->last_name.", ".$list->first_name." ".substr($list->middle_name,0,1).".",1,0,'');/*============payor*/

                  PDF::SetXY(10+100+17,$y);
                  if ($list->void == 1) {
                   PDF::Cell(45,5,'CANCELLED',1,0,'C');/*============particular*/     # code...
                  }else{
                   PDF::Cell(45,5,$list->particulars,1,0,'');/*============particular*/     
                  }
                  

                  PDF::SetXY(10+145+17,$y);
                  PDF::Cell(23,5,"",1,0,'C');/*============mfo/pap*/

                  PDF::SetXY(10+145+40,$y);
                  if ($list->void == 1) {
                        PDF::Cell(25,5,"-",1,0,'R');/*============total*/  
                        PDF::SetXY(10+145+65,$y);
                        PDF::Cell(25,5,"",1,0,'R');/*============other*/
                        PDF::SetXY(10+145+90,$y);
                        PDF::Cell(25,5,"",1,0,'R');  
                        PDF::SetXY(10+145+115,$y); 
                        PDF::Cell(25,5,"",1,0,'R');
                        PDF::SetXY(10+145+140,$y);
                        PDF::Cell(25,5,"",1,0,'R');
                        PDF::SetXY(10+145+165,$y);
                        PDF::Cell(25,5,"",1,0,'R');
                  }else{
                        PDF::Cell(25,5,"".number_format($list->total, 2, '.', ',')."",1,0,'R');/*============total*/
                        $total += $list->total;
                        PDF::SetXY(10+145+65,$y);
                        if ($list->other  > 0) {

                        PDF::Cell(25,5,"".number_format($list->other, 2, '.', ',')."",1,0,'R');/*============other*/
                        $other += $list->other;
                        }
                        else{
                        PDF::Cell(25,5,"",1,0,'R');   
                        }
                        PDF::SetXY(10+145+90,$y);
                        if ($list->medical > 0) {
                        PDF::Cell(25,5,"".number_format($list->medical, 2, '.', ',')."",1,0,'R');/*============mp/mrs*/
                        $medical += $list->medical;
                        }
                        else{
                        PDF::Cell(25,5,"",1,0,'R');   
                        }
                        PDF::SetXY(10+145+115,$y);
                        if ($list->laboratory > 0) {
                        PDF::Cell(25,5,"".number_format($list->laboratory, 2, '.', ',')."",1,0,'R');/*============lab*/
                        $laboratory += $list->laboratory;
                        } else {
                        PDF::Cell(25,5,"",1,0,'R');
                        }
                        PDF::SetXY(10+145+140,$y);
                        if ($list->radiology > 0) {
                        PDF::Cell(25,5,"".number_format($list->radiology, 2, '.', ',')."",1,0,'R');/*============rad*/
                        $radiology += $list->radiology;
                        } else {
                        PDF::Cell(25,5,"",1,0,'R');
                        }
                        PDF::SetXY(10+145+165,$y);
                        if ($list->cardiology > 0) {

                        PDF::Cell(25,5,"".number_format($list->cardiology, 2, '.', ',')."",1,0,'R');/*============card*/
                        $cardiology += $list->cardiology;
                        } else {
                        PDF::Cell(25,5,"",1,0,'R');
                        }
                  }     

                  
                  
                  $y+=5;
                  $i++;
            }
            /*==================END OF TRANSACTION BODY============================================*/
            PDF::SetFont('Helvetica','',11);
            PDF::SetXY(10,$y);
            PDF::Cell(22,5,"",1,0,'C');/*==========date*/

            PDF::SetXY(10+22,$y);
            PDF::Cell(28,5,"",1,0,'C');/*===========number*/

            PDF::SetXY(10+50,$y);
            PDF::Cell(17,5,"",1,0,'C');/*============rcc*/

            PDF::SetXY(10+50+17,$y);
            PDF::Cell(50,5,"",1,0,'C');/*============payor*/

            PDF::SetXY(10+100+17,$y);
            PDF::Cell(45,5,"",1,0,'C');/*============particular*/

            PDF::SetXY(10+145+17,$y);
            PDF::Cell(23,5,"",1,0,'C');/*============mfo/pap*/
            PDF::SetFont('Helvetica','B',11);
            PDF::SetXY(10+145+40,$y);
            PDF::Cell(25,5,"".number_format($total, 2, '.', ',')."",1,0,'R');/*============total*/

            PDF::SetXY(10+145+65,$y);
            PDF::Cell(25,5,"".number_format($other, 2, '.', ',')."",1,0,'R');/*============other*/

            PDF::SetXY(10+145+90,$y);
            PDF::Cell(25,5,"".number_format($medical, 2, '.', ',')."",1,0,'R');/*============mp/mrs*/

            PDF::SetXY(10+145+115,$y);
            PDF::Cell(25,5,"".number_format($laboratory, 2, '.', ',')."",1,0,'R');/*============lab*/

            PDF::SetXY(10+145+140,$y);
            PDF::Cell(25,5,"".number_format($radiology, 2, '.', ',')."",1,0,'R');/*============rad*/

            PDF::SetXY(10+145+165,$y);
            PDF::Cell(25,5,"".number_format($cardiology, 2, '.', ',')."",1,0,'R');/*============card*/
            PDF::SetFont('Helvetica','',11);
            // dd($i);  
            /*====================END OF TRANSACTION TOTAL============================================*/
                              if ($i >= 15 && $i <= 29 ||
                                    $i >= 52 && $i <= 66 ||
                                    $i >= 89 && $i <= 103 ||
                                    $i >= 120 && $i <= 147 ||
                                    $i >= 161 && $i <= 177 ||
                                    $i >= 200 && $i <= 214 ||
                                    $i >= 237 && $i <= 266 ||
                                    $i >= 274 && $i <= 295 ||
                                    $i >= 311 && $i <= 325 ||
                                    $i > 355 && $i <= 370) {
                                    PDF::SetAutoPageBreak(TRUE, 0);
                                    PDF::AddPage('L', 'LEGAL');
                                    $y = -40;
                              }
            
      
            $y = PDF::GetY()+5;
            PDF::SetFont('Helvetica','', 11);
            PDF::text(32,$y,'Summary');
            PDF::text(32,$y+5,'Undeposited Collections per last Report');
            PDF::SetFont('Helvetica','', 10);
            if (count($data) > 0) {
              PDF::text(32,$y+10,'Collections per OR Nos.              '.$data[0]->numbers.' - '.substr($list->numbers,4,3).'');
            }else{
              PDF::text(32,$y+10,'Collections per OR Nos.');
            }
            
            $sum = 0 + $request->undeposited;
            $subtotal = 0 + $total;
            $totals = $sum + $subtotal;
            PDF::SetXY(220,$y+5);
            if ($sum > 0) {
            PDF::Cell(25,5,"".number_format($sum, 2, '.', ',')."",0,0,'R');/*===========sum*/
            }else{
            PDF::Cell(25,5,"-",0,0,'R');/*===========sum*/  
            }

            PDF::SetXY(220,$y+10);
            PDF::Cell(25,5,"".number_format($subtotal, 2, '.', ',')."",0,0,'R');/*===========subtotal*/

            PDF::Line(220, $y+15, 245, $y+15, $style);
            PDF::SetFont('Helvetica','B', 12);
            PDF::text(87,$y+10,'');/*===========or scope*/
            PDF::SetFont('Helvetica','B', 10);

            PDF::SetXY(220,$y+15);
            PDF::Cell(25,5,"".number_format($totals, 2, '.', ',')."",0,0,'R');/*===========total*/

            PDF::SetFont('Helvetica','', 11);
            $today = Carbon::parse($request->transdate)->format('l');
                  if ($today == 'Saturday') {
                       PDF::text(60,$y+20,'Deposits');/*===========sum*/ 
                       PDF::text(60,$y+30,'Date:');
                  }else{
                       PDF::text(60,$y+20,'Deposits        '.$request->mgstart.'');/*===========sum*/ 
                       PDF::text(60,$y+30,'Date:             '.$request->mgdate.'');
                  }
            PDF::SetXY(220,$y+30);
            if ($sum > 0) {
                  if ($today == 'Saturday') {
                       PDF::Cell(25,5," ",0,0,'R');/*===========sum*/ 
                  }else{
                       PDF::Cell(25,5,"".number_format($sum, 2, '.', ',')."",0,0,'R');/*===========sum*/ 
                  }
            }else{
            PDF::Cell(25,5,"-",0,0,'R');/*===========sum*/
            }
            PDF::Line(220, $y+35, 245, $y+35, $style);
            PDF::Line(220, $y+35.7, 245, $y+35.7, $style);
            PDF::SetXY(220,$y+35.9);
            if ($today == 'Saturday') {
                 PDF::Cell(25,5,"".number_format($totals, 2, '.', ',')."",0,0,'R');/*===========subtotal*/
            }else{
                 PDF::Cell(25,5,"".number_format($subtotal, 2, '.', ',')."",0,0,'R');/*===========subtotal*/
            }
            
            PDF::text(32,$y+35,'Undeposited Collections, this Report');

            // dd($i);
                  
            /*============================end of footer============================*/
            if ($i >= 49 && $i <= 60 ||
                $i >= 155 && $i <= 160 ||
                $i >= 78 && $i <= 85 ||
                $i >= 106 && $i <= 111 ||
                $i >= 190 && $i <= 198 ||
                $i >= 270 && $i <= 280 ||
                $i > 325 && $i<= 330) {
                  PDF::SetAutoPageBreak(TRUE, 0);
                  PDF::AddPage('L', 'LEGAL');
                  $y = -40;
            }
            

            PDF::Line(10, $y+45.7, 345, $y+45.7, $style);
            PDF::SetFont('Times','', 11);
            PDF::text(160,$y+45.8,'CERTIFICATION');
            PDF::Line(10, $y+50.7, 345, $y+50.7, $style);


            PDF::SetFont('Helvetica','', 10);
            PDF::text(32,$y+55,'I hereby certify on my official oath that the above is a true statement of all collections and deposits had by me during the period stated above which  Official');
            PDF::text(10,$y+60,'Receipts Nos.');
            PDF::SetFont('Helvetica','B', 10);
            if (count($data) > 0) {
              PDF::text(45,$y+60,''.$data[0]->numbers.' - '.substr($list->numbers,4,3).'')/*===================or scope*/;
            }else{
              PDF::text(45,$y+60,'')/*===================or scope*/;
            }
            
            PDF::SetFont('Helvetica','', 10);
            PDF::text(75,$y+60,'inclusive were actually issued by me in the amounts shown thereon. I also certify that I have not received money from whatever ');
            PDF::text(10,$y+65,'source without  having issued the necessary Official Receipt in acknowledgement thereof. Collections received by sub-collectors are recorded above in lump-sum ');
            PDF::text(10,$y+70,'opposite their respective collector  report numbers. I certify further that the balance shown above agrees with the balance appearing in my Cash Receipts Record.');

            PDF::SetFont('Helvetica','', 11);
            PDF::text(32,$y+80,'Prepared by:');
            PDF::text(200,$y+80,'Reviewed by:');

            $y = PDF::GetY();
            PDF::SetXY(32,$y+5);
            PDF::SetFont('Helvetica','B', 11);
            PDF::Cell(100,5,"".strtoupper(Auth::user()->first_name." ".substr(Auth::user()->middle_name,0,1).". ".Auth::user()->last_name)."",0,0,'C');/*=============Name*/
            PDF::SetXY(32,$y+10);
            PDF::SetFont('Helvetica','', 10);
            PDF::Cell(100,5,'Name and Signature of the Collecting Officer',0,0,'C');
            PDF::SetXY(32,$y+15);
            PDF::SetFont('Helvetica','', 11);
            PDF::Cell(100,5,''.strtoupper($request->msdisignation).'',0,0,'C');/*=============ITEM*/
            PDF::SetXY(32,$y+20);
            PDF::Cell(100,5,'Official Designation',0,0,'C');
            
            PDF::SetXY(32,$y+30);
            PDF::SetFont('Times','', 11);
            PDF::Cell(100,5,'Date',0,0,'C');

            PDF::SetXY(190,$y+10);
            PDF::SetFont('Helvetica','B', 11);
            PDF::Cell(100,5,'RUFINA G. AGNER',0,0,'C');
            PDF::SetXY(190,$y+15);
            PDF::SetFont('Helvetica','', 11);
            PDF::Cell(100,5,'Supervising Administrative Officer',0,0,'C');
            PDF::Line(10, $y+35, 345, $y+35, $style);

        PDF::Output();
            return;
            }elseif ($request->mortype == 'MEDICINE') {

                  $style = array('width' => 0.1, 'color' => array(0, 0, 0));
                  PDF::SetTitle('CASHIER DAILY REPORT');
                  // PDF::IncludeJS("print();");
                  PDF::SetAutoPageBreak(TRUE, 0);
                  PDF::AddPage('L', 'LEGAL');

                  PDF::SetFont('Times','B',11);
                  PDF::text(140,5,'REPORT OF COLLECTIONS AND DEPOSITS');
                  PDF::SetFont('helvetica',11);
                  PDF::text(10,15,'Entitty Name:');
                  PDF::text(10,25,'Fund:');
                  PDF::text(180,15,'Report No.');
                  PDF::SetXY(220,15);
                  PDF::Cell(28,5,"".$request->mreportno."",0,0,'C');
                  PDF::text(180,20,'Sheet No.');
                  PDF::SetXY(220,20);
                  PDF::Cell(28,5,"",0,0,'C');/*================pageno*/


                  PDF::text(180,25,'Date:');
                  PDF::Line(55, 20, 125, 20, $style);
                  PDF::Line(55, 25, 125, 25, $style);

                  PDF::Line(220, 20, 245, 20, $style);
                  PDF::Line(220, 25, 245, 25, $style);
                  PDF::text(220,25,Carbon::parse($request->transdate)->format('M. d, Y'));
                  PDF::Line(220, 30, 245, 30, $style);

                  PDF::SetFont('','B');
                  PDF::text(55,15,'EASTERN VISAYAS REGIONAL MEDICAL CENTER');
                  PDF::text(10,30,'REVOLVING FUND (DBP)-MEDICINE');

              /*==============================END OF HEADER==================================*/
             
                  PDF::SetFont('Times','B',10);
                  PDF::SetXY(10,35);
                  PDF::MultiCell(70,20,"\nOfficial Receipt/\nReport of Collections\nby Sub-Collector",1,'C',false);
                  PDF::Cell(35,5,"DATE",1,0,'C');
                  PDF::SetFont('helvetica','',10);
                  PDF::SetXY(45,55);
                  PDF::Cell(35,5,"NUMBER",1,0,'C');
                  PDF::SetXY(80,35);
                  PDF::SetFont('helvetica','',7);
                  PDF::MultiCell(20,25,"\n\n\n\n\nResponsibilty\nCenter\nCode",1,'C',false);
                  PDF::SetXY(100,35);
                  PDF::SetFont('Times','',11);
                  PDF::MultiCell(60,25,"\n\n\n\nPayor",1,'C',false);
                  PDF::SetXY(77+50+33,35);
                  PDF::MultiCell(55,25,"\n\n\n\nParticulars",1,'C',false);
                  PDF::SetXY(77+138,35);
                  PDF::SetFont('Times','',8);
                  PDF::MultiCell(30,25,"\n\n\n\n\n\nMFO/PAP",1,'C',false);
                  PDF::SetXY(77+95+73,35);
                  PDF::SetFont('Times','',11);
                  PDF::Cell(100,5,"AMOUNT",1,0,'C');
                  PDF::SetXY(77+95+73,40);
                  PDF::SetFont('Helvetica','B',11);
                  PDF::MultiCell(50,20,"TOTAL\nPER\nOR",1,'C',false);
                  PDF::SetXY(77+95+23+100,40);
                  PDF::SetFont('Helvetica','B',11);
                  PDF::MultiCell(50,20,"DRUGS AND\n MEDICINES\n(4020217001)",1,'C',false);
                  // PDF::SetXY(77+95+23+50,40);
                  
                  PDF::SetFont('Helvetica','',9);

                  /*============================END OF TABLE HEADER=================================*/
                  $i = 0;
                  $y = PDF::GetY();
                  PDF::SetXY(10,$y);
                  if (count($data) > 0) {
                     PDF::Cell(35,5,Carbon::parse($data[0]->dates)->format('m/d/Y'),1,0,'C');/*==========date*/
                  }else{
                     PDF::Cell(35,5,"",1,0,'C');/*==========date*/
                  }
                       
                  $total = 0;
                  $medicines = 0;
                  foreach ($data as $list) {
                        if ($i == 27 || $i == 66 || $i == 103 || $i == 140 || $i == 177 || $i == 214 || $i == 251 || $i == 288 || $i == 325) {
                              PDF::SetAutoPageBreak(TRUE, 0);
                              PDF::AddPage('L', 'LEGAL');
                              $y = 20;
                        }
                        PDF::SetXY(10,$y);
                        PDF::Cell(35,5,'',1,0,'C');/*==========date*/

                        PDF::SetXY(10+35,$y);
                        PDF::Cell(35,5,$list->numbers,1,0,'C');/*===========number*/

                        PDF::SetXY(10+70,$y);
                        PDF::Cell(20,5,"",1,0,'C');/*============rcc*/

                        PDF::SetXY(10+70+20,$y);
                        PDF::Cell(60,5,"".$list->last_name.", ".$list->first_name." ".substr($list->middle_name,0,1).".",1,0,'');/*============payor*/

                        PDF::SetXY(10+100+50,$y);
                        if ($list->void == 1) {
                        PDF::Cell(55,5,"CANCELLED",1,0,'C');/*============particular*/
                        }else{
                        PDF::Cell(55,5,$list->particulars,1,0,'C');/*============particular*/
                        }
                        

                        PDF::SetXY(10+100+105,$y);
                        PDF::Cell(30,5,"",1,0,'C');/*============mfo/pap*/

                        PDF::SetXY(10+100+135,$y);
                        if ($list->void == 1) {
                        PDF::Cell(50,5,"-",1,0,'R');/*============total*/
                        }else{
                        PDF::Cell(50,5,"".number_format($list->total, 2, '.', ',')."",1,0,'R');/*============total*/
                        $total += $list->total;      
                        }
                        

                        PDF::SetXY(10+150+135,$y);
                        if ($list->void == 1) {
                        PDF::Cell(50,5,"",1,0,'R');/*============other*/
                        }else{
                        if ($list->medicines  > 0) {
                        PDF::Cell(50,5,"".number_format($list->medicines, 2, '.', ',')."",1,0,'R');/*============other*/
                        $medicines += $list->medicines;
                        }
                        }
                        
                        $y+=5;
                        $i++;
                  }
                  /*==================END OF TRANSACTION BODY============================================*/
                  PDF::SetFont('Helvetica','B',11);
                  PDF::SetXY(10,$y);
                  PDF::Cell(35,5,'',1,0,'C');/*==========date*/

                  PDF::SetXY(10+35,$y);
                  PDF::Cell(35,5,"",1,0,'C');/*===========number*/

                  PDF::SetXY(10+70,$y);
                  PDF::Cell(20,5,"",1,0,'C');/*============rcc*/

                  PDF::SetXY(10+70+20,$y);
                  PDF::Cell(60,5,"",1,0,'');/*============payor*/

                  PDF::SetXY(10+100+50,$y);
                  PDF::Cell(55,5,"",1,0,'C');/*============particular*/

                  PDF::SetXY(10+100+105,$y);
                  PDF::Cell(30,5,"",1,0,'C');/*============mfo/pap*/

                  PDF::SetXY(10+100+135,$y);
                  PDF::Cell(50,5,"".number_format($total, 2, '.', ',')."",1,0,'R');/*============total*/

                  PDF::SetXY(10+150+135,$y);
                  PDF::Cell(50,5,"".number_format($medicines, 2, '.', ',')."",1,0,'R');/*============other*/
                  PDF::SetFont('Helvetica','',11);
             

                  /*====================END OF TRANSACTION TOTAL============================================*/

                         


                  
             

                  /*============================end of footer============================*/
             

                    // dd($i);
                        if ($i >= 16 && $i <= 29 ||
                          $i >= 52 && $i <= 66 ||
                          $i >= 89 && $i <= 103 ||
                          $i >= 126 && $i <= 140 ||
                          $i >= 163 && $i <= 177 ||
                          $i >= 200 && $i <= 214 ||
                          $i >= 237 && $i <= 251 ||
                          $i >= 274 && $i <= 288 ||
                          $i >= 311 && $i <= 325) {
                        
                       
                        PDF::SetAutoPageBreak(TRUE, 0);
                            PDF::AddPage('L', 'LEGAL');
                             $y = -40;  
                        //     $y = 20; 
                        }
            $y = PDF::GetY()+5;
                   
                  PDF::SetFont('Helvetica','', 11);
                  PDF::text(32,$y,'Summary');
                  PDF::text(32,$y+5,'Undeposited Collections per last Report');
                  PDF::SetFont('Helvetica','', 10);
                  if (count($data) > 0) {
                     PDF::text(32,$y+10,'Collections per OR Nos.              '.$data[0]->numbers.' - '.substr($list->numbers,4,3).'');
                  }else{
                     PDF::text(32,$y+10,'Collections per OR Nos.');
                  }
                  
                  $sum = 0 + $request->undeposited;
                  $subtotal = 0 + $total;
                  $totals = $sum + $subtotal;
                  PDF::SetXY(220,$y+5);
                  if ($sum > 0) {
                  PDF::Cell(25,5,"".number_format($sum, 2, '.', ',')."",0,0,'R');/*===========sum*/
                  }else{
                  PDF::Cell(25,5,"-",0,0,'R');/*===========sum*/  
                  }

                  PDF::SetXY(220,$y+10);
                  PDF::Cell(25,5,"".number_format($subtotal, 2, '.', ',')."",0,0,'R');/*===========subtotal*/

                  PDF::Line(220, $y+15, 245, $y+15, $style);
                  PDF::SetFont('Helvetica','B', 12);
                  PDF::text(87,$y+10,'');/*===========or scope*/
                  PDF::SetFont('Helvetica','B', 10);

                  PDF::SetXY(220,$y+15);
                  PDF::Cell(25,5,"".number_format($totals, 2, '.', ',')."",0,0,'R');/*===========total*/

                   $today = Carbon::parse($request->transdate)->format('l');
                        if ($today == 'Saturday') {
                             PDF::text(60,$y+20,'Deposits');/*===========sum*/ 
                             PDF::text(60,$y+30,'Date:');
                        }else{
                             PDF::text(60,$y+20,'Deposits        '.$request->mgstart.'');/*===========sum*/ 
                             PDF::text(60,$y+30,'Date:             '.$request->mgdate.'');
                        }
                  PDF::SetXY(220,$y+30);
                  if ($sum > 0) {
                       if ($today == 'Saturday') {
                            PDF::Cell(25,5," ",0,0,'R');/*===========sum*/ 
                       }else{
                            PDF::Cell(25,5,"".number_format($sum, 2, '.', ',')."",0,0,'R');/*===========sum*/ 
                       }
                  }else{
                  PDF::Cell(25,5,"-",0,0,'R');/*===========sum*/
                  }
                  PDF::Line(220, $y+35, 245, $y+35, $style);
                  PDF::Line(220, $y+35.7, 245, $y+35.7, $style);
                  PDF::SetXY(220,$y+35.9);
                  if ($today == 'Saturday') {
                                   PDF::Cell(25,5,"".number_format($totals, 2, '.', ',')."",0,0,'R');/*===========subtotal*/
                              }else{
                                   PDF::Cell(25,5,"".number_format($subtotal, 2, '.', ',')."",0,0,'R');/*===========subtotal*/
                              }
                  PDF::text(32,$y+35,'Undeposited Collections, this Report');
                 // dd($i);
                  if ($i >= 8 && $i <= 15 ||
                        $i >= 52 && $i <= 66 ||
                        $i >= 89 && $i <= 103 ||
                        $i >= 126 && $i <= 140 ||
                        $i >= 163 && $i <= 177 ||
                        $i >= 200 && $i <= 214 ||
                        $i >= 237 && $i <= 251 ||
                        $i >= 274 && $i <= 288 ||
                        $i >= 311 && $i <= 325) {
                        
                       
                        PDF::SetAutoPageBreak(TRUE, 0);
                            PDF::AddPage('L', 'LEGAL');
                             $y = -40;  
                        //     $y = 20; 
                  }
                  PDF::Line(10, $y+45.7, 345, $y+45.7, $style);
                  PDF::SetFont('Times','', 11);
                  PDF::text(160,$y+45.8,'CERTIFICATION');
                  PDF::Line(10, $y+50.7, 345, $y+50.7, $style);


                  PDF::SetFont('Helvetica','', 10);
                  PDF::text(32,$y+55,'I hereby certify on my official oath that the above is a true statement of all collections and deposits had by me during the period stated above which  Official');
                  PDF::text(10,$y+60,'Receipts Nos.');
                  PDF::SetFont('Helvetica','B', 10);
                  if (count($data) > 0) {
                     PDF::text(45,$y+60,''.$data[0]->numbers.' - '.substr($list->numbers,4,3).'')/*===================or scope*/;
                  }else{
                     PDF::text(45,$y+60,'')/*===================or scope*/;
                  }
                  
                  PDF::SetFont('Helvetica','', 10);
                  PDF::text(75,$y+60,'inclusive were actually issued by me in the amounts shown thereon. I also certify that I have not received money from whatever ');
                  PDF::text(10,$y+65,'source without  having issued the necessary Official Receipt in acknowledgement thereof. Collections received by sub-collectors are recorded above in lump-sum ');
                  PDF::text(10,$y+70,'opposite their respective collector  report numbers. I certify further that the balance shown above agrees with the balance appearing in my Cash Receipts Record.');

                  PDF::SetFont('Helvetica','', 11);
                  PDF::text(32,$y+80,'Prepared by:');
                  PDF::text(200,$y+80,'Reviewed by:');

                  $y = PDF::GetY();
                  PDF::SetXY(32,$y+5);
                  PDF::SetFont('Helvetica','B', 11);
                  PDF::Cell(100,5,"".strtoupper(Auth::user()->first_name." ".substr(Auth::user()->middle_name,0,1).". ".Auth::user()->last_name)."",0,0,'C');/*=============Name*/
                  PDF::SetXY(32,$y+10);
                  PDF::SetFont('Helvetica','', 10);
                  PDF::Cell(100,5,'Name and Signature of the Collecting Officer',0,0,'C');
                  PDF::SetXY(32,$y+15);
                  PDF::SetFont('Helvetica','', 11);
                  PDF::Cell(100,5,''.strtoupper($request->msdisignation).'',0,0,'C');/*=============ITEM*/
                  PDF::SetXY(32,$y+20);
                  PDF::Cell(100,5,'Official Designation',0,0,'C');
                  
                  PDF::SetXY(32,$y+30);
                  PDF::SetFont('Times','', 11);
                  PDF::Cell(100,5,'Date',0,0,'C');

                  PDF::SetXY(190,$y+10);
                  PDF::SetFont('Helvetica','B', 11);
                  PDF::Cell(100,5,'RUFINA G. AGNER',0,0,'C');
                  PDF::SetXY(190,$y+15);
                  PDF::SetFont('Helvetica','', 11);
                  PDF::Cell(100,5,'Supervising Administrative Officer',0,0,'C');
                  PDF::Line(10, $y+35, 345, $y+35, $style);

              PDF::Output();
                  return;
            }
      }
}