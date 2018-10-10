<?php

namespace App\Http\Controllers;

use App\Patient;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Consultation;
use Illuminate\Support\Facades\Session;

class ChiefComplaintController extends Controller
{


    public function chief_complaint($pid)
    {
        $patient = Patient::find($pid);
        return view('receptions.chief_complaint', compact('patient'));
    }

    public function saveChiefComplaint(Request $request)
    {

        Consultation::create([
            'patients_id' => $request->pid,
            'users_id' => Auth::user()->id,
            'clinic_code' => Auth::user()->clinic,
            'consultation' => $request->consultation
        ]);
        Session::flash('toaster', array('success', 'Consultation successfully saved'));
        return redirect('overview');
    }

}
