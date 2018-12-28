<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{

    public function referral_history(Request $request)
    {
        $refferals = DB::select("SELECT rf.*, FD.fromDoctor, TD.toDoctor, FC.fromClinic, TC.toClinic, 
                    CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,
                    ' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name 
                    FROM refferals rf 
                    LEFT JOIN (SELECT us.id as fdid, CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,
                    ' ',CASE WHEN us.middle_name IS NOT NULL THEN LEFT(us.middle_name, 1) ELSE '' END,'.',' ',
                    CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) 
                    as fromDoctor FROM users us ) as FD 
                    ON FD.fdid = rf.users_id 
                    LEFT JOIN (SELECT usr.id as tdid, CONCAT(CASE WHEN usr.last_name IS NOT NULL THEN usr.last_name ELSE '' END,
                    ' ',CASE WHEN usr.middle_name IS NOT NULL THEN LEFT(usr.middle_name, 1) ELSE '' END,'.',' ',
                    CASE WHEN usr.first_name IS NOT NULL THEN usr.first_name ELSE '' END) 
                    as toDoctor FROM users usr ) as TD 
                    ON TD.tdid = rf.assignedTo 
                    LEFT JOIN (SELECT fclinic.id as fcid, fclinic.name as fromClinic FROM clinics fclinic) as FC ON FC.fcid = rf.from_clinic 
                    LEFT JOIN (SELECT tclinic.id as tcid, tclinic.name as toClinic FROM clinics tclinic) as TC ON TC.tcid = rf.to_clinic
                    LEFT JOIN patients pt ON pt.id = rf.patients_id
                    WHERE rf.patients_id = ".$request->pid."
                    ORDER BY rf.created_at DESC");

        $clinics = DB::table('clinics')
            ->where('clinics.id', '<>', Auth::user()->clinic)
            ->orderBy('name')
            ->get();

        $data = ['referrals' => $refferals, 'clinics' => $clinics];

        echo json_encode($data);
        return;
    }


    public function referral_clinic_doctor(Request $request)
    {
        $doctors = DB::table('users')
                    ->where([
                        ['clinic', $request->clinic],
                        ['role', 7]
                    ])
                    ->orderBy('last_name')
                    ->get();
        echo json_encode($doctors);
        return;
    }


    public function referral_save(Request $request)
    {
        $data = DB::table('refferals')
                ->insert([
                    'patients_id' => $request->patient_id,
                    'users_id' => Auth::user()->id,
                    'reason' => $request->reason,
                    'from_clinic' => Auth::user()->clinic,
                    'to_clinic' => $request->to_clinic,
                    'assignedTo' => $request->doctor,
                ]);
        echo json_encode($data);
        return;
    }


    public function referral_delete(Request $request)
    {
        DB::table('refferals')
            ->where('id', $request->id)
            ->delete();
        return;
    }




}



















