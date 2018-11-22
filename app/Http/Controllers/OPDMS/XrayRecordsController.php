<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class XrayRecordsController extends Controller
{
    public function xray_records(Request $request)
    {
        $xray = DB::table('ancillaryrequist')
            ->where([
                ['ancillaryrequist.patients_id', $request->pid],
                ['cashincomecategory.id', 11] // this id is on cashincomecategory table ultrasound clinic id 26
            ])
            ->leftJoin('cashincomesubcategory', 'cashincomesubcategory.id', 'ancillaryrequist.cashincomesubcategory_id')
            ->leftJoin('cashincomecategory', 'cashincomecategory.id', 'cashincomesubcategory.cashincomecategory_id')
            ->leftJoin('cashincome', 'cashincome.ancillaryrequist_id', 'ancillaryrequist.id')
            ->leftJoin('radiology', 'radiology.ancillaryrequest_id', 'ancillaryrequist.id')
            ->leftJoin('users', 'users.id', 'ancillaryrequist.users_id')
            ->leftJoin('clinics', 'clinics.id', 'users.clinic')
            ->select('users.last_name', 'users.first_name', 'users.middle_name', 'clinics.name',
                'cashincomesubcategory.sub_category', 'cashincomesubcategory.price', 'ancillaryrequist.created_at',
                'radiology.id as rad_id', 'users.role')
            ->orderBy('ancillaryrequist.created_at', 'desc')
            ->get();
        echo json_encode($xray);
        return;
    }
}
