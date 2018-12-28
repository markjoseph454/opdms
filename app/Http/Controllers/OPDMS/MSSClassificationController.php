<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MSSClassificationController extends Controller
{

    public function mss_classification(Request $request)
    {
        $mss = DB::table('mssclassification')
                ->where('patients_id', $request->pid)
                ->leftJoin('mss', 'mss.id', 'mssclassification.mss_id')
                ->select('mss.*', 'mssclassification.validity')
                ->first();
        if ($mss) {
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
            if ($date->greaterThanOrEqualTo($now)) {
                $status = 'valid';
            }else{
                $status = 'expired';
            }
        }else{
            $status = 'unclassified';
        }
        $data = ['mss'=>$mss, 'status'=>$status];

        echo json_encode($data);
        return;
    }

}
