<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class PatientNotificationsController extends Controller
{

    public function notifications(Request $request)
    {
        $notifications = DB::select("
                                SELECT patients.id,
                                last_consultation.lc_date,
                                last_consultation.lc_last_name,
                                last_consultation.lc_first_name,
                                followup.ff_last_name,
                                followup.ff_first_name
                                FROM patients
                                LEFT JOIN 
                                (
                                    SELECT consultations.patients_id as lc_pid,
                                    consultations.created_at as lc_date, 
                                    users.last_name as lc_last_name,
                                    users.first_name as lc_first_name
                                    FROM consultations
                                    LEFT JOIN users
                                    ON users.id = consultations.users_id
                                    WHERE consultations.id IN
                                    (
                                        SELECT MAX(id)
                                        FROM consultations
                                        WHERE consultations.patients_id = ".$request->pid."
                                        AND clinic_code = ".Auth::user()->clinic."
                                        GROUP BY consultations.patients_id
                                    )
                                ) last_consultation
                                ON last_consultation.lc_pid = patients.id
                                LEFT JOIN 
                                (
                                    SELECT followup.patients_id as ff_pid,
                                    users.last_name as ff_last_name,
                                    users.first_name as ff_first_name
                                    FROM followup
                                    LEFT JOIN users
                                    ON users.id = (
                                        CASE
                                        WHEN followup.assignedTo IS NOT NULL
                                        THEN followup.assignedTo
                                        ELSE followup.users_id
                                        END
                                    )
                                    WHERE followup.patients_id = ".$request->pid."
                                    AND clinic_code = ".Auth::user()->clinic."
                                    AND DATE(followupdate) = CURDATE()
                                ) followup
                                ON followup.ff_pid = patients.id
                                WHERE patients.id = ".$request->pid."
                          ");

        $referrals = DB::select("
                            SELECT 
                            refferals.id,
                            refferals.patients_id as rpid, 
                            clinics.name as rf_clinic,
                            refferals.created_at as ref_date,
                            users.last_name as rb_last_name,
                            users.first_name as rb_first_name, 
                            Ref.rt_last_name, 
                            Ref.rt_first_name
                            FROM refferals
                            LEFT JOIN clinics
                            ON clinics.id = refferals.from_clinic
                            LEFT JOIN users
                            ON users.id = refferals.users_id
                            LEFT JOIN
                            (
                                SELECT
                                refferals.id as ref_id,
                                users.last_name as rt_last_name,
                                users.first_name as rt_first_name
                                FROM refferals
                                LEFT JOIN users
                                ON users.id = refferals.assignedTo
                                WHERE refferals.patients_id = ".$request->pid."
                            ) Ref
                            ON Ref.ref_id = refferals.id
                            WHERE refferals.patients_id = ".$request->pid."
                            AND refferals.status = 'P'
                            AND to_clinic = ".Auth::user()->clinic."
                        ");

        $data = array('notifications' => $notifications, 'referrals' => $referrals);

        echo json_encode($data);

    }



    public function notifications_popup(Request $request)
    {
        $followup = DB::table('followup')
            ->where([
                ['followup.patients_id', $request->pid],
                ['followup.clinic_code', Auth::user()->clinic],
                ['followupdate', DB::raw('CURDATE()')]
            ])
            ->count();
        $referrals = DB::table('refferals')
            ->where([
                ['refferals.patients_id', $request->pid],
                ['refferals.to_clinic', Auth::user()->clinic],
                ['refferals.status', 'P']
            ])
            ->count();
        $consultations = DB::table('consultations')
            ->where([
                ['consultations.patients_id', $request->pid],
            ])
            ->count();

        $data = ['followup' => $followup, 'referrals' => $referrals, 'consultations' => $consultations];
        echo json_encode($data);
        return;
    }



    public function get_all_notifications(Request $request)
    {
        $followup = DB::table('followup')
                        ->where([
                            ['followup.patients_id', $request->pid],
                            ['followup.clinic_code', Auth::user()->clinic],
                            ['followupdate', DB::raw('CURDATE()')]
                        ])
                        ->leftJoin('clinics', 'clinics.id', 'followup.clinic_code')
                        ->leftJoin('users', 'users.id', 'followup.users_id')
                        ->leftJoin(DB::raw('
                            (SELECT id as uid, last_name as ft_last_name, first_name as ft_first_name
                            FROM users) as ff
                        '), function ($join){
                            $join->on('ff.uid', 'followup.assignedTo');
                        })
                        ->select('users.last_name', 'users.first_name', 'ff.ft_last_name', 'ff.ft_first_name',
                            'clinics.name', 'followup.reason', 'followup.followupdate', 'followup.created_at',
                            'users.role')
                        ->get();

        $referrals = DB::table('refferals')
                        ->where([
                            ['refferals.patients_id', $request->pid],
                            ['refferals.to_clinic', Auth::user()->clinic],
                            ['refferals.status', 'P']
                        ])
                        ->leftJoin('users', 'users.id', 'refferals.users_id')
                        ->leftJoin('clinics', 'clinics.id', 'refferals.from_clinic')
                        ->leftJoin(DB::raw('
                            (SELECT id, name FROM clinics) c
                        '), function ($join){
                            $join->on('c.id', 'refferals.to_clinic');
                        })
                        ->leftJoin(DB::raw('
                                        (SELECT id as uid, last_name as rt_last_name, first_name as rt_first_name
                                        FROM users) as rr
                                    '), function ($join){
                            $join->on('rr.uid', 'refferals.assignedTo');
                        })
                        ->select('users.last_name', 'users.first_name', 'rr.rt_last_name', 'rr.rt_first_name',
                            'clinics.name as from_clinic', 'c.name as to_clinic', 'refferals.reason',
                            'refferals.created_at', 'users.role')
                        ->get();


        $consultations = DB::table('consultations')
                            ->where([
                                ['consultations.patients_id', $request->pid],
                            ])
                            ->leftJoin('users', 'users.id', 'consultations.users_id')
                            ->leftJoin('clinics', 'clinics.id', 'consultations.clinic_code')
                            ->select('consultations.consultation', 'consultations.updated_at',
                                'users.last_name', 'users.first_name',
                                'clinics.name', 'users.role')
                            ->orderBy('consultations.updated_at', 'desc')
                            ->get();

        $data = ['followup' => $followup, 'referrals' => $referrals, 'consultations' => $consultations];

        echo json_encode($data);
        return;

    }

}


















