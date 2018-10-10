<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\JsonableInterface;
use App\Cashincomesubcategory;
use App\Requisition;
use App\Ancillaryrequist;
use App\Cashincome;
use App\Mssclassification;
use DB;
use Session;
use Carbon;
use Validator;
use Auth;

class LabController extends Controller
{


    public function index()
    {

    }


    public function store(Request $request)
    {
        $mssClassification = DB::table('mssclassification')
                            ->where('patients_id', '=', Session::get('pid'))
                            ->leftJoin('mss', 'mss.id', '=', 'mssclassification.mss_id')
                            ->select('mss.id', 'discount')->first();
        $mssArray = array('9', '10','11','12','13');
        $modifier = Str::random(20);

        for ($i=0;$i<count($request->category);$i++){
            if ($request->input('category.'.$i) == 1031){
                $meds = Requisition::storeMeds($request ,$modifier, $i);/*-- save medicines ---*/
            }else{
                $labs = Ancillaryrequist::storeLabs($request ,$modifier, $i);/*-- save labs ---*/
            }
            if ($mssClassification && in_array($mssClassification->id, $mssArray) && $request->input('category.'.$i) != 1031){
                $cashincome = Cashincome::storeIncome($request ,$modifier, $i, $labs, $mssClassification);/*-- save income ---*/
            }
        }
        return redirect()->back()->with('toaster', array('success', 'Requisition successfully saved.'));
    }



    /*--- get all ultrasound services ----*/
    public function ultrasoundWatch(Request $request)
    {
        $ultrasounds = Cashincomesubcategory::where('cashincomecategory_id', '=', $request->category)
                        ->where('trash', '=', 'N')
                        ->orderBy('sub_category')
                        ->get();
        return $ultrasounds->toJson();
    }


    public function ultrasoundShow(Request $request)
    {
        $ultrasound = Ancillaryrequist::where('ancillaryrequist.patients_id', '=', $request->patient)
                                        ->where('cs.cashincomecategory_id', '=', $request->category)
                                        ->leftJoin('cashincomesubcategory as cs', 'cs.id', '=', 'ancillaryrequist.cashincomesubcategory_id')
                                        ->leftJoin('cashincome', 'cashincome.ancillaryrequist_id', '=', 'ancillaryrequist.id')
                                        ->leftJoin('users as us', 'us.id', '=', 'ancillaryrequist.users_id')
                                        ->leftJoin('clinics', 'clinics.id', '=', 'us.clinic')
                                        ->leftJoin('radiology', 'radiology.ancillaryrequest_id', 'ancillaryrequist.id')
                                        ->select('cs.sub_category', 'cs.price', 'cs.status', 'ancillaryrequist.*', 'cashincome.get', 'clinics.name', 'radiology.id as rid',
                                            DB::raw("CONCAT(CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END,' ',CASE WHEN us.middle_name IS NOT NULL THEN LEFT(us.middle_name, 1) ELSE '' END,' ',CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END) as doctorsname"))
                                        ->orderBy('ancillaryrequist.created_at', 'desc')
                                        ->get();
        return $ultrasound->toJson();
    }



}