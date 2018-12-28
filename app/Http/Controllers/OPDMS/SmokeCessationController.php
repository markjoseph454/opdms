<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SmokeCessationController extends Controller
{

    public function smoking_cessation(Request $request)
    {
        // check if a smoke cessation is already been saved
        $smoke = DB::table('smokes')
                    ->where('smokes.patient_id', $request->pid)
                    ->leftJoin('users', 'users.id', 'smokes.user_id')
                    ->select('users.*', 'smokes.created_at as smoking_date')
                    ->latest('smokes.created_at')
                    ->get();

        // if smoke cessation already exist
        if (!$smoke->isEmpty()){
            $data = ['existing'=>true,'smoke'=>$smoke];
        }else{
            $data = ['existing'=>false,'smoke'=>$smoke];
        }
        echo json_encode($data);
        return;
    }


    public function save_smoking_cessation(Request $request)
    {
        // if not then save data
        DB::table('smokes')
            ->insert([
                'user_id' => Auth::user()->id,
                'patient_id' => $request->pid
            ]);
        return;
    }



}
