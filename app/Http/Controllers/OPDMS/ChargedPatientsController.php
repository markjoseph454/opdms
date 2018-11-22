<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChargedPatientsController extends Controller
{

    public function charged_notifications()
    {
        $charges = DB::table('ancillaryrequist')
                    ->where([
                        [DB::raw('DATE(ancillaryrequist.created_at)'), DB::raw('CURDATE()')],
                        ['cashincomecategory.clinic_id', Auth::user()->clinic]
                    ])
                    ->leftJoin('cashincomesubcategory', 'cashincomesubcategory.id', 'ancillaryrequist.cashincomesubcategory_id')
                    ->leftJoin('cashincomecategory', 'cashincomecategory.id', 'cashincomesubcategory.cashincomecategory_id')
                    ->leftJoin('patients', 'patients.id', 'ancillaryrequist.patients_id')
                    ->groupBy('ancillaryrequist.patients_id')
                    ->select('patients.id as pid', 'patients.last_name', 'patients.first_name', 'patients.hospital_no',
                        'cashincomesubcategory.sub_category', 'cashincomesubcategory.price', 'ancillaryrequist.created_at')
                    ->limit(5)
                    ->get();
        echo json_encode($charges);
        return;
    }


    public function charged_patients(Request $request)
    {

        $queues = DB::select("
                    SELECT * FROM
                    (
                    SELECT patients.id as pid, 
                    patients.last_name, patients.first_name, patients.middle_name,
                    patients.suffix, patients.birthday, patients.hospital_no, patients.barcode,
                    cashincomesubcategory.sub_category, cashincomesubcategory.price,
                    ancillaryrequist.created_at
                    FROM ancillaryrequist 
                    LEFT JOIN cashincomesubcategory
                    ON cashincomesubcategory.id = ancillaryrequist.cashincomesubcategory_id
                    LEFT JOIN cashincomecategory
                    ON cashincomecategory.id = cashincomesubcategory.cashincomecategory_id
                    LEFT JOIN patients
                    ON patients.id = ancillaryrequist.patients_id
                    WHERE cashincomecategory.clinic_id = ".Auth::user()->clinic."
                    AND DATE(ancillaryrequist.created_at) BETWEEN '".$request->start."' AND '".$request->end."'
                    GROUP BY ancillaryrequist.patients_id
                    ) myquery
                    WHERE myquery.hospital_no = '".$request->search."'
                    OR myquery.barcode = '".$request->search."'
                    OR CONCAT(last_name,' ',first_name) LIKE '%".$request->search."%'
                    ORDER BY myquery.created_at DESC");

        /*$charges = DB::table('ancillaryrequist')
            ->where([
                ['cashincomecategory.clinic_id', Auth::user()->clinic]
            ])
            ->whereBetween(DB::raw('DATE(ancillaryrequist.created_at)'), [$request->start, $request->end])
            ->leftJoin('cashincomesubcategory', 'cashincomesubcategory.id', 'ancillaryrequist.cashincomesubcategory_id')
            ->leftJoin('cashincomecategory', 'cashincomecategory.id', 'cashincomesubcategory.cashincomecategory_id')
            ->leftJoin('patients', 'patients.id', 'ancillaryrequist.patients_id')
            ->groupBy('ancillaryrequist.patients_id')
            ->select('patients.id as pid', 'patients.last_name', 'patients.first_name', 'patients.middle_name',
                'patients.suffix', 'patients.birthday', 'cashincomesubcategory.sub_category', 'cashincomesubcategory.price',
                'ancillaryrequist.created_at');

            // sub query from derived table
            $queues = $charges
                ->where('patients.hospital_no', $request->search)
                ->orWhere('patients.barcode', $request->search)
                ->orWhere(DB::raw("CONCAT(patients.last_name,' ',patients.first_name)"),
                    'LIKE', '%'.$request->search.'%')
                ->paginate(50);*/

            $start =  $request->start;
            $end =  $request->end;

            return view('OPDMS.reception.charged_patients', compact('queues', 'start', 'end'));

    }


}
