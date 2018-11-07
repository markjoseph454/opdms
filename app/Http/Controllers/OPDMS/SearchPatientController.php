<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SearchPatientController extends Controller
{
    public function search(Request $request)
    {
        $patients = DB::table('patients')
                        ->where(DB::raw("CONCAT(patients.last_name,' ',patients.first_name)"),
                            'LIKE', '%'.$request->search.'%')
                        ->orWhere(DB::raw("SOUNDEX(CONCAT(patients.last_name,' ',patients.first_name))"),
                            DB::raw('SOUNDEX("'.$request->search.'")'))
                        ->orWhere([
                            'patients.hospital_no' => "$request->search",
                            'patients.barcode' => "$request->search"
                        ])
                        ->paginate(50);
        return view('OPDMS.reception.search_patient', compact('patients'));

    }
}
