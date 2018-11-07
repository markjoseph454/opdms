<?php

namespace App\Http\Controllers\OPDMS;

use App\VitalSigns;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VitalSignsController extends Controller
{
    // get today`s vs of this patient
    public function insert_vs(Request $request)
    {
        $vs = DB::table('vital_signs')->where('patients_id', $request->pid)
            ->whereDate('vital_signs.created_at', Carbon::now()->toDateString())
            ->latest()
            ->first();
        echo json_encode($vs);
        return;
    }

    public function store(Request $request)
    {
        /*$vs = DB::table('vital_signs')
            ->insert([
                'patients_id' => $request->patient_id,
                'users_id' => Auth::user()->id,
                'weight' => $request->wt,
                'height' => $request->ht,
                'blood_pressure' => $request->bp,
                'pulse_rate' => $request->pr,
                'respiration_rate' => $request->rr,
                'body_temperature' => $request->temp,
            ]);*/
        $vs = new VitalSigns();
        $vs->patients_id = $request->patient_id;
        $vs->users_id = Auth::user()->id;
        $vs->weight = $request->wt;
        $vs->height = $request->ht;
        $vs->blood_pressure = $request->bp;
        $vs->pulse_rate = $request->pr;
        $vs->respiration_rate = $request->rr;
        $vs->body_temperature = $request->temp;
        $vs->save();

        echo json_encode($vs);
        return;
    }

}
