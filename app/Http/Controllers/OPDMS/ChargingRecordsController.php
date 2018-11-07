<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChargingRecordsController extends Controller
{


    public function charging_records(Request $request)
    {


        $charging_clinic = DB::table('charging_clinics')
                                ->where('clinic_id', Auth::user()->clinic)
                                ->first();

        if ($charging_clinic){
            $charges = DB::table('patients')
                ->where('patients.id', $request->pid)
                ->leftJoin(DB::raw("
                        (SELECT COUNT(ancillaryrequist.patients_id) AS request_total,
                        ancillaryrequist.patients_id AS pid
                        FROM ancillaryrequist 
                        LEFT JOIN cashincomesubcategory
                        ON cashincomesubcategory.id = ancillaryrequist.cashincomesubcategory_id
                        LEFT JOIN cashincomecategory
                        ON cashincomecategory.id = cashincomesubcategory.cashincomecategory_id
                        LEFT JOIN cashincome
                        ON cashincome.ancillaryrequist_id = ancillaryrequist.id
                        WHERE ancillaryrequist.patients_id = ".$request->pid."
                        AND cashincomecategory.clinic_id = ".Auth::user()->clinic."
                        AND (cashincome.get IS NULL OR cashincome.get = 'N')
                        GROUP BY ancillaryrequist.patients_id) service_request
                    "), function ($join){
                    $join->on('service_request.pid', 'patients.id');
                })
                ->leftJoin(DB::raw("
                        (SELECT COUNT(cashincome.patients_id) AS paid_total,
                        ancillaryrequist.patients_id AS pid
                        FROM ancillaryrequist 
                        LEFT JOIN cashincomesubcategory
                        ON cashincomesubcategory.id = ancillaryrequist.cashincomesubcategory_id
                        LEFT JOIN cashincomecategory
                        ON cashincomecategory.id = cashincomesubcategory.cashincomecategory_id
                        LEFT JOIN cashincome
                        ON cashincome.ancillaryrequist_id = ancillaryrequist.id
                        WHERE ancillaryrequist.patients_id = ".$request->pid."
                        AND cashincomecategory.clinic_id = ".Auth::user()->clinic."
                        AND cashincome.get = 'N'
                        GROUP BY ancillaryrequist.patients_id) paid_request
                    "), function ($join){
                    $join->on('paid_request.pid', 'patients.id');
                })
                ->select('request_total', 'paid_total')
                ->first();
            $allowed = true;
            $data = ['charges'=>$charges, 'allowed' => $allowed];
        }else{
            $data = ['charges'=> null, 'allowed' => false];
        }

        echo  json_encode($data);
        return;
    }

}
