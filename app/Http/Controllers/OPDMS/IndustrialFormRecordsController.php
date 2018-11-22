<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndustrialFormRecordsController extends Controller
{
    public function industrial_form_records(Request $request)
    {
        $industrial = DB::table('industrial_forms')
                        ->where([
                            ['industrial_forms.patient_id', $request->pid]
                        ])
                        ->leftJoin('users', 'users.id', 'industrial_forms.user_id')
                        ->leftJoin('consultations', function ($join){
                            $join->on('consultations.patients_id', 'industrial_forms.patient_id')
                                ->on(DB::raw('DATE(consultations.created_at)'), DB::raw('DATE(industrial_forms.created_at)'))
                                ->where('consultations.clinic_code', 43); // industrial clinic id
                        })
                        ->select('users.last_name', 'users.first_name', 'users.middle_name',
                            'industrial_forms.created_at', 'industrial_forms.id as id',
                            'consultations.id as cid', 'users.role', 'users.id as uid')
                        ->get();

        echo json_encode($industrial);
        return;
    }
}
