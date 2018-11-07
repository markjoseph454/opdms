<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PHICController extends Controller
{
    public function show(Request $request)
    {
        $data = DB::table('phic_annex')->get();
        echo json_encode($data);
    }
}
