<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class IncomingReferralsController extends Controller
{

    public function incoming_referral()
    {

        $referals = DB::table('refferals')
                    ->where([
                        [DB::raw('DATE(refferals.created_at)'), DB::raw('CURDATE()')],
                        ['refferals.to_clinic', Auth::user()->clinic]
                    ])
                    ->leftJoin('patients', 'patients.id', 'refferals.patients_id')
                    ->leftJoin('clinics', 'clinics.id', 'refferals.from_clinic')
                    ->leftJoin('users', 'users.id', 'refferals.users_id')
                    ->select('patients.last_name', 'patients.first_name', 'patients.hospital_no',
                        'users.last_name as u_last_name', 'users.first_name as u_first_name', 'users.role',
                        'clinics.name', 'refferals.created_at')
                    ->orderBy('refferals.created_at', 'desc')
                    ->limit(5)
                    ->get();

        echo json_encode($referals);
        return;

    }



    public function incoming_referrals(Request $request)
    {

        $queues = DB::select("
                    SELECT * FROM
                    (
                    SELECT 
                    patients.id as pid, patients.last_name, patients.first_name, patients.middle_name,
                    patients.suffix, patients.birthday, patients.hospital_no, patients.barcode,
                    clinics.name as from_clinic, users.last_name as rb_last_name,
                    users.first_name as rb_first_name, toClinic.name as to_clinic,
                    referred_to.last_name as rt_last_name, referred_to.first_name as rt_first_name,
                    refferals.reason, refferals.created_at
                    FROM refferals
                    LEFT JOIN patients ON patients.id = refferals.patients_id
                    LEFT JOIN clinics ON clinics.id  = refferals.from_clinic
                    LEFT JOIN (
                        SELECT clinics.name, refferals.id FROM refferals
                        LEFT JOIN clinics ON clinics.id = refferals.to_clinic
                    ) toClinic ON toClinic.id = refferals.id
                    LEFT JOIN users ON users.id = refferals.users_id
                    LEFT JOIN (
                        SELECT users.last_name, users.first_name, users.middle_name, refferals.id
                        FROM refferals
                        LEFT JOIN users ON users.id = refferals.assignedTo
                    ) referred_to ON referred_to.id = refferals.id
                    WHERE refferals.to_clinic = ".Auth::user()->clinic."
                    AND DATE(refferals.created_at) BETWEEN '".$request->start."' AND '".$request->end."'
                        ) myquery
                    WHERE myquery.hospital_no = '".$request->search."'
                    OR myquery.barcode = '".$request->search."'
                    OR CONCAT(last_name,' ',first_name) LIKE '%".$request->search."%'
                    ORDER BY myquery.created_at DESC");


        /*$referrals = DB::table('refferals')
            ->where([
                ['refferals.status', 'P'],
                ['refferals.to_clinic', Auth::user()->clinic]
            ])
            ->whereBetween(DB::raw('DATE(refferals.created_at)'), [$request->start, $request->end])
            ->leftJoin('patients', 'patients.id', 'refferals.patients_id')
            ->leftJoin('clinics', 'clinics.id', 'refferals.from_clinic')
            ->leftJoin(DB::raw("
                            (SELECT clinics.name, refferals.id 
                            FROM refferals
                            LEFT JOIN clinics ON clinics.id = refferals.to_clinic
                            WHERE refferals.status = 'P'
                            AND refferals.to_clinic = ".Auth::user()->clinic.") toClinic
                        "), function ($join){
                $join->on('toClinic.id', 'refferals.id');
            })
            ->leftJoin('users', 'users.id', 'refferals.users_id')
            ->leftJoin(DB::raw('
                            (SELECT users.last_name, users.first_name, users.middle_name, refferals.id
                            FROM refferals
                            LEFT JOIN users ON users.id = refferals.assignedTo
                            WHERE refferals.status = "P"
                            AND refferals.to_clinic = '.Auth::user()->clinic.') referred_to
                        '), function ($join){
                $join->on('referred_to.id', 'refferals.id');
            })
            ->select('patients.id as pid', 'patients.last_name', 'patients.first_name', 'patients.middle_name',
                'patients.suffix', 'patients.birthday',
                'clinics.name as from_clinic', 'users.last_name as rb_last_name',
                'users.first_name as rb_first_name', 'toClinic.name as to_clinic',
                'referred_to.last_name as rt_last_name', 'referred_to.first_name as rt_first_name',
                'refferals.reason', 'refferals.created_at');

            // sub query from derived table
        $queues = $referrals
            ->where('patients.hospital_no', $request->search)
            ->orWhere('patients.barcode', $request->search)
            ->orWhere(DB::raw("CONCAT(patients.last_name,' ',patients.first_name)"),
                'LIKE', '%'.$request->search.'%')
            ->paginate(50);*/

        $start =  $request->start;
        $end =  $request->end;
        return view('OPDMS.reception.incoming_referrals', compact('queues', 'start', 'end'));
    }

}


















