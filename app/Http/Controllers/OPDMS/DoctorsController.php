<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DoctorsController extends Controller
{
    /* get all doctors of this clinic */
    public function clinical_doctors()
    {
        $doctors = DB::table('users')
                    ->where([
                        ['clinic', Auth::user()->clinic],
                        ['role', 7]
                    ])
                    ->orderBy('last_name')
                    ->get();

        echo json_encode($doctors);
        return;
    }
}
