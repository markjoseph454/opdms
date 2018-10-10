<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Mss;
use App\Mssclassification;
use App\Mssdiagnosis;
use App\Mssexpenses;
use App\Msshouseexpenses;
use App\Mssfamily;
use App\User;
use App\Mssbatch;
use Validator;
use DB;
use Auth;
use Carbon\Carbon;
use Session;


class MssController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('mss.scan');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $id = Mssclassification::create($request->all());
      $request->request->add(['classification_id' => $id->id]);

      $diagnosis = new Mssdiagnosis();
      $columns = $diagnosis->getColumn();
      $mssDiagnosis = false;
      foreach ($columns as $row) {

          if ($request->$row && $row != 'classification_id') {
                $mssDiagnosis = true;
          }
      }
      if ($mssDiagnosis) {
        $mssid =  Mssdiagnosis::create($request->all());
      }

      $expenses = new Mssexpenses();
      $expcolumns = $expenses->getColumn();
      $mssexpenses = false;
      foreach ($expcolumns as $row) {

          if ($request->$row && $row != 'classification_id') {
                $mssexpenses = true;
          }
      }
      if ($mssexpenses) {
         Mssexpenses::create($request->all());
      }

      if ($request->houselot != "" || $request->light != "" || $request->water != "" || $request->fuel != "") {
         $houseexp = new Msshouseexpenses();
         $houseexp->classification_id = $id->id;
         $houseexp->monthly_expenses = $request->monthly_expenses;
         $houseexp->monthly_expenditures = $request->monthly_expenditures;
         $houseexp->houselot = $request->houselot."-".$request->H_php;
         $houseexp->light = $request->light."-".$request->L_php;
         $houseexp->water = $request->water."-".$request->W_php;
         $houseexp->fuel = $request->fuel."-".$request->F_php;
         $houseexp->save();
      }
      foreach ($request->name as $key => $u) {
        $family = new Mssfamily();
          if ($request->name[$key] != "") {
          $family->patient_id = $request->patients_id;
          $family->name = $request->name[$key];
          $family->age = $request->age[$key];
          $family->status = $request->status[$key];
          $family->relationship = $request->relationship[$key];
          $family->feducation = $request->feducation[$key];
          $family->foccupation = $request->foccupation[$key];
          $family->fincome = $request->fincome[$key];
          $family->save();
          }
      }
      $request->session()->flash('toaster', array('success', 'Patient Classification Saved'));
      return view('mss.scan');
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $view = DB::table('patients')
            ->leftJoin('mssclassification', 'mssclassification.patients_id', '=', 'patients.id')
            ->leftJoin('mssdiagnosis', 'mssclassification.id', '=', 'mssdiagnosis.classification_id')
            ->leftJoin('mssexpenses', 'mssclassification.id', '=', 'mssexpenses.classification_id')
            ->leftJoin('msshouseexpenses', 'mssclassification.id', '=', 'msshouseexpenses.classification_id')
            ->leftJoin('mss', 'mssclassification.mss_id', '=', 'mss.id')
            ->where('mssclassification.id', '=', $id)
            ->get()
            ->first();
      $family = Mssfamily::where('patient_id', $view->patients_id)->get();
      $mss = DB::select("SELECT * FROM mss WHERE id NOT IN(10,11,12,13,14,15)");
      $ids = $id;

      return view('mss.edit', compact('view', 'family', 'mss', 'ids'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $request->request->add(['classification_id' => $id]);
      $mssclassification = Mssclassification::find($id);
      // dd(Carbon::now()->format('Y-m-d H:i:s'));
      if ($mssclassification->validity < Carbon::now()->format('Y-m-d')) {
        $batch = Mssbatch::where('patient_id', '=', $mssclassification->patients_id)->orderByDesc('created_at')->first();
        if (!$batch) {
          $batch = new Mssbatch();
        }
        $mssbatch = new Mssbatch();
        $mssbatch->patient_id = $mssclassification->patients_id;
        $mssbatch->users_id = $mssclassification->users_id;
        $mssbatch->mss_id = $mssclassification->mss_id;
        $mssbatch->referral = $mssclassification->referral;
        $mssbatch->sectorial = $mssclassification->sectorial;
        $mssbatch->fourpis = $mssclassification->fourpis;
        $mssbatch->batch_no = ($batch->batch_no + 1);
        $mssbatch->created_at = $mssclassification->created_at;
        $mssbatch->save();
        $date = Carbon::now();
        $request->request->add(['created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        $request->request->add(['validity' => Carbon::parse($date->addYear())->format('Y-m-d')]);
      }
      
      $mssclassification->fill($request->all());
      $mssclassification->save();
      $mssDiagnosis = Mssdiagnosis::where('classification_id', $id)->get()->first();
      if ($mssDiagnosis) 
      {
        $mssDiagnosis->fill($request->all());
        $mssDiagnosis->save();
      }
      else
      {
        $diagnosis = new Mssdiagnosis();
        $columns = $diagnosis->getColumn();
        $mssDiagnos = false;
        foreach ($columns as $row) {
            if ($request->$row && $row != 'classification_id')
            {
                  $mssDiagnos = true;
            }
        }
        if ($mssDiagnos)
        {
          Mssdiagnosis::create($request->all());
        }
      }
      $Mssexpenses = Mssexpenses::where('classification_id', $id)->get()->first();
      if ($Mssexpenses) 
      {
        $Mssexpenses->fill($request->all());
        $Mssexpenses->save();
      }
      else
      {
        $expenses = new Mssexpenses();
        $excolumns = $expenses->getColumn();
        $mssExpense = false;
        foreach ($excolumns as $row) {
            if ($request->$row && $row != 'classification_id')
            {
                  $mssExpense = true;
            }
        }
        if ($mssExpense)
        {
          Mssexpenses::create($request->all());
        }
      }
      $Msshouseexpenses = Msshouseexpenses::where('classification_id', $id)->get()->first();
      if ($Msshouseexpenses) {
         $Msshouseexpenses->classification_id = $id;
         $Msshouseexpenses->monthly_expenses = $request->monthly_expenses;
         $Msshouseexpenses->monthly_expenditures = $request->monthly_expenditures;
         $Msshouseexpenses->houselot = $request->houselot."-".$request->H_php;
         $Msshouseexpenses->light = $request->light."-".$request->L_php;
         $Msshouseexpenses->water = $request->water."-".$request->W_php;
         $Msshouseexpenses->fuel = $request->fuel."-".$request->F_php;
         $Msshouseexpenses->save();
      }
      else
      {
        if ($request->houselot != "" || $request->light != "" || $request->water != "" || $request->fuel != "") {
         $houseexp = new Msshouseexpenses();
         $houseexp->classification_id = $id;
         $houseexp->monthly_expenses = $request->monthly_expenses;
         $houseexp->monthly_expenditures = $request->monthly_expenditures;
         $houseexp->houselot = $request->houselot."-".$request->H_php;
         $houseexp->light = $request->light."-".$request->L_php;
         $houseexp->water = $request->water."-".$request->W_php;
         $houseexp->fuel = $request->fuel."-".$request->F_php;
         $houseexp->save();
        }
      }
     
      foreach ($request->name as $key => $u) {

          if ($request->id[$key]) {
            //echo "sldjsl";
            $mssfamily = Mssfamily::find($request->id[$key]);
            $mssfamily->patient_id = $request->patients_id;
            $mssfamily->name = $request->name[$key];
            $mssfamily->age = $request->age[$key];
            $mssfamily->status = $request->status[$key];
            $mssfamily->relationship = $request->relationship[$key];
            $mssfamily->feducation = $request->feducation[$key];
            $mssfamily->foccupation = $request->foccupation[$key];
            $mssfamily->fincome = $request->fincome[$key];
            $mssfamily->save();
          }
          else{
            $family = new Mssfamily();
            if ($request->name[$key] != "") {
            $family->patient_id = $request->patients_id;
            $family->name = $request->name[$key];
            $family->age = $request->age[$key];
            $family->status = $request->status[$key];
            $family->relationship = $request->relationship[$key];
            $family->feducation = $request->feducation[$key];
            $family->foccupation = $request->foccupation[$key];
            $family->fincome = $request->fincome[$key];
            $family->save();
            }
          }
      }
      $request->session()->flash('toaster', array('success', 'Patient Classification Updated'));
      return redirect('mss');
      

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      

    }

    public function classification(Request $request)
    {
      $patient = Patient::where('barcode', '=', $request->barcode)
                ->orWhere('hospital_no', '=', $request->barcode)->get()->first();
      if ($patient) {
        $check = Mssclassification::where('patients_id', '=', $patient->id)->first();
        if ($check) {
          $view = DB::table('patients')
                ->leftJoin('mssclassification', 'mssclassification.patients_id', '=', 'patients.id')
                ->leftJoin('mssdiagnosis', 'mssclassification.id', '=', 'mssdiagnosis.classification_id')
                ->leftJoin('mssexpenses', 'mssclassification.id', '=', 'mssexpenses.classification_id')
                ->leftJoin('msshouseexpenses', 'mssclassification.id', '=', 'msshouseexpenses.classification_id')
                ->leftJoin('mss', 'mssclassification.mss_id', '=', 'mss.id')
                ->where('mssclassification.id', '=', $check->id)
                ->get()
                ->first();
          $family = Mssfamily::where('patient_id', $view->patients_id)->get();
          $mss = DB::select("SELECT * FROM mss WHERE id NOT IN(10,11,12,13,14,15)");
          $ids = $check->id;
          
          return view('mss.edit', compact('view', 'family', 'mss', 'ids'));
        }else{
          $mss = DB::select("SELECT * FROM mss WHERE id NOT IN(10,11,12,13,14,15)");
          return view('mss.classification', compact('patient', 'mss'));
        }
      }else{
        return redirect()->back()->with('toaster', array('error', 'Patient not found.'));
      }
    }

    public function classified(Request $request)
    {
      if ($request->from != "" && $request->to != "") {
          $classified = DB::select("SELECT b.hospital_no, CONCAT(b.last_name,' ',b.first_name, ' ',b.middle_name) as patient,
                                b.address, b.birthday, b.sex, CONCAT(d.label,'-',d.description) as mss, 
                                CONCAT(c.last_name, ' ',c.first_name, ' ',c.middle_name) as users,
                                a.id,
                                a.created_at,
                                a.referral
                                -- e.id as mlks_id
                                FROM mssclassification a 
                                LEFT JOIN patients b ON a.patients_id = b.id 
                                LEFT JOIN users c ON a.users_id = c.id
                                LEFT JOIN mss d ON a.mss_id = d.id
                                -- LEFT JOIN malasakit e ON a.id = e.classification_id
                                WHERE DATE(a.created_at) 
                                BETWEEN ? AND ?
                                AND 
                                (CASE 
                                  WHEN ? != ''
                                  THEN a.mss_id = ?
                                  ELSE a.mss_id IN(SELECT id FROM mss)  
                                END) 
                                ", [$request->from, $request->to, $request->id, $request->id]);
          $tab = DB::select("SELECT COUNT(*) as counts, a.mss_id, b.* 
                                FROM mssclassification a 
                                LEFT JOIN mss b ON a.mss_id = b.id
                                WHERE DATE(created_at) 
                                BETWEEN ? AND  ?
                                GROUP BY a.mss_id  
                                ", [$request->from, $request->to]);
      }elseif ($request->hospital_no != "" || $request->name  != "") {
        if ($request->name != "") {
          $classified = DB::select("SELECT b.hospital_no, CONCAT(b.last_name,' ',b.first_name, ' ',b.middle_name) as patient,
                                b.address, b.birthday, b.sex, CONCAT(d.label,'-',d.description) as mss, 
                                CONCAT(c.last_name, ' ',c.first_name, ' ',c.middle_name) as users,
                                a.id,
                                a.created_at,
                                a.referral
                                -- e.id as mlks_id
                                FROM mssclassification a 
                                LEFT JOIN patients b ON a.patients_id = b.id 
                                LEFT JOIN users c ON a.users_id = c.id
                                LEFT JOIN mss d ON a.mss_id = d.id
                                -- LEFT JOIN malasakit e ON a.id = e.classification_id
                                WHERE b.hospital_no = ? 
                                OR CONCAT(b.last_name,' ',b.first_name, ' ',b.middle_name) LIKE ?
                                AND 
                                (CASE 
                                  WHEN ? != ''
                                  THEN a.mss_id = ?  
                                  ELSE a.mss_id IN(SELECT id FROM mss)  
                                END)
                                ", [$request->hospital_no, "%".$request->name."%", $request->id, $request->id]);
          $tab = DB::select("SELECT COUNT(a.mss_id) as counts, a.mss_id, d.*
                                FROM mssclassification a 
                                LEFT JOIN patients b ON a.patients_id = b.id 
                                LEFT JOIN mss d ON a.mss_id = d.id
                                WHERE b.hospital_no = ? 
                                OR CONCAT(b.last_name,' ',b.first_name, ' ',b.middle_name) LIKE ?
                                GROUP BY a.mss_id  
                                ", [$request->hospital_no, "%".$request->name."%"]);
        }else{
          $classified = DB::select("SELECT b.hospital_no, CONCAT(b.last_name,' ',b.first_name, ' ',b.middle_name) as patient,
                        b.address, b.birthday, b.sex, CONCAT(d.label,'-',d.description) as mss, 
                        CONCAT(c.last_name, ' ',c.first_name, ' ',c.middle_name) as users,
                        a.id,
                        a.created_at,
                        a.referral
                        -- e.id as mlks_id
                        FROM mssclassification a 
                        LEFT JOIN patients b ON a.patients_id = b.id 
                        LEFT JOIN users c ON a.users_id = c.id
                        LEFT JOIN mss d ON a.mss_id = d.id
                        -- LEFT JOIN malasakit e ON a.id = e.classification_id
                        WHERE b.hospital_no LIKE ? 
                        AND 
                          (CASE 
                            WHEN ? != ''
                            THEN a.mss_id = ?  
                            ELSE a.mss_id IN(SELECT id FROM mss)  
                          END)
                        ", ["%".$request->hospital_no."%", $request->id, $request->id]);
          $tab = DB::select("SELECT COUNT(a.mss_id) as counts, a.mss_id, d.*
                                FROM mssclassification a 
                                LEFT JOIN patients b ON a.patients_id = b.id 
                                LEFT JOIN mss d ON a.mss_id = d.id
                                WHERE b.hospital_no = ? 
                                GROUP BY a.mss_id  
                                ", [$request->hospital_no]);
        }
      }else{
        $classified = DB::select("SELECT b.hospital_no, CONCAT(b.last_name,' ',b.first_name, ' ',b.middle_name) as patient,
                      b.address, b.birthday, b.sex, CONCAT(d.label,'-',d.description) as mss, 
                      CONCAT(c.last_name, ' ',c.first_name, ' ',c.middle_name) as users,
                      a.id,
                      a.created_at,
                      a.referral
                      -- e.id as mlks_id
                      FROM mssclassification a 
                      LEFT JOIN patients b ON a.patients_id = b.id 
                      LEFT JOIN users c ON a.users_id = c.id
                      LEFT JOIN mss d ON a.mss_id = d.id
                      -- LEFT JOIN malasakit e ON a.id = e.classification_id
                      WHERE DATE(a.created_at) = CURRENT_DATE()
                      AND 
                          (CASE 
                            WHEN ? != ''
                            THEN a.mss_id = ? 
                            ELSE a.mss_id IN(SELECT id FROM mss)   
                          END)
                      ", [$request->id, $request->id]);
        $tab = DB::select("SELECT COUNT(*) as counts, a.mss_id, b.* 
                              FROM mssclassification a 
                              LEFT JOIN mss b ON a.mss_id = b.id
                              WHERE DATE(created_at) = CURRENT_DATE() 
                              GROUP BY a.mss_id  
                              ");
      }
      // dd($classified);
      return view('mss.classified', compact('classified', 'request', 'tab'));
    }
    public function classifiedbyday(Request $request)
    {
      $date = $request->date;
      $classified = DB::select("SELECT b.hospital_no, CONCAT(b.last_name,' ',b.first_name, ' ',b.middle_name) as patient,
                    b.address, b.birthday, b.sex, CONCAT(d.label,'-',d.description) as mss, 
                    CONCAT(c.last_name, ' ',c.first_name, ' ',c.middle_name) as users,
                    a.id,
                    a.created_at,
                    a.referral
                    FROM mssclassification a 
                    LEFT JOIN patients b ON a.patients_id = b.id 
                    LEFT JOIN users c ON a.users_id = c.id
                    LEFT JOIN mss d ON a.mss_id = d.id
                    WHERE DATE(a.created_at) = ?
                    ", [$request->date]);

      if ($classified != '[]'){
        Session::flash('toaster', array('success', 'Matching Records Found.'));
        return view('mss.classified', compact('classified', 'date'));
      }else{
        Session::flash('toaster', array('error', 'No Matching Records Found.'));
        return view('mss.classified', compact('classified', 'date'));
      }
      
    }
    public function view($id)
    {
      $view = DB::table('mssclassification')
            ->leftJoin('patients', 'mssclassification.patients_id', '=', 'patients.id')
            ->leftJoin('mssdiagnosis', 'mssclassification.id', '=', 'mssdiagnosis.classification_id')
            ->leftJoin('mssexpenses', 'mssclassification.id', '=', 'mssexpenses.classification_id')
            ->leftJoin('msshouseexpenses', 'mssclassification.id', '=', 'msshouseexpenses.classification_id')
            ->leftJoin('mss', 'mssclassification.mss_id', '=', 'mss.id')
            ->where('mssclassification.id', '=', $id)
            ->get()
            ->first();

      $family = Mssfamily::where('patient_id', $view->patients_id)->get();
      
      return view('mss.view', compact('view', 'family'));
    }
    public function search(Request $request)
    {
        if($request->name){
            $patients = DB::table('patients')
                        ->select('*')
                        ->leftjoin('mssclassification', 'patients.id', '=', 'mssclassification.patients_id' )
                        ->leftjoin('mss', 'mssclassification.mss_id', '=', 'mss.id')
                        ->where(DB::raw("CONCAT(first_name,' ',middle_name,' ',last_name)"), 'like', '%'.$request->name.'%')
                        ->get();
        }elseif ($request->birthday) {
            $patients = Patient::where('birthday', 'like', $request->birthday.'%')
            ->leftjoin('mssclassification', 'patients.id', '=', 'mssclassification.patients_id' )
            ->leftjoin('mss', 'mssclassification.mss_id', '=', 'mss.id')
            ->get();
        }elseif ($request->barcode) {
            $patients = Patient::where('barcode', 'like', '%'.$request->barcode.'%')
            ->leftjoin('mssclassification', 'patients.id', '=', 'mssclassification.patients_id' )
            ->leftjoin('mss', 'mssclassification.mss_id', '=', 'mss.id')
            ->get();
        }elseif ($request->hospital_no) {
            $patients = Patient::where('hospital_no', 'like', '%'.$request->hospital_no.'%')
            ->leftjoin('mssclassification', 'patients.id', '=', 'mssclassification.patients_id' )
            ->leftjoin('mss', 'mssclassification.mss_id', '=', 'mss.id')
            ->get();
        }elseif ($request->created_at) {
            $patients = Patient::where('patients.created_at', 'like', $request->created_at.'%')
            ->leftjoin('mssclassification', 'patients.id', '=', 'mssclassification.patients_id' )
            ->leftjoin('mss', 'mssclassification.mss_id', '=', 'mss.id')
            ->get();
        }
        if (isset($patients) && count($patients) > 0) {
            Session::flash('toaster', array('success', 'Matching Records Found.'));
            return view('mss.searchpatient', compact('patients'));
        }
        Session::flash('toaster', array('error', 'No Matching Records Found.'));
        return view('mss.searchpatient');
        
    }
    public function report()
    {
      $employee = DB::select("SELECT * FROM `users` 
                                WHERE `role` = 2 
                                AND `activated` = 'Y'
                                AND id NOT IN(136)
                              ");
      return view('mss.report', compact('employee'));
    }
    public function genaratedreport(Request $request)
    {
      $employee = User::find($request->users_id);
      return view('mss.generatedreport', ['controller' => $this], compact('request', 'employee'));
    }
    static function getreferringreport($exref, $users_id, $from, $to)
    {
        $data = DB::select("
              SELECT COUNT(referral) as result 
              FROM `mssclassification`
              WHERE  referral LIKE '$exref%'
              AND 
                (CASE
                  WHEN '$users_id' != 'ALL' THEN users_id = '$users_id' ELSE users_id = users_id 
                END)
              AND DATE(created_at) >= '$from'
              AND DATE(created_at) <= '$to'
              ");
        return $data;

    }
    static function getresultreferringperdistrict($excont, $users_id, $from, $to)
    {
      $data = DB::select("SELECT a.referral, a.mss_id
                                    FROM mssclassification a
                                    LEFT JOIN patients b ON a.patients_id = b.id
                                    LEFT JOIN refcitymun c ON b.city_municipality = c.citymunCode
                                    WHERE
                                    (CASE 
                                        WHEN '$excont' = 08
                                        THEN c.regDesc != 08
                                        ELSE c.id IN($excont)
                                    END) 
                                    AND DATE(a.created_at) 
                                    BETWEEN '$from' AND '$to'
                                    AND 
                                    (CASE 
                                        WHEN '$users_id' = 'ALL' 
                                        THEN a.users_id = a.users_id
                                        ELSE a.users_id = '$users_id'
                                    END)");
    // dd($data);
      return $data;
    }
   static function getplaceoforigin($explo, $users_id, $from, $to)
    {
      $data = DB::select("
              SELECT COUNT(*) as result
              FROM mssclassification a
              LEFT JOIN patients b ON a.patients_id = b.id
              LEFT JOIN refcitymun c ON b.city_municipality = c.citymunCode
              LEFT JOIN refprovince d ON c.provCode = d.provCode

              WHERE (CASE 
                      WHEN '$explo' = 'OUTSIDE R08'
                      THEN d.regCode != 08
                      ELSE  d.provDesc = '$explo'
                    END)
              AND 
                (CASE
                  WHEN '$users_id' != 'ALL' THEN a.users_id = '$users_id' ELSE a.users_id = a.users_id
                END)
              AND DATE(a.created_at) >= '$from' 
              AND DATE(a.created_at) <= '$to' 
              -- GROUP BY d.provDesc
              ");
      return $data;
    }
    static function getpatcategoryreport($excat, $users_id, $from, $to)
    {
      $data = DB::select("
              SELECT COUNT(category) as result 
              FROM `mssclassification` 
              WHERE category = '$excat' 
              AND 
                (CASE
                  WHEN '$users_id' != 'ALL' THEN users_id = '$users_id' ELSE users_id = users_id 
                END)
              AND DATE(created_at) >= '$from' 
              AND DATE(created_at) <= '$to'
              ");
      return $data;
    }
    static function getpatfuorpsreport($users_id, $from, $to)
    {
      $data = DB::select("
              SELECT fourpis, COUNT(fourpis) as result 
              FROM `mssclassification`
              WHERE
                (CASE
                  WHEN '$users_id' != 'ALL' THEN users_id = '$users_id' ELSE users_id = users_id 
                END) 
              AND DATE(created_at) >= '$from' 
              AND DATE(created_at) <= '$to' 
              GROUP BY(fourpis)");
      return $data;
    }
    static function getsectorialreport($exsect, $users_id, $from, $to)
    {
      $data = DB::select("
            SELECT COUNT(sectorial) as result 
            FROM `mssclassification`
            WHERE  
              (CASE 
                WHEN '$exsect' LIKE '%OTHERS%' THEN sectorial LIKE '%OTHERS%' ELSE sectorial = '$exsect'
              END) 
            AND 
              (CASE
                WHEN '$users_id' != 'ALL' THEN users_id = '$users_id' ELSE users_id = users_id 
              END)
            AND DATE(created_at) >= '$from'
            AND DATE(created_at) <= '$to'
            ");
      return $data;
    }
    static function getclassificationreport($users_id, $from, $to)
    {
      $data = DB::select("
            SELECT b.id, CONCAT(b.label, '-', b.description) as descs,
            (CASE WHEN COUNT(a.mss_id) <= 0 THEN '0' WHEN COUNT(a.mss_id) > 0 THEN COUNT(a.mss_id) END)  as classification_count
            FROM mss b
            LEFT JOIN mssclassification a ON a.mss_id = b.id
            AND 
              (CASE
                WHEN '$users_id' != 'ALL' THEN a.users_id = '$users_id' ELSE a.users_id = a.users_id 
              END) 
            AND DATE(a.created_at) >= '$from' 
            AND DATE(a.created_at) <= '$to'
            WHERE b.id NOT IN(14,15) 
            GROUP BY b.id, b.label, b.description
            ");
      return $data;
    }
    static function getresultperdistrict($excont, $users_id, $from, $to)
    {
      $data = DB::select("
            SELECT COUNT(*) as result
            FROM mssclassification a
            LEFT JOIN patients b ON a.patients_id = b.id
            LEFT JOIN refcitymun c ON b.city_municipality = c.citymunCode
            WHERE
              (CASE
                WHEN '$excont' = '08' THEN c.regDesc != '$excont' ELSE c.id IN($excont) 
              END) 
            AND 
              (CASE
              WHEN '$users_id' != 'ALL' THEN a.users_id = '$users_id' ELSE a.users_id = a.users_id 
            END)
            AND DATE(a.created_at) >= '$from' 
            AND DATE(a.created_at) <= '$to'
            AND a.mss_id IN(10,11,12,13)
            ");
      return $data;
    }
    
    public function migrate()
    {

     /*===============================================================================================================================*/
      $data = DB::select("SELECT * FROM mss.tbl_patient_classification WHERE patient_classification_id > 24062
              AND patient_classification_id NOT IN(24063) ORDER BY patient_classification_id  ASC
                ");
     

      foreach ($data as $list) {
        if ($list->patient_gender == 'FEMININE') {
          $patient_gender = 'F'; 
        }
        else{
          $patient_gender = 'M';  
        }
        if ($list->living_arrangement == 'owned') {
          $living_arrangement = 'O';
        }elseif ($list->living_arrangement == 'rented') {
          $living_arrangement = 'R';
        }elseif ($list->living_arrangement == 'shared') {
           $living_arrangement = 'S';
        
        }elseif ($list->living_arrangement == 'institution') {
           $living_arrangement = 'I';
        
        }elseif ($list->living_arrangement == 'homeless') {
           $living_arrangement = 'H';
        }
        elseif ($list->living_arrangement == ' ') {
           $living_arrangement = ' ';
        }
        if ($list->patient_category == 'old') {
            $patient_category = 'O';
        }elseif ($list->patient_category == 'new') {
            $patient_category = 'N';
        }
        elseif ($list->patient_category == 'close') {
            $patient_category = 'C';
        }
        if ($list->fourps == 'yes') {
          $fourps = 'Y';
        }
        else{
          $fourps = 'N';
        }
         $one = DB::insert("
          INSERT INTO opd.mssclassification (`id`,`patients_id`,`users_id`,`mss_id`,`mswd`, `referral`,`gender`, `civil_statuss`,`living_arrangement`,`education`,`occupation`,`category`,`fourpis`,`sectorial`,`household`,`duration`,`philhealth`,`membership`,`validity`,`created_at`,`updated_at`) VALUES 
          ('$list->patient_classification_id',
          '$list->patient_id',
          '$list->mss_id',
          '$list->classification_id',
          '$list->mswd_no',
          '".str_replace("'", '', $list->referral)."',
          '".str_replace("'", '', $patient_gender)."',
          '".str_replace("'", '', $list->civil_status)."',
          '".str_replace("'", '', $living_arrangement)."',
          '".str_replace("'", '', $list->educ_atmt)."',
          '".str_replace("'", '', $list->occupation)."',
          '$patient_category',
          '$fourps',
          '$list->sect_membership',
          '".str_replace("'", '', $list->household_size)."',
          '".str_replace("'", '', $list->duration_of_prob)."',
          '$list->philhealth',
          '$list->philhealth_category',
          '$list->classification_validity',
          '$list->date_of_interview',
          '$list->updated_at')");
        
        

         
          $two = DB::insert("
          INSERT INTO `mssdiagnosis`(`classification_id`, `medical`, `admitting`, `previus`, `present`, `final`, `health`, `findings`, `interventions`, `admision`, `planning`, `counseling`, `date_admission`, `companion`, `expinditures`, `insurance`) VALUES 
          ('$list->patient_classification_id',
          '".str_replace("'", '', $list->medical_data)."',
          '".str_replace("'", '', $list->admitting_diag)."',
          '".str_replace("'", '', $list->prev_treatment)."',
          '".str_replace("'", '', $list->pres_treatment)."',
          '".str_replace("'", '', $list->final_diag)."',
          '".str_replace("'", '', $list->health_access)."',
          '".str_replace("'", '', $list->assesment_findings)."',
          '".str_replace("'", '', $list->recommended_intventions)."',
          '".str_replace("'", '', $list->pre_addmission)."',
          '".str_replace("'", '', $list->discharge_planning)."',
          '".str_replace("'", '', $list->counseling)."',
          '".str_replace("'", '', $list->date_of_adm_cons)."',
          '".str_replace("'", '', $list->companion_adm)."',
          '".str_replace("'", '', $list->medical_expenditures)."',
          '".str_replace("'", '', $list->insurance_premium)."')
          ");

          $three = DB::insert("
          INSERT INTO `mssexpenses`(`classification_id`, `referral_addrress`, `referral_telno`, `religion`, `temp_address`, `pob`, `employer`, `income`, `capita_income`, `source_income`, `food`, `educationphp`, `clothing`, `transportation`, `house_help`, `internet`, `cable`, `other_expenses`) VALUES 
          ('$list->patient_classification_id',
          '".str_replace("'", '', $list->referral_address)."',
          '".str_replace("'", '', $list->referral_tel_no)."',
          '".str_replace("'", '', $list->religion)."',
          '".str_replace("'", '', $list->temp_address)."',
          '".str_replace("'", '', $list->place_of_Birth)."',
          '".str_replace("'", '', $list->employer)."',
          '".str_replace("'", '', $list->income)."',
          '".str_replace("'", '', $list->per_capita_income)."',
          '".str_replace("'", '', $list->sources_of_income)."',
          '".str_replace("'", '', $list->food)."',
          '".str_replace("'", '', $list->education)."',
          '".str_replace("'", '', $list->clothing)."',
          '".str_replace("'", '', $list->transportation)."',
          '".str_replace("'", '', $list->house_help)."',
          '".str_replace("'", '', $list->internet)."',
          '".str_replace("'", '', $list->cable)."',
          '".str_replace("'", '', $list->others_expinses)."')
          ");
          $four = DB::insert("
          INSERT INTO `msshouseexpenses`(`classification_id`, `monthly_expenses`, `monthly_expenditures`, `houselot`, `light`, `water`, `fuel`) VALUES 
          ('".str_replace("'", '', $list->patient_classification_id)."',
          '".str_replace("'", '', $list->monthly_expenses)."',
          '".str_replace("'", '', $list->monthly_expenditures)."',
          '".str_replace("'", '', $list->houseandlot)."',
          '".str_replace("'", '', $list->light_source)."',
          '".str_replace("'", '', $list->water_source)."',
          '".str_replace("'", '', $list->fuel_source)."')
          ");
       }
      /*===============================================================================================================================*/
       // $data = DB::select("SELECT * FROM mss.tbl_patient_family WHERE F_id >= 23596 ORDER BY F_id ASC
       //          ");
       // foreach ($data as $list) {
       //   $four = DB::insert("
       //             INSERT INTO `mssfamily`(`patient_id`, `name`, `age`, `status`, `relationship`, `feducation`, `foccupation`, `fincome`) VALUES 
       //             ('$list->patient_id',
       //             '".str_replace("'", '', $list->name)."',
       //             '".str_replace("'", '', $list->age)."',
       //             '$list->civil_status',
       //             '".str_replace("'", '', $list->relationship)."',
       //             '".str_replace("'", '', $list->educational_atmt)."',
       //             '".str_replace("'", '', $list->occupation)."',
       //             '".str_replace("'", '', $list->monthly_income)."')
       //             ");
       // }

        
    }
}