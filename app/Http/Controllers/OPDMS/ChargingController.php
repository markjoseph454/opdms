<?php

namespace App\Http\Controllers\OPDMS;

use App\Ancillaryrequist;
use App\Cashincome;
use App\Cashincomesubcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChargingController extends Controller
{
    public function ancillary_services()
    {
        $data = DB::table('cashincomesubcategory')
                ->where([
                    ['status', 'active'],
                    ['cashincomecategory.clinic_id', Auth::user()->clinic]
                ])
                ->leftJoin('cashincomecategory', 'cashincomecategory.id', 'cashincomesubcategory.cashincomecategory_id')
                ->select('*', 'cashincomesubcategory.id as sub_id')
                ->orderBy('cashincomesubcategory.sub_category')
                ->get();
        echo json_encode($data);
        return;
    }

    public function charging_save(Request $request)
    {
        // check patient classification
        $mss = DB::table('mssclassification')
                ->leftJoin('mss', 'mss.id', 'mssclassification.mss_id')
                ->where('mssclassification.patients_id', $request->pid)
                ->select('mss.*', 'mssclassification.validity')
                ->first();

        $modifier = Str::random(20); // create a modifier for storing on ancillary table

        for($i=0;$i<count($request->sub_id);$i++){ // loop on the request

            $sub_id =  $request->input('sub_id.'.$i);
            $qty =  $request->input('qty.'.$i);

            // save on ancillary table
            $ancillary = Ancillaryrequist::create([
               'users_id' => Auth::user()->id,
               'patients_id' => $request->pid,
               'cashincomesubcategory_id' => $sub_id,
               'qty' => $qty,
               'modifier' => $modifier,
            ]);

            // store cashincome table if patient is 100% free
            if ($mss){
                // this is for checking if mss is not expired
                $now = Carbon::create(
                    Carbon::now()->format('Y'),
                    Carbon::now()->format('m'),
                    Carbon::now()->format('d')
                );
                $date = Carbon::create(
                    Carbon::parse($mss->validity)->format('Y'),
                    Carbon::parse($mss->validity)->format('m'),
                    Carbon::parse($mss->validity)->format('d')
                );
                if ($mss->description == 100 && $date->greaterThanOrEqualTo($now)){

                    $sub_category = Cashincomesubcategory::find($sub_id); // find subcategory

                    // save on table
                    Cashincome::create([
                        'ancillaryrequist_id' => $ancillary->id,
                        'users_id' => Auth::user()->id,
                        'patients_id' => $request->pid,
                        'mss_id' => $mss->id,
                        'category_id' => $sub_id,
                        'price' => $sub_category->price,
                        'qty' => $qty,
                        'cash' => 0,
                        'discount' => $sub_category->price * $qty,
                    ]);

                }
            }
        }
    }



    public function unpaid_request(Request $request)
    {
        $data = DB::select("SELECT
                        ancillaryrequist.id as anc_id,
                        cashincomesubcategory.sub_category,
                        cashincomesubcategory.price,
                        ancillaryrequist.qty,
                        ancillaryrequist.created_at
                        FROM ancillaryrequist
                        LEFT JOIN cashincomesubcategory
                        ON cashincomesubcategory.id = ancillaryrequist.cashincomesubcategory_id
                        LEFT JOIN cashincomecategory
                        ON cashincomecategory.id = cashincomesubcategory.cashincomecategory_id
                        LEFT JOIN cashincome
                        ON cashincome.ancillaryrequist_id = ancillaryrequist.id
                        WHERE ancillaryrequist.patients_id = $request->pid
                        AND cashincomecategory.clinic_id = ".Auth::user()->clinic."
                        AND cashincome.id IS NULL
                        ORDER BY ancillaryrequist.created_at DESC");
        echo json_encode($data);
        return;
    }


    public function unpaid_remove(Request $request)
    {
        Ancillaryrequist::where('id', $request->sub_id)->delete();
        return;
    }


    public function paid_but_undone(Request $request)
    {
        $data = DB::select("SELECT
                    cashincome.id as cashincome_id,
                    cashincomesubcategory.sub_category,
                    cashincomesubcategory.price,
                    ancillaryrequist.qty,
                    cashincome.created_at
                    FROM cashincome
                    LEFT JOIN ancillaryrequist
                    ON ancillaryrequist.id = cashincome.ancillaryrequist_id
                    LEFT JOIN cashincomesubcategory
                    ON cashincomesubcategory.id = ancillaryrequist.cashincomesubcategory_id
                    LEFT JOIN cashincomecategory
                    ON cashincomecategory.id = cashincomesubcategory.cashincomecategory_id
                    WHERE cashincome.patients_id = $request->pid
                    AND cashincomecategory.clinic_id = ".Auth::user()->clinic."
                    AND cashincome.get = 'N'
                    ORDER BY cashincome.created_at DESC");
        echo json_encode($data);
        return;
    }

    public function paid_done(Request $request)
    {
        Cashincome::where('id', $request->cashincome_id)
            ->update(['get'=>'Y']);
        return;
    }


    public function done_all(Request $request)
    {
            DB::table('cashincome')
            ->where([
                ['cashincome.patients_id', $request->pid],
                ['cashincomecategory.clinic_id', Auth::user()->clinic]
            ])
            ->leftJoin('ancillaryrequist', 'ancillaryrequist.id', 'cashincome.ancillaryrequist_id')
            ->leftJoin('cashincomesubcategory', 'cashincomesubcategory.id', 'ancillaryrequist.cashincomesubcategory_id')
            ->leftJoin('cashincomecategory', 'cashincomecategory.id', 'cashincomesubcategory.cashincomecategory_id')
            ->update(['cashincome.get' => 'Y']);
            return;
    }


    public function paid_and_done(Request $request)
    {
        $data = DB::select("SELECT
                    cashincome.id as cashincome_id,
                    cashincomesubcategory.sub_category,
                    cashincomesubcategory.price,
                    ancillaryrequist.qty,
                    cashincome.created_at
                    FROM cashincome
                    LEFT JOIN ancillaryrequist
                    ON ancillaryrequist.id = cashincome.ancillaryrequist_id
                    LEFT JOIN cashincomesubcategory
                    ON cashincomesubcategory.id = ancillaryrequist.cashincomesubcategory_id
                    LEFT JOIN cashincomecategory
                    ON cashincomecategory.id = cashincomesubcategory.cashincomecategory_id
                    WHERE cashincome.patients_id = $request->pid
                    AND cashincomecategory.clinic_id = ".Auth::user()->clinic."
                    AND cashincome.get = 'Y'
                    ORDER BY cashincome.created_at DESC");
        echo json_encode($data);
        return;
    }


}
