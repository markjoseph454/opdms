<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Refferal;
use App\Followup;
use App\VitalSigns;
use Carbon\Carbon;
use Auth;
use DB;

class Consultation extends Model
{
    protected $table = "consultations";

    protected $fillable = [
        'patients_id', 'users_id', 'clinic_code', 'consultation'
    ];




    public static function refferals($id)
    {
        $pid = ($id)? $id : session('pid', '0');
        /*$refferals = Refferal::select('refferals.*', 'clinics.name', DB::raw("CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as doctorsname"))
            ->where('patients_id', '=', $pid)
            ->where('to_clinic', '=', Auth::user()->clinic)
            ->where('status', '=', 'P')
            ->leftJoin('users as us', 'us.id', '=', 'assignedTo')
            ->leftJoin('clinics', function ($join){
                $join->on('clinics.id', '=', 'refferals.to_clinic');
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
                        WHERE rf.patients_id = $pid");
            

        return $refferals;
    }


    public static function followups($id)
    {
        $pid = ($id)? $id : session('pid', '0');
        $followups = Followup::select('followup.*', 'clinics.name', DB::raw("CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as doctorsname"))
            ->where('patients_id', '=', $pid)
            ->where('status', '=', 'P')
            ->where('clinic_code', '=', Auth::user()->clinic)
            ->leftJoin('users as us', 'us.id', '=', 'assignedTo')
            ->leftJoin('clinics', 'clinics.id', '=', 'followup.clinic_code')
            ->get();
        return $followups;
    }

    public static function vital_signs($id)
    {
        $pid = ($id)? $id : session('pid', '0');
        $vital_signs = VitalSigns::where('patients_id', '=', $pid)->whereDate('created_at', Carbon::now()->format('Y-m-d'))->latest()->get();
        return $vital_signs;
    }



    /* nurse notes */
    public static function check_saved_consultation_exist($pid)
    {
        $consultation = DB::table('consultations')
                            ->where([
                                ['patients_id', $pid],
                                [DB::raw("DATE(created_at)"), DB::raw("CURDATE()")],
                                ['clinic_code', Auth::user()->clinic]
                            ])->count();
        return $consultation;
    }




}
