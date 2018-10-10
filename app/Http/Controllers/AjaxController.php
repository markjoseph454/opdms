<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\JsonableInterface;
use App\Patient;
use App\Consultation;
use App\MedInterns;
use App\Requisition;
use App\User;
use App\Approval;
use DB;
use Session;
use Carbon;
use Validator;
use Auth;

class AjaxController extends Controller
{

    public function getAuth()
    {
        echo json_encode(Auth::user()->id);
        return;
    }


    public function approval($pid, $did)
    {
        $approval = new Approval();
        $approval->patients_id = $pid;
        $approval->interns_id = Auth::user()->id;
        $approval->approved_by = $did;
        $approval->save();
        return redirect()->back()->with('toaster', array('success', 'Request for approval has been submited.'));
    }

    public function forApprovals()
    {
        $approvals = Approval::where('approved_by', '=', Auth::user()->id)
                                ->whereDate('approvals.created_at', '=', Carbon::now()->toDateString())
                                ->leftJoin('patients as pt', 'pt.id', '=', 'approvals.patients_id')
                                ->leftJoin('users as us', 'us.id', '=', 'approvals.interns_id')
                                ->select('approvals.id as approvalid', 'approvals.approved', 'pt.id as pid', 'pt.birthday', DB::raw("CONCAT(pt.last_name,' ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN pt.middle_name ELSE '' END) as name"), DB::raw("CONCAT(CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END,' ',CASE WHEN us.middle_name IS NOT NULL THEN LEFT(us.middle_name, 1) ELSE '' END,'.',' ',CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END) as doctorsname"))
                                ->groupBy('approvals.patients_id')
                                ->get();
        return view('doctors.forApproval', compact('approvals'));
    }


    public function markAsApproved($approvalID)
    {
        Approval::find($approvalID)->update(['approved'=>'Y']);
        return redirect()->back()->with('toaster', array('success', 'Patient has been approved'));
    }

    public function markAsUnApproved($approvalID)
    {
        Approval::find($approvalID)->update(['approved'=>'N']);
        return redirect()->back()->with('toaster', array('error', 'Patient has been declined'));
    }

    public function approvalMedicalRecords(Request $request)
    {
        $history = DB::select("SELECT pt.id, CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name, C.consultations, R.refferals, F.followups, COUNT(RQ.requisitions) as requisitions, 
                    U.ultra as ultrasound, X.xray as xray, L.labs as lab, D.dental as dental FROM patients pt
                    LEFT JOIN (SELECT consultations.patients_id, COUNT(*) AS consultations FROM consultations GROUP BY consultations.patients_id)
                    as C ON pt.id = C.patients_id
                    LEFT JOIN (SELECT refferals.patients_id, COUNT(*) AS refferals FROM refferals GROUP BY refferals.patients_id)
                    as R ON pt.id = R.patients_id
                    LEFT JOIN (SELECT followup.patients_id, COUNT(*) AS followups FROM followup GROUP BY followup.patients_id)
                    as F ON pt.id = F.patients_id
                    LEFT JOIN (SELECT requisition.patients_id, COUNT(*) AS requisitions FROM requisition GROUP BY requisition.patients_id, requisition.modifier, DATE(requisition.created_at))
                    as RQ ON pt.id = RQ.patients_id
                    LEFT JOIN (SELECT an.patients_id, COUNT(*) AS ultra FROM ancillaryrequist as an LEFT JOIN cashincomesubcategory cs ON an.cashincomesubcategory_id = cs.id WHERE cs.cashincomecategory_id = 6 AND patients_id = $request->patient) as U ON U.patients_id = pt.id
                    LEFT JOIN (SELECT an.patients_id, COUNT(*) AS xray FROM ancillaryrequist as an LEFT JOIN cashincomesubcategory cs ON an.cashincomesubcategory_id = cs.id WHERE cs.cashincomecategory_id = 11 AND patients_id = $request->patient) as X ON X.patients_id = pt.id
                    LEFT JOIN (SELECT an.patients_id, COUNT(*) AS labs FROM ancillaryrequist as an LEFT JOIN cashincomesubcategory cs ON an.cashincomesubcategory_id = cs.id WHERE cs.cashincomecategory_id = 10 AND patients_id = $request->patient) as L ON L.patients_id = pt.id
                    LEFT JOIN (SELECT an.patients_id, COUNT(*) AS dental FROM ancillaryrequist as an LEFT JOIN cashincomesubcategory cs ON an.cashincomesubcategory_id = cs.id WHERE cs.cashincomecategory_id = 5 AND patients_id = $request->patient) as D ON D.patients_id = pt.id
                    WHERE pt.id = $request->patient");

        echo json_encode($history);
        return;
    }

    public function approvalConsultationList(Request $request)
    {
//        $consultations = Consultation::where('patients_id', '=', $request->patient)
//                            ->leftJoin('patients as pt', 'pt.id', '=', 'consultations.patients_id')
//                            ->leftJoin('clinics', 'clinics.id', '=', 'consultations.clinic_code')
//                            ->leftJoin('users as us', 'us.id', '=', 'consultations.users_id')
//                            ->leftJoin('industrial_forms as inf', function($join){
//                                $join->on('inf.patient_id', 'consultations.patients_id');
//                                $join->on(DB::raw("DATE(inf.created_at)"), DB::raw('DATE(consultations.created_at)'));
//                            })
////                            ->leftJoin('otpc_front', function($join) use ($request){
////                                $join->on('otpc_front.patient_id', 'pt.id');
////                                $join->where('otpc_front.patient_id', $request->patient);
////                                    $join->groupBy('otpc_front.patient_id');
////                            })
////                            ->leftJoin('childhood_care', function($join) use ($request){
////                                $join->on('childhood_care.patient_id', 'pt.id');
////                                $join->where('childhood_care.patient_id', $request->patient);
////                                $join->groupBy('childhood_care.patient_id');
////                            })
////                            ->leftJoin('kmc', function($join) use ($request){
////                                $join->on('kmc.patient_id', 'pt.id');
////                                $join->where('childhood_care.patient_id', $request->patient);
////                                $join->groupBy('kmc.patient_id');
////                            })
//                            ->select('consultations.*', 'clinics.name as clinic',
//                                DB::raw("CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name"),
//                                DB::raw("CONCAT(us.first_name,' ', CASE WHEN us.middle_name IS NOT NULL THEN LEFT(us.middle_name, 1) ELSE '' END,'.',' ',us.last_name) as doctor"), 'inf.id as inf_id',
//                                'otpc_front.id as otc_id', 'childhood_care.id as childhood_care_id', 'kmc.id as kmc_id')
//                            ->orderBy('consultations.created_at', 'DESC')->get();



        $consultations = DB::select("
                                SELECT consultations.*, clinics.name as clinic,
                                CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name,
                                CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as doctor,
                                inf.id as inf_id, O.otpc_pid as otc_pid, C.childhood_pid as childhood_pid, K.kmc_pid = kmc_pid
                                FROM consultations
                                LEFT JOIN patients as pt ON pt.id = consultations.patients_id
                                LEFT JOIN clinics ON clinics.id = consultations.clinic_code
                                LEFT JOIN users as us ON us.id = consultations.users_id
                                LEFT JOIN industrial_forms as inf ON inf.patient_id = consultations.patients_id AND DATE(inf.created_at) = DATE(consultations.created_at)
                                LEFT JOIN (SELECT otpc_front.patient_id as otpc_pid FROM otpc_front WHERE otpc_front.patient_id = $request->patient LIMIT 1) as O ON O.otpc_pid = consultations.patients_id
                                LEFT JOIN (SELECT childhood_care.patient_id as childhood_pid FROM childhood_care WHERE childhood_care.patient_id = $request->patient LIMIT 1) as C ON C.childhood_pid = consultations.patients_id
                                LEFT JOIN (SELECT kmc.patient_id as kmc_pid FROM kmc WHERE kmc.patient_id = $request->patient LIMIT 1) as K ON K.kmc_pid = consultations.patients_id
                                WHERE consultations.patients_id = $request->patient
                                ORDER BY consultations.created_at DESC
                        ");

        echo json_encode($consultations);
        return;
    }



    public function ajaxRequisitionList(Request $request)
    {
        $requisitions = Requisition::where('patients_id', '=', $request->patient)
                        ->leftJoin('patients as pt', 'pt.id', '=', 'requisition.patients_id')
                        ->leftJoin('users as us', 'us.id', '=', 'requisition.users_id')
                        ->leftJoin('clinics', 'clinics.id', '=', 'us.clinic')
                        ->groupBy('requisition.users_id', 'requisition.modifier', DB::raw("DATE(requisition.created_at)"))
                        ->orderBy('requisition.created_at', 'DESC')
                        ->select('requisition.*', 'clinics.name as clinic',
                            DB::raw("CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name"),
                            DB::raw("CONCAT(us.first_name,' ',CASE WHEN us.middle_name IS NOT NULL THEN LEFT(us.middle_name, 1) ELSE '' END,' ',us.last_name) as doctor"))
                        ->get();
        echo json_encode($requisitions);
        return;
    }




    public function ajaxRefferals(Request $request)
    {
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
                    WHERE rf.patients_id = $request->patient");
        echo json_encode($refferals);
        return;
    }



    public function ajaxFollowup(Request $request)
    {
        $followups = DB::select("SELECT ff.*, clinics.name as clinic, FD.fromDoctor, TD.toDoctor, CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name FROM followup ff
                        LEFT JOIN patients pt ON pt.id = ff.patients_id
                        LEFT JOIN clinics ON clinics.id = ff.clinic_code
                        LEFT JOIN (SELECT us.id, CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as fromDoctor FROM users us) as FD ON FD.id = ff.users_id
                        LEFT JOIN (SELECT usr.id, CONCAT(CASE WHEN usr.last_name IS NOT NULL THEN usr.last_name ELSE '' END,' ',LEFT(usr.middle_name, 1),'.',' ',CASE WHEN usr.first_name IS NOT NULL THEN usr.first_name ELSE '' END) as toDoctor FROM users usr ) as TD 
                        ON TD.id = ff.assignedTo
                        WHERE ff.patients_id = $request->patient");
        echo json_encode($followups);
        return;
    }


}
