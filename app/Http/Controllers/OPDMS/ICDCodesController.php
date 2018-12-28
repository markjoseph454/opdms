<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ICDCodesController extends Controller
{

    public function icd_primeclass()
    {
        $data = DB::table('icd_codes_primeclass')
                ->orderBy('code')
                ->get();
        echo json_encode($data);
        return;
    }

    public function icd_subclass_one(Request $request)
    {
        $data = DB::table('icd_codes_subclass_one')
            ->where('primeclass_code', $request->code)
            ->orderBy('id')
            ->get();
        echo json_encode($data);
        return;
    }

    public function icd_subclass_two(Request $request)
    {
        $data = DB::table('icd_codes_subclass_two')
            ->where('subclass_one_code', $request->code)
            ->orderBy('id')
            ->get();
        echo json_encode($data);
        return;
    }

    public function icd_codes_master(Request $request)
    {

        if ($request->type == 'code'){

            $posts = DB::table('icd_codes_master')
                ->where('subclass_two_code', $request->code)
                ->orderBy('id')
                ->paginate(20);

        }else{

            $posts = DB::table('icd_codes_master')
                ->where([
                    ['code', 'LIKE', '%'.$request->search.'%']
                ])
                ->orWhere([
                    ['description', 'LIKE', '%'.$request->search.'%']
                ])
                ->orderBy('id')
                ->paginate(20);

        }

        $response = [
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem()
            ],
            'data' => $posts
        ];
        return response()->json($response);
    }




    public function icd_codes_category_master(Request $request)
    {

        if ($request->type == 'code'){

            $posts = DB::table('icd_codes_subclass_two')
                ->where('subclass_one_code', $request->code)
                ->orderBy('id')
                ->paginate(20);

        }else{

            $posts = DB::table('icd_codes_subclass_two')
                ->where([
                    ['code', 'LIKE', '%'.$request->search.'%']
                ])
                ->orWhere([
                    ['description', 'LIKE', '%'.$request->search.'%']
                ])
                ->orderBy('id')
                ->paginate(20);

        }

        $response = [
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem()
            ],
            'data' => $posts
        ];
        return response()->json($response);
    }


}

















