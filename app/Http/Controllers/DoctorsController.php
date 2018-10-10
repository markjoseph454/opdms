<?php

namespace App\Http\Controllers;

use App\Followup;
use App\Refferal;
use App\User;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\JsonableInterface;
use App\Patient;
use App\Clinic;
use App\Assignation;
use App\VitalSigns;
use App\Serving;
use App\Consultation;
use App\FileManager;
use App\ConsultationsICD;
use App\MedInterns;
use App\Approval;
use DB;
use Session;
use Carbon;
use Validator;
use Auth;

class DoctorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $consultation = Consultation::find($id);
        $files = FileManager::where('consultations_id', '=', $id)->get();
        $patient = Patient::find($consultation->patients_id);
        $directory = '/PatientFiles/EVRMC-'.$patient->id.'-'.$patient->last_name.'/';

        $consultations_icds = ConsultationsICD::select('icd_codes.description')
                                ->leftJoin('icd_codes', 'icd_codes.id', '=', 'consultations_icd.icd')
                                ->where('consultations_id', '=', $consultation->id)->get();

        $checkIfForApproval = Approval::where('interns_id', '=', $consultation->users_id)
                                        ->where('approved_by', '=', Auth::user()->id)
                                        ->where('patients_id', '=', $consultation->patients_id)->first();

        return view('doctors.consultation_show', compact('consultation', 'files', 'directory', 'consultations_icds', 'patient', 'checkIfForApproval'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function patientlist($status = false)
    {

        $viewer = Consultation::find(153);

        $patients = DB::table('assignations')
                    ->select('assignations.*', 'pt.birthday', 'consultations.id as pcid', 'pt.id as pid',
                        DB::raw("CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name"), 'smokes.id as smoke')
                    ->leftJoin('patients as pt', 'pt.id', '=', 'assignations.patients_id')
                    ->leftJoin('smokes', 'smokes.patient_id', '=', 'pt.id')   /* smoke */
                    ->leftJoin('consultations', 'consultations.patients_id', '=', 'pt.id')
                    ->whereDate('assignations.created_at', Carbon::now()->format('Y-m-d'))
                    ->where('doctors_id', '=', Auth::user()->id)
                    ->groupBy('pt.id')
                    ->orderBy('assignations.created_at', 'ASC')
                    ->when($status == 'H', function ($query) use ($status){
                        return $query->where('status', $status);
                    })
                    ->when($status == 'C', function ($query) use ($status){
                        return $query->where('status', $status);
                    })
                    ->when($status == 'F', function ($query) use ($status){
                        return $query->where('status', $status);
                    })
                    ->when($status == 'S', function ($query) use ($status){
                        return $query->where('status', $status);
                    })
                    ->when($status == false, function ($query) use ($status){
                        return $query->whereIn('status', ['P','S']);
                    })
                    ->get();


        $checkServing = Assignation::checkServing();
        $arrayStatus = array('F', 'C', 'H');
        if ($checkServing){
            if (in_array($checkServing->status, $arrayStatus)){
                DB::table('servings')->where('id', '=', $checkServing->id)->delete();
                Session()->forget(['pid', 'modifier', 'modid', 'cid', 'freshForm']);
            }
        }


        $modifier = new Serving();
        $serving = $modifier->serving();

        $survey = DB::select("SELECT DISTINCT(SELECT COUNT(*) FROM assignations asgn WHERE doctors_id = ".Auth::user()->id."
                    AND DATE(asgn.created_at) = CURDATE() AND status = 'P') AS pending,(SELECT COUNT(*) FROM assignations asgn WHERE doctors_id = ".Auth::user()->id."
                    AND DATE(asgn.created_at) = CURDATE() AND status = 'F') as finished,(SELECT COUNT(*) FROM assignations asgn WHERE doctors_id = ".Auth::user()->id."
                    AND DATE(asgn.created_at) = CURDATE() AND status = 'C') as nawc,(SELECT COUNT(*) FROM assignations asgn WHERE doctors_id = ".Auth::user()->id."
                    AND DATE(asgn.created_at) = CURDATE() AND status = 'H') as paused,(SELECT COUNT(*) FROM assignations asgn WHERE doctors_id = ".Auth::user()->id."
                    AND DATE(asgn.created_at) = CURDATE() AND status = 'S') as serving FROM assignations asgn WHERE doctors_id = ".Auth::user()->id."
                    AND DATE(asgn.created_at) = CURDATE()");

        return view('doctors.patientlist', compact('patients', 'serving', 'survey', 'status', 'viewer'));
    }

    public function patient_info($id = false)
    {
        $patient =  DB::table('patients')
                    ->leftJoin('mssclassification as mc', 'mc.patients_id', '=', 'patients.id')
                    ->leftJoin('mss', 'mss.id', '=', 'mc.mss_id')
                    ->select('patients.*', 'mss.label', 'mss.discount')
                    ->where('patients.id', '=', $id)
                    ->first();
        $vital_signs = VitalSigns::where('patients_id', '=', $id)->whereDate('created_at', Carbon::now()->format('Y-m-d'))->latest()->get();

        /*$refferals = Refferal::select('refferals.*', 'clinics.name', DB::raw("CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as doctorsname"))
            ->where('patients_id', '=', $id)
            ->where('to_clinic', '=', Auth::user()->clinic)
            ->where('status', '=', 'P')
            ->leftJoin('users as us', 'us.id', '=', 'refferals.users_id')
            ->leftJoin('clinics', function ($join){
                $join->on('clinics.id', '=', 'refferals.from_clinic');
            })->get();*/

        $refferals = DB::select("SELECT rf.*, FD.fromDoctor, TD.toDoctor, FC.fromClinic, TC.toClinic, 
                    CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name 
                    FROM refferals rf 
                    LEFT JOIN (SELECT us.id as fdid, CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as fromDoctor FROM users us ) as FD 
                    ON FD.fdid = rf.users_id 
                    LEFT JOIN (SELECT usr.id as tdid, CONCAT(CASE WHEN usr.last_name IS NOT NULL THEN usr.last_name ELSE '' END,' ',LEFT(usr.middle_name, 1),'.',' ',CASE WHEN usr.first_name IS NOT NULL THEN usr.first_name ELSE '' END) as toDoctor FROM users usr ) as TD 
                    ON TD.tdid = rf.assignedTo 
                    LEFT JOIN (SELECT fclinic.id as fcid, fclinic.name as fromClinic FROM clinics fclinic) as FC ON FC.fcid = rf.from_clinic 
                    LEFT JOIN (SELECT tclinic.id as tcid, tclinic.name as toClinic FROM clinics tclinic) as TC ON TC.tcid = rf.to_clinic
                    LEFT JOIN patients pt ON pt.id = rf.patients_id
                    WHERE rf.patients_id = $id AND rf.to_clinic = ".Auth::user()->clinic." AND rf.status = 'P' ");


        $followups = Followup::select('followup.*', 'clinics.name', DB::raw("CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as doctorsname"))
            ->where('patients_id', '=', $id)
            ->where('status', '=', 'P')
            ->where('clinic_code', '=', Auth::user()->clinic)
            ->leftJoin('users as us', 'us.id', '=', 'assignedTo')
            ->leftJoin('clinics', 'clinics.id', '=', 'followup.clinic_code')
            ->get();

        return view('doctors.patientinfo', compact('patient', 'vital_signs', 'refferals', 'followups'));
    }

    public function startConsultation(Request $request, $id = false)
    {
        $modifier = new Serving();
        $serving = $modifier->serving();

        //check if this patient was been reffered to this clinic
        $refferal = Refferal::checkRefferal($id);
        $followup = Followup::checkFollowup($id);
        if (count($serving) > 0) {
            Session::flash('toaster', array('error', 'Please finish the patient you are currently serving.'));
            return redirect('patientlist');
        }else{
            $modifier->storeServing($id);
            Session::flash('toaster', array('info', 'You may start the consultation.'));
            if (!empty($refferal)){
                Session::flash('toaster', array('info', 'This patient has a pending refferal to this clinic.'));
            }
            if (!empty($followup)){
                Session::flash('toaster', array('info', 'This patient has a pending followup schedule to this clinic.'));
            }
            return redirect('consultation');
        }
    }


    public function endConsultation(Request $request)
    {
        Refferal::updateRefferal();
        Followup::updateFollowup();
        Serving::endConsultation($request);
        $request->session()->forget('cid');
        $request->session()->forget('freshForm');
        Session::flash('toaster', array('info', 'Consultation Finished'));
        return redirect('patientlist');
    }


    public function patientinformation(Request $request)
    {
        $pid = $request->session()->get('pid');
        $patient =  DB::table('patients')
                            ->leftJoin('mssclassification as mc', 'mc.patients_id', '=', 'patients.id')
                            ->leftJoin('mss', 'mss.id', '=', 'mc.mss_id')
                            ->select('patients.*', 'mss.label', 'mss.discount')
                            ->where('patients.id', '=', $pid)
                            ->first();

        $refferals = Refferal::select('refferals.*', 'clinics.name', DB::raw("CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as doctorsname"))
                                ->where('patients_id', '=', $pid)
                                ->where('to_clinic', '=', Auth::user()->clinic)
                                ->where('status', '=', 'P')
                                ->leftJoin('users as us', 'us.id', '=', 'assignedTo')
                                ->leftJoin('clinics', function ($join){
                                    $join->on('clinics.id', '=', 'refferals.to_clinic');
                                })->get();

        $followups = Followup::select('followup.*', 'clinics.name', DB::raw("CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as doctorsname"))
                                    ->where('patients_id', '=', $pid)
                                    ->where('status', '=', 'P')
                                    ->where('clinic_code', '=', Auth::user()->clinic)
                                    ->leftJoin('users as us', 'us.id', '=', 'assignedTo')
                                    ->leftJoin('clinics', 'clinics.id', '=', 'followup.clinic_code')
                                    ->get();
        return view('doctors.patientinformation', compact('patient', 'refferals', 'followups'));
    }


    public function history($id = false)
    {
        $history = DB::select("SELECT pt.id, CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name, C.consultations, R.refferals, F.followups, COUNT(RQ.requisitions) as requisitions, D.diagnosis FROM patients pt
                    LEFT JOIN (SELECT consultations.patients_id, COUNT(*) AS consultations FROM consultations GROUP BY consultations.patients_id)
                    as C ON pt.id = C.patients_id
                    LEFT JOIN (SELECT refferals.patients_id, COUNT(*) AS refferals FROM refferals GROUP BY refferals.patients_id)
                    as R ON pt.id = R.patients_id
                    LEFT JOIN (SELECT followup.patients_id, COUNT(*) AS followups FROM followup GROUP BY followup.patients_id)
                    as F ON pt.id = F.patients_id
                    LEFT JOIN (SELECT requisition.patients_id, COUNT(*) AS requisitions FROM requisition GROUP BY requisition.patients_id, requisition.modifier, DATE(requisition.created_at))
                    as RQ ON pt.id = RQ.patients_id
                    LEFT JOIN (SELECT diagnosis.patients_id, COUNT(*) AS diagnosis FROM diagnosis GROUP BY diagnosis.patients_id)
                    as D ON pt.id = D.patients_id
                    WHERE pt.id = $id");
        return view('doctors.history', compact('history'));
    }


    public function consultation_list($id = false)
    {
        $consultations = Consultation::where('patients_id', '=', $id)
                                        ->leftJoin('patients as pt', 'pt.id', '=', 'consultations.patients_id')
                                        ->leftJoin('clinics', 'clinics.id', '=', 'consultations.clinic_code')
                                        ->leftJoin('users as us', 'us.id', '=', 'consultations.users_id')
                                        ->select('consultations.*', 'clinics.name as clinic', DB::raw("CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name"), DB::raw("CONCAT(us.first_name,' ', LEFT(us.middle_name, 1),'.',' ',us.last_name) as doctor"))
                                        ->orderBy('consultations.created_at', 'DESC')->get();
        $clinics = Clinic::orderBy('name')->get();

        return view('doctors.consultation_list', compact('consultations', 'clinics'));
    }

    public function review($id = false)
    {
        $clinic_code = Auth::user()->clinic;
        $uid = Auth::user()->id;

        $review = DB::select("SELECT pt.id, CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name, C.consultations, R.refferals, F.followups, COUNT(RQ.requisitions) as requisitions, D.diagnosis FROM patients pt

                    LEFT JOIN (SELECT consultations.patients_id, COUNT(*) AS consultations FROM consultations WHERE consultations.patients_id = $id AND consultations.clinic_code = $clinic_code AND consultations.users_id = $uid and DATE(consultations.created_at) = CURDATE())
                    as C ON pt.id = C.patients_id

                    LEFT JOIN (SELECT refferals.patients_id, COUNT(*) AS refferals FROM refferals WHERE refferals.patients_id = $id AND refferals.from_clinic = $clinic_code AND refferals.users_id = $uid and DATE(refferals.created_at) = CURDATE())
                    as R ON pt.id = R.patients_id
                    LEFT JOIN (SELECT followup.patients_id, COUNT(*) AS followups FROM followup WHERE followup.patients_id = $id AND followup.clinic_code = $clinic_code AND followup.users_id = $uid and DATE(followup.created_at) = CURDATE())
                    as F ON pt.id = F.patients_id
                    LEFT JOIN (SELECT requisition.patients_id, COUNT(*) AS requisitions FROM requisition WHERE requisition.patients_id = $id AND requisition.users_id = $uid and DATE(requisition.created_at) = CURDATE() GROUP BY requisition.patients_id, DATE(requisition.created_at))
                    as RQ ON pt.id = RQ.patients_id
                    LEFT JOIN (SELECT diagnosis.patients_id, COUNT(*) AS diagnosis FROM diagnosis GROUP BY diagnosis.patients_id)
                    as D ON pt.id = D.patients_id
                    WHERE pt.id = $id");

        return view('doctors.review', compact('review'));
    }



    public function review_consultation_list($id = false)
    {
        $consultations = Consultation::where('patients_id', '=', $id)
            ->where('consultations.users_id', '=', Auth::user()->id)
            ->where('consultations.clinic_code', '=', Auth::user()->clinic)
            ->whereDate('consultations.created_at', '=', Carbon::today()->toDateString())
            ->leftJoin('patients as pt', 'pt.id', '=', 'consultations.patients_id')
            ->leftJoin('clinics', 'clinics.id', '=', 'consultations.clinic_code')
            ->leftJoin('users as us', 'us.id', '=', 'consultations.users_id')
            ->select('consultations.*', 'clinics.name as clinic', DB::raw("CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name"), DB::raw("CONCAT(us.first_name,' ', LEFT(us.middle_name, 1),'.',' ',us.last_name) as doctor"))
            ->get();
        return view('doctors.review_consultation_list', compact('consultations'));
    }


    public function diseases()
    {
        return view('doctors.diseases');
    }

    public function cancelPatient($id = false){
        Assignation::find($id)->update(['status'=>'C']);
        return redirect()->back()->with('toaster', array('error', 'Patient has been canceled.'));
    }

    public function restorePatient($id = false){
        Assignation::find($id)->update(['status'=>'P']);
        return redirect()->back()->with('toaster', array('info', 'Patient has been restored.'));
    }



    public function pausePatient(Request $request, $id = false)
    {
        $assignation = Serving::where('doctors_id', '=', Auth::user()->id)
                                ->whereDate('created_at', Carbon::now()->toDateString())
                                ->first();
        if ($assignation){
            Assignation::find($assignation->assignations_id)->update(['status'=>'H']);
            Serving::find($assignation->id)->delete();
            $request->session()->forget(['pid', 'modifier', 'modid', 'cid', 'freshForm']);
        }

        /*$assignation = Serving::find(Session::get('modid'));
        Assignation::find($assignation->assignations_id)
                        ->update(['status'=>'H']);
        Serving::find(Session::get('modid'))->delete();*/

        return redirect()->back()->with('toaster', array('info', 'Patient has been paused.'));
    }

    public function stopConsultation($id)
    {
        $assignation = Assignation::where('patients_id', '=', $id)
                            ->where('doctors_id', '=', Auth::user()->id)
                            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                            ->update(['status'=>'F']);
        return redirect()->back()->with('toaster', array('error', 'Patient has been stoped.'));
    }

    public function reConsult(Request $request, $id = false)
    {
        $modifier = new Serving();
        $serving = $modifier->serving();
        $assignations = Assignation::find($id);
        if (count($serving) > 0) {
            Session::flash('toaster', array('error', 'Please finish the patient you are currently serving.'));
            return redirect('patientlist');
        }else{
            $modifier->storeServing($assignations->patients_id);
            $request->session()->forget('cid');
            $request->session()->forget('freshForm');
            Session::flash('toaster', array('info', 'You may now re-consult this patient.'));
            return redirect('consultation');
        }
    }


    public function continueServing($id = false)
    {
        $modifier = new Serving();
        $serving = $modifier->serving();
        $assignations = Assignation::find($id);
        if (count($serving) > 0) {
            Session::flash('toaster', array('error', 'Please finish the patient you are currently serving.'));
            return redirect('patientlist');
        }else{
            $modifier->storeServing($assignations->patients_id);
            Session::flash('toaster', array('info', 'You may now continue the consultation of this patient.'));
            return redirect('consultation');
        }
    }








}
