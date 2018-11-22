<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PediatricRecordsController extends Controller
{
    public function pediatric_records(Request $request)
    {
        $childhood_care = DB::table('childhood_care')
                            ->where([
                                ['childhood_care.patient_id', $request->pid]
                            ])
                            ->leftJoin('users', 'users.id', 'childhood_care.user_id')
                            ->leftJoin('consultations', function ($join){
                                $join->on('consultations.patients_id', 'childhood_care.patient_id')
                                    ->on(DB::raw('DATE(consultations.created_at)'), DB::raw('DATE(childhood_care.created_at)'))
                                    ->where('consultations.clinic_code', 26);
                            })
                            ->select('users.last_name', 'users.first_name', 'users.middle_name',
                                'childhood_care.created_at', 'childhood_care.id as id',
                                'consultations.id as cid', 'users.role', DB::raw('1 as title'))
                            ->get();

        $therapeutic_care = DB::table('otpc_front')
                        ->where([
                            ['otpc_front.patient_id', $request->pid]
                        ])
                        ->leftJoin('users', 'users.id', 'otpc_front.user_id')
                        ->leftJoin('consultations', function ($join){
                            $join->on('consultations.patients_id', 'otpc_front.patient_id')
                                ->on(DB::raw('DATE(consultations.created_at)'), DB::raw('DATE(otpc_front.created_at)'))
                                ->where('consultations.clinic_code', 26);
                        })
                        ->select('users.last_name', 'users.first_name', 'users.middle_name',
                            'otpc_front.created_at', 'otpc_front.id as id',
                            'consultations.id as cid', 'users.role', DB::raw('2 as title'))
                        ->get();

        $kmc = DB::table('kmc')
                        ->where([
                            ['kmc.patient_id', $request->pid]
                        ])
                        ->leftJoin('users', 'users.id', 'kmc.user_id')
                        ->leftJoin('consultations', function ($join){
                            $join->on('consultations.patients_id', 'kmc.patient_id')
                                ->on(DB::raw('DATE(consultations.created_at)'), DB::raw('DATE(kmc.created_at)'))
                                ->where('consultations.clinic_code', 26);
                        })
                        ->select('users.last_name', 'users.first_name', 'users.middle_name',
                            'kmc.created_at', 'kmc.id as id',
                            'consultations.id as cid', 'users.role', DB::raw('3 as title'))
                        ->get();

        $data = $childhood_care->merge($therapeutic_care)->merge($kmc);
        echo json_encode($data);
        return;

    }
}
