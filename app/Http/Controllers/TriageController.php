<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Patient;
use App\Clinic;
use App\Triage;
use App\VitalSigns;
use App\Assignation;
use App\Mssclassification;
use App\Queue;
use Validator;
use Auth;
use Session;
use DB;
use Carbon\Carbon;



class TriageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('triage.scanbarcode');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'clinic_code' => 'required',
        ]);
        if ($validator->passes()) {
            $request->request->add(['users_id' => Auth::user()->id]);
            $triage = Triage::create($request->all());

            $vitalsigns = new VitalSigns();
            $vitalsigns->storeVitalSigns($request, $triage->id, $request->patients_id);

            // get the clinic receptionist id
            $user = User::where([
                        ['clinics.code', $request->clinic_code],
                        ['role', 5],
                    ])
                    ->leftJoin('clinics', 'clinics.id', 'users.clinic')
                    ->latest('users.created_at')
                    ->pluck('users.id')
                    ->first();

            if ($user){
                $user_id = $user;
            }else{
                $user_id = Auth::user()->id; // assign the triage user_id if receptionist does not exist
            }

            // get the clinic id
            $clinic_id = Clinic::where('code', $request->clinic_code)->pluck('id')->first();

            $checkQueueList = Queue::where('patients_id', '=', $request->patients_id)
                ->where('clinic_code', '=', $clinic_id)
                ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
                ->count();


            if ($checkQueueList <= 0){
                Queue::create([
                    'patients_id' => $request->patients_id,
                    'users_id' => $user_id,
                    'clinic_code' => $clinic_id,
                ]);
            }

            Session::flash('toaster', array('success', 'Triage successfully saved.'));
            return redirect('triage');
        }else{
            return redirect()->back()->withInput()->withErrors($validator);
        }
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


    public function barcode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required'
        ]);
        if($validator->passes()){
            $patient = Patient::where('barcode', $request->barcode)
                                ->orWhere('hospital_no', $request->barcode)
                                ->get()->first();
            if ($patient) {
                $checkIfClassified = Mssclassification::where('patients_id', '=', $patient->id)->first();
                if (count($checkIfClassified) > 0){
                    if ($checkIfClassified->validity < Carbon::now()){
                        Session::flash('danger', 'MSS Classification already expired at '.Carbon::parse($checkIfClassified->validity)->toFormattedDateString().'. Kindly advice the patient to proceed to MSS for Re-Classification.');
                    }
                }else{
                    Session::flash('danger', 'Patient is not yet MSS Classified. Kindly advice the patient to proceed to MSS for Classification.');
                }
                return redirect('triagehomepage/'.$patient->id);
            }else{
                Session::flash('toaster', array('error', 'Barcode wasn`t found in our records.'));
                return redirect()->back()->withInput();
            }
        }else{
            return redirect()->back()->withErrors($validator);
        }
    }


    public function triagehomepage($id)
    {
        $patient = Patient::find($id);
        $clinics = Clinic::orderBy('name')->get();
        $last_checkup = Queue::where('patients_id', $id)
                        ->leftJoin('clinics', 'clinics.id', 'queues.clinic_code')
                        ->select('clinics.id', 'clinics.name', 'queues.created_at')
                        ->latest('queues.created_at')->first();
        return view('triage.triage', compact('patient', 'clinics', 'last_checkup'));
    }


    public function search(Request $request)
    {
        if($request->name){
            $patients = DB::table('patients')
                        ->select('*')
                        ->where(DB::raw("CONCAT(last_name,' ',first_name,' ',middle_name)"), 'like', '%'.$request->name.'%')
                        ->get();
        }elseif ($request->birthday) {
            $patients = Patient::where('birthday', 'like', $request->birthday.'%')->get();
        }elseif ($request->barcode) {
            $patients = Patient::where('barcode', 'like', '%'.$request->barcode.'%')->get();
        }elseif ($request->hospital_no) {
            $patients = Patient::where('hospital_no', 'like', '%'.$request->hospital_no.'%')->get();
        }elseif ($request->created_at) {
            $patients = Patient::where('created_at', 'like', $request->created_at.'%')->get();
        }
        if (isset($patients) && count($patients) > 0) {
            Session::flash('toaster', array('success', 'Matching Records Found.'));
            return view('triage.search', compact('patients'));
        }
        Session::flash('toaster', array('error', 'No Matching Records Found.'));
        return redirect()->back();
    }


    public function triage_history($id = false)
    {
        $history = Assignation::where('patients_id', '=', $id)
                                ->leftJoin('users as us', function($join){
                                    $join->on('us.id', '=', 'assignations.doctors_id');
                                })
                                ->leftJoin('clinics', 'clinics.id', '=', 'assignations.clinic_code')
                                ->leftJoin('patients as pt', 'assignations.patients_id', '=', 'pt.id')
                                ->select('clinics.name as clinic', 'assignations.status', 'assignations.created_at', DB::raw("CONCAT(pt.last_name,' ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN pt.middle_name ELSE '' END) as name"), DB::raw("CONCAT(us.last_name,' ', us.first_name,'.',' ',LEFT(us.middle_name, 1)) as doctor"))
                                ->latest()->get();
        return view('triage.history', compact('history'));
    }




}
