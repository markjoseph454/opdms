<?php

namespace App\Http\Controllers\OPDMS;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;

class FollowupsController extends Controller
{
    public function followup_history(Request $request)
    {
        $followups = DB::select("SELECT ff.*, clinics.name as clinic, FD.fromDoctor, TD.toDoctor, CONCAT(pt.last_name,
                        ', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,
                        ' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name FROM followup ff
                        LEFT JOIN patients pt ON pt.id = ff.patients_id
                        LEFT JOIN clinics ON clinics.id = ff.clinic_code
                        LEFT JOIN (SELECT us.id, 
                        CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',
                        CASE WHEN us.middle_name IS NOT NULL THEN LEFT(us.middle_name, 1) ELSE '' END,' ',
                        CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) 
                        as fromDoctor FROM users us) as FD ON FD.id = ff.users_id
                        LEFT JOIN (SELECT usr.id, 
                        CONCAT(CASE WHEN usr.last_name IS NOT NULL THEN usr.last_name ELSE '' END,' ',
                        CASE WHEN usr.middle_name IS NOT NULL THEN LEFT(usr.middle_name, 1) ELSE '' END,' ',
                        CASE WHEN usr.first_name IS NOT NULL THEN usr.first_name ELSE '' END) 
                        as toDoctor FROM users usr ) as TD 
                        ON TD.id = ff.assignedTo
                        WHERE ff.patients_id = ".$request->pid."
                        ORDER BY ff.created_at DESC");

        $clinic = DB::table('clinics')
            ->where('id', Auth::user()->clinic)
            ->pluck('name')
            ->first();

        $doctors = DB::table('users')
                    ->where([
                        ['clinic', Auth::user()->clinic],
                        ['role', 7]
                    ])
                    ->orderBy('last_name')
                    ->get();

        $data = ['followups'=>$followups, 'clinic'=>$clinic, 'doctors'=>$doctors];
        echo json_encode($data);
    }


    public function followup_save(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'date' => 'required|date|after:'.Carbon::now(),
            'clinic' => 'required'
        ]);

        if ($validator->passes()){

            $followup = DB::table('followup')
                        ->insert([
                            'patients_id' => $request->patient_id,
                            'users_id' => Auth::user()->id,
                            'clinic_code' => Auth::user()->clinic,
                            'reason' => $request->reason,
                            'assignedTo' => $request->doctor,
                            'followupdate' => $request->date
                        ]);

            return response()->json(['success'=>'Followup schedule successfully saved.']);
        }else{
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

    }


    public function followup_delete(Request $request)
    {
        DB::table('followup')
            ->where('id', $request->id)
            ->delete();
        return response()->json(['error'=>'Followup has been deleted.']);
    }






}
