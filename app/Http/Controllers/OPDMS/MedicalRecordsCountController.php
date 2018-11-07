<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MedicalRecordsCountController extends Controller
{
    public function medical_records_count(Request $request)
    {
        $data = DB::table('patients')
                    ->where('patients.id', $request->pid)
                    ->leftJoin(DB::raw('
                                (SELECT COUNT(*) AS consultations_count, consultations.patients_id as pid 
                                FROM consultations
                                WHERE patients_id = '.$request->pid.') consultations_table
                            '), function ($join){
                        $join->on('consultations_table.pid', 'patients.id');
                    })
                    ->leftJoin(DB::raw('
                        (SELECT COUNT(*) AS referrals_count, refferals.patients_id as pid 
                        FROM refferals
                        WHERE patients_id = '.$request->pid.') referral_table
                    '), function ($join){
                        $join->on('referral_table.pid', 'patients.id');
                    })
                    ->leftJoin(DB::raw('
                                (SELECT COUNT(*) AS followup_count, followup.patients_id as pid 
                                FROM followup
                                WHERE patients_id = '.$request->pid.') followup_table
                            '), function ($join){
                        $join->on('followup_table.pid', 'patients.id');
                    })
                    ->leftJoin(DB::raw('
                        (SELECT COUNT(*) as ultrasound_count, ancillaryrequist.patients_id as pid
                        FROM ancillaryrequist
                        LEFT JOIN cashincomesubcategory
                        ON cashincomesubcategory.id = ancillaryrequist.cashincomesubcategory_id
                        LEFT JOIN cashincomecategory 
                        ON cashincomecategory.id = cashincomesubcategory.cashincomecategory_id
                        WHERE ancillaryrequist.patients_id = '.$request->pid.'
                        AND cashincomecategory.id = 6)
                        ultrasound_table
                    '), function ($join){
                        $join->on('ultrasound_table.pid', 'patients.id');
                    })
                    ->leftJoin(DB::raw('
                                (SELECT COUNT(*) as xray_count, ancillaryrequist.patients_id as pid
                                FROM ancillaryrequist
                                LEFT JOIN cashincomesubcategory
                                ON cashincomesubcategory.id = ancillaryrequist.cashincomesubcategory_id
                                LEFT JOIN cashincomecategory 
                                ON cashincomecategory.id = cashincomesubcategory.cashincomecategory_id
                                WHERE ancillaryrequist.patients_id = '.$request->pid.'
                                AND cashincomecategory.id = 11)
                                xray_table
                            '), function ($join){
                        $join->on('xray_table.pid', 'patients.id');
                    })
                    ->leftJoin(DB::raw('
                           (SELECT COUNT(*) as ecg_count, ancillaryrequist.patients_id as pid
                           FROM ancillaryrequist
                           LEFT JOIN cashincomesubcategory
                           ON cashincomesubcategory.id = ancillaryrequist.cashincomesubcategory_id
                           LEFT JOIN cashincomecategory 
                           ON cashincomecategory.id = cashincomesubcategory.cashincomecategory_id
                           WHERE ancillaryrequist.patients_id = '.$request->pid.'
                           AND cashincomecategory.id = 12)
                           ecg_table
                           '), function ($join){
                        $join->on('ecg_table.pid', 'patients.id');
                    })
                    ->leftJoin(DB::raw('
                           (SELECT COUNT(*) as laboratory_count, ancillaryrequist.patients_id as pid
                           FROM ancillaryrequist
                           LEFT JOIN cashincomesubcategory
                           ON cashincomesubcategory.id = ancillaryrequist.cashincomesubcategory_id
                           LEFT JOIN cashincomecategory 
                           ON cashincomecategory.id = cashincomesubcategory.cashincomecategory_id
                           WHERE ancillaryrequist.patients_id = '.$request->pid.'
                           AND cashincomecategory.id NOT IN (6,11,12))
                           laboratory_table
                           '), function ($join){
                        $join->on('laboratory_table.pid', 'patients.id');
                    })
                    ->leftJoin(DB::raw('
                                   (SELECT SUM(total) as pedia_total, patient_id as pid FROM
                                    (SELECT COUNT(*) as total, patient_id  FROM childhood_care
                                    WHERE patient_id = '.$request->pid.'
                                    UNION ALL
                                    SELECT COUNT(*) as total, patient_id FROM otpc_front
                                    WHERE patient_id = '.$request->pid.'
                                    UNION ALL
                                    SELECT COUNT(*) as total, patient_id FROM kmc
                                    WHERE patient_id = '.$request->pid.') as pedia)
                                   as pedia_table
                                   '), function ($join){
                        $join->on('pedia_table.pid', 'patients.id');
                    })
                    ->leftJoin(DB::raw('
                                (SELECT COUNT(*) AS industrial_count, patient_id as pid 
                                FROM industrial_forms
                                WHERE patient_id = '.$request->pid.') industrial_table
                            '), function ($join){
                        $join->on('industrial_table.pid', 'patients.id');
                    })
                    ->select('referrals_count', 'consultations_count', 'followup_count', 'ultrasound_count',
                        'xray_count', 'ecg_count', 'laboratory_count', 'pedia_total', 'industrial_count')
                    ->first();

        echo json_encode($data);
        return;


    }
}
