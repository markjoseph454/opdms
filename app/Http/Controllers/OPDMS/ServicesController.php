<?php

namespace App\Http\Controllers\OPDMS;

use App\Cashincomecategory;
use App\Cashincomesubcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Validator;

class ServicesController extends Controller
{

    public function services_offered($status = false)
    {
        $services = DB::table('cashincomesubcategory')
                    ->where([
                        ['cashincomecategory.clinic_id', Auth::user()->clinic]
                    ])
                    ->leftJoin('cashincomecategory', 'cashincomecategory.id', 'cashincomesubcategory.cashincomecategory_id')
                    ->when($status == 'A', function ($query, $status){
                        return $query->where('cashincomesubcategory.status', 'active');
                    })
                    ->when($status == 'I', function ($query, $status){
                        return $query->where('cashincomesubcategory.status', 'inactive');
                    })
                    ->select('*', 'cashincomesubcategory.id as sub_id')
                    ->orderBy('cashincomesubcategory.sub_category')
                    ->get();

        $data = DB::table('cashincomesubcategory')
                ->where([
                    ['cashincomecategory.clinic_id', Auth::user()->clinic]
                ])
                ->leftJoin('cashincomecategory', 'cashincomecategory.id', 'cashincomesubcategory.cashincomecategory_id')
                ->select(DB::raw("COUNT(*) as total"), 'cashincomesubcategory.status')
                ->groupBy('cashincomesubcategory.status')
                ->get();

        return view('OPDMS.reception.services.services', compact('services', 'data'));

    }

    public function services_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'sub_category' => 'required|max:125',
           'price' => 'required',
           'status' => 'required',
        ]);
        if ($validator->passes()){

            if ($request->service_patch){
                DB::table('cashincomesubcategory')
                    ->where('id', $request->service_patch)
                    ->update([
                        'sub_category' => $request->sub_category,
                        'price' => $request->price,
                        'status' => $request->status
                    ]);
                Session::flash('toastr', array('info', 'Service successfully been updated.'));
            }else{
                $cashincomecategory_id = Cashincomecategory::where('clinic_id', Auth::user()->clinic)->pluck('id')->first();
                DB::table('cashincomesubcategory')
                    ->insert([
                        'cashincomecategory_id' => $cashincomecategory_id,
                        'sub_category' => $request->sub_category,
                        'price' => $request->price,
                        'status' => $request->status
                    ]);
                Session::flash('toastr', array('success', 'Service successfully been added.'));
            }
            return redirect('services_offered');
        }else{
            return redirect()->back()->withErrors($validator);
        }
    }


    public function service_edit(Request $request)
    {
        $data = Cashincomesubcategory::find($request->id);
        echo json_encode($data);
        return;
    }


}
