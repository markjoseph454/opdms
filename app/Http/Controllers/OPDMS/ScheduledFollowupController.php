<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ScheduledFollowupController extends Controller
{

    public function followup_notif()
    {
        $followup = DB::select("SELECT patients.id as pid,
                        patients.last_name, patients.first_name, patients.hospital_no,
                        users.last_name as u_last_name, users.first_name as u_first_name,
                        followup.created_at
                        FROM followup
                        LEFT JOIN patients
                        ON patients.id = followup.patients_id
                        LEFT JOIN users ON users.id = 
                        (
                            CASE 
                                WHEN followup.assignedTo IS NOT NULL
                                THEN followup.assignedTo
                                ELSE followup.users_id
                            END
                        )
                        WHERE DATE(followup.followupdate) = CURDATE()
                        AND followup.clinic_code = ".Auth::user()->clinic."");
        echo json_encode($followup);
        return;

    }



    public function followup_notifications(Request $request)
    {

        $queues = DB::select("
            SELECT * FROM
            (
            SELECT patients.id as pid,
            patients.last_name, patients.first_name, patients.middle_name, patients.suffix, patients.hospital_no,
            patients.barcode, patients.birthday,
            users.last_name as u_last_name, users.first_name as u_first_name, users.middle_name as u_middle_name,
            ff.ft_last_name, ff.ft_first_name, ff.ft_middle_name,
            followup.reason, followup.followupdate, followup.status, clinics.name,
            followup.created_at
            FROM followup
            LEFT JOIN patients ON patients.id = followup.patients_id
            LEFT JOIN users ON users.id = followup.users_id
            LEFT JOIN clinics ON clinics.id = followup.clinic_code
            LEFT JOIN (
                SELECT followup.id, users.last_name as ft_last_name,
                users.first_name as ft_first_name, users.middle_name as ft_middle_name
                FROM followup
                LEFT JOIN users ON users.id = followup.assignedTo
            ) ff ON ff.id = followup.assignedTo
            WHERE DATE(followup.followupdate) BETWEEN '".$request->start."' AND '".$request->end."'
            AND followup.clinic_code = ".Auth::user()->clinic."
                ) myquery
                WHERE myquery.hospital_no = '".$request->search."'
                OR myquery.barcode = '".$request->search."'
                OR CONCAT(last_name,' ',first_name) LIKE '%".$request->search."%'
                ORDER BY myquery.followupdate DESC
        ");

//        dd($queues);
        $start =  $request->start;
        $end =  $request->end;
        $search =  $request->search;

        return view('OPDMS.reception.followup_notifications', compact('queues', 'start', 'end', 'search'));
    }


}
