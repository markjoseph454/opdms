<?php

namespace App\Http\Controllers\REGISTER;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Patient;
use App\Clinic;
use App\ForDelete;
use App\AdoptedhostpitalNumbers;
use Response;
use Validator;
use Carbon\Carbon;
use DB;
use Auth;

class QuerysController extends Controller
{
   	public function Search(Request $request)
    {
        if ($request->option == '1') {
            $rules = array(
                'l_name' => 'required',
                'f_name' => 'required',
            );
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Response::json(array(
                        'errors' => $validator->getMessageBag()->toArray()
                    ));
                }else{
                    $data = Patient::where('last_name', 'like', '%'.$request->l_name.'%')
                                ->where('first_name', 'like', '%'.$request->f_name.'%')
                                ->limit(200)
                                ->get();
                }
        }else{
            $rules = array(
                'id_no' => 'numeric|digits:6',
            );
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Response::json(array(
                        'errors' => $validator->getMessageBag()->toArray()
                    ));
                }else{
                    $data = Patient::where('hospital_no', 'like', '%'.$request->id_no.'%')->get();
                }
        }
        echo json_encode($data);
        return;
    }
    public function clinics()
    {
   	 	echo json_encode(Clinic::all());
   	 	return;
    }
    public function today()
    {
        echo json_encode(Patient::Today());
        return;
    }

    public function reserve(Request $request)
    {
        $data = null;
        try{
            $data = AdoptedhostpitalNumbers::create(['hospital_no' => $request->hospital_no]);
        }catch(QueryException $ex){}
        echo json_encode($data);
        return;
    }
    public function print($count)
    {
        echo json_encode(DB::table('patients')->orderByDesc('id')->limit($count)->get());
        return;
    }
    public function searchprint(Request $request)
    {
        echo json_encode(Patient::where(DB::raw("CONCAT(last_name,' ',first_name,' ',middle_name)"), 'like', '%'.$request->patient.'%')
                                        ->orWhere('hospital_no', 'like', '%'.$request->patient.'%')
                                        ->limit(200)
                                        ->get());
        return;
    }
    public function patient($id)
    {
        $patient = Patient::find($id);
        $user = Auth::user();
        echo json_encode(['patient' => $patient, 'user' => $user]);
        return;
    }
    public function cancel($id)
    {
        echo json_encode(ForDelete::where('patient_id', '=', $id)->first()->delete());
        return;
    }
    public function information($id)
    {
        echo json_encode(DB::table('patients')
                        ->leftJoin('mssclassification', function($join)
                        {
                            $join->on('mssclassification.patients_id', 'patients.id')
                                ->on('mssclassification.validity', '>=', DB::raw('CURDATE()'));
                        })
                        ->leftJoin('mss', 'mss.id', '=', 'mssclassification.mss_id')
                        ->where('patients.id', '=', $id)
                        ->first());
        return;                      
    }
}
