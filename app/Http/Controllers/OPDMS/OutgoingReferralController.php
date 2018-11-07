<?php

namespace App\Http\Controllers\OPDMS;

use App\Refferal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OutgoingReferralController extends Controller
{

    public function outgoing_referral()
    {
        $referral = DB::table('refferals')
                    ->where([
                        [DB::raw('DATE(refferals.created_at)'), DB::raw('CURDATE()')],
                        ['refferals.from_clinic', Auth::user()->clinic]
                    ])
                    ->leftJoin('patients', 'patients.id', 'refferals.patients_id')
                    ->leftJoin('users', 'users.id', 'refferals.users_id')
                    ->leftJoin('clinics', 'clinics.id', 'refferals.to_clinic')
                    ->orderBy('refferals.created_at', 'desc')
                    ->select('patients.last_name', 'patients.first_name', 'patients.middle_name',
                            'patients.hospital_no', 'users.last_name as ulast_name', 'users.first_name as ufirst_name',
                            'clinics.name', 'refferals.created_at')
                    ->limit(5)
                    ->get();
        echo json_encode($referral);
        return;
    }


    public function outgoing_referrals(Request $request)
    {
        $queues = DB::select("
                SELECT * FROM
                (
                SELECT 
                patients.id as pid, patients.last_name, patients.first_name, patients.middle_name,
                patients.suffix, patients.birthday, patients.barcode,
                patients.hospital_no, users.last_name as u_last_name, users.first_name as u_first_name,
                rt.last_name as rt_last_name, rt.first_name as rt_first_name,
                clinics.name, refferals.created_at
                FROM refferals
                LEFT JOIN patients ON patients.id = refferals.patients_id
                LEFT JOIN users ON users.id = refferals.users_id
                LEFT JOIN clinics ON clinics.id = refferals.to_clinic
                LEFT JOIN 
                (
                    SELECT users.last_name, users.first_name, refferals.id
                    FROM refferals
                    LEFT JOIN users ON users.id = refferals.assignedTo
                ) rt ON rt.id = refferals.id
                WHERE refferals.from_clinic = ".Auth::user()->clinic."
                AND DATE(refferals.created_at) BETWEEN '".$request->start."' AND '".$request->end."'
                ) myquery
                WHERE myquery.hospital_no = '".$request->search."'
                OR myquery.barcode = '".$request->search."'
                OR CONCAT(last_name,' ',first_name) LIKE '%".$request->search."%'
                ORDER BY myquery.created_at DESC
              ");

        /*$referrals = DB::table('refferals')
            ->where([
                ['refferals.from_clinic', Auth::user()->clinic]
            ])
            ->whereBetween(DB::raw('DATE(refferals.created_at)'), ['2018-10-26', '2018-10-26'])
            ->leftJoin('patients', 'patients.id', 'refferals.patients_id')
            ->leftJoin('users', 'users.id', 'refferals.users_id')
            ->leftJoin('clinics', 'clinics.id', 'refferals.to_clinic')
            ->leftJoin(DB::raw("
                        (SELECT users.last_name, users.first_name, refferals.id as rid
                        FROM refferals
                        LEFT JOIN users ON users.id = refferals.assignedTo
                        WHERE DATE(refferals.created_at) = CURDATE()
                        AND refferals.from_clinic = ".Auth::user()->clinic.") ref
                    "), function ($join){
                $join->on('ref.rid', 'refferals.id');
            })
            ->orderBy('refferals.created_at', 'desc')
            ->select('patients.id as pid', 'patients.last_name', 'patients.first_name', 'patients.middle_name',
                'patients.suffix', 'patients.birthday',
                'patients.hospital_no', 'users.last_name as u_last_name', 'users.first_name as u_first_name',
                'clinics.name', 'refferals.created_at')
            ->addSelect('ref.last_name as rt_last_name', 'ref.first_name as rt_first_name')->get();*/


        // sub query from derived table

        /*$queues = $referrals->where('patients.hospital_no', $request->search)
                    ->orWhere('patients.barcode', $request->search)
                    ->orWhere(DB::raw("CONCAT(patients.last_name,' ',patients.first_name)"),
                        'LIKE', '%'.$request->search.'%')
                    ->paginate(50);*/

        $start =  $request->start;
        $end =  $request->end;
        $search =  $request->search;

        return view('OPDMS.reception.outgoing_referrals', compact('queues', 'start', 'end', 'search'));
    }

}
