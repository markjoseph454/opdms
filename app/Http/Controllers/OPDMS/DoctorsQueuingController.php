<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DoctorsQueuingController extends Controller
{

    public function queuing($status = false)
    {
        $filter_by = ($status && $status != 'P')? $status : false ;
        $queues = DB::table('assignations')
                    ->where([
                        ['assignations.doctors_id', Auth::user()->id],
                        ['assignations.clinic_code', Auth::user()->clinic],
                        [DB::raw('DATE(assignations.created_at)'), DB::raw('CURDATE()')],
                    ])
                    ->leftJoin('patients', 'patients.id', 'assignations.patients_id')
                    ->leftJoin('queues', function ($join){
                        $join->on('queues.patients_id', 'assignations.patients_id')
                            ->where([
                            ['queues.clinic_code', Auth::user()->clinic],
                            [DB::raw('DATE(queues.created_at)'), DB::raw('CURDATE()')],
                        ]);
                    })
                    ->when($status == 'P', function($query){
                        return $query->whereIn('assignations.status', ['P','S']); // get all pending & serving patients
                    })
                    ->when($filter_by, function($query, $filter_by){
                        return $query->where('assignations.status', $filter_by); // filter status
                    })
                    ->select('assignations.patients_id as pid', 'assignations.status',
                        'patients.last_name', 'patients.first_name', 'patients.middle_name', 'patients.suffix',
                        'patients.birthday', 'queues.created_at as queue_time',
                        'assignations.created_at as assigned_time', 'assignations.updated_at as assigned_uptime')
                    ->orderBy('assignations.created_at')
                    ->paginate(50);
        return view('OPDMS.doctors.queue.queue', compact('queues', 'status'));
    }


    public function queuing_search(Request $request)
    {
        $status = null;
        $queues = DB::table('assignations')
            ->where([
                ['assignations.doctors_id', Auth::user()->id],
                ['assignations.clinic_code', Auth::user()->clinic],
                [DB::raw('DATE(assignations.created_at)'), DB::raw('CURDATE()')],
            ])
            ->where(DB::raw("CONCAT(patients.last_name,' ',patients.first_name)"),
                'LIKE', '%'.$request->search.'%')
            ->orWhere([
                'patients.hospital_no' => "$request->search",
                'patients.barcode' => "$request->search"
            ])
            ->leftJoin('patients', 'patients.id', 'assignations.patients_id')
            ->leftJoin('queues', function ($join){
                $join->on('queues.patients_id', 'assignations.patients_id')
                    ->where([
                        ['queues.clinic_code', Auth::user()->clinic],
                        [DB::raw('DATE(queues.created_at)'), DB::raw('CURDATE()')],
                    ]);
            })
            ->select('assignations.patients_id as pid', 'assignations.status',
                'patients.last_name', 'patients.first_name', 'patients.middle_name', 'patients.suffix',
                'patients.birthday', 'queues.created_at as queue_time',
                'assignations.created_at as assigned_time', 'assignations.updated_at as assigned_uptime')
            ->orderBy('assignations.created_at')
            ->groupBy('assignations.patients_id')
            ->paginate(50);

        return view('OPDMS.doctors.queue.queue', compact('queues', 'status'));
    }


    public function assignation_status(Request $request)
    {
        $status = DB::table('assignations')
                ->where([
                    ['patients_id', $request->pid],
                    ['clinic_code', Auth::user()->clinic],
                    [DB::raw("DATE(created_at)"), DB::raw("CURDATE()")],
                ])
                ->pluck('status')
                ->first();

        $serv = DB::table('assignations')
            ->where([
                ['doctors_id', Auth::user()->id],
                ['status', 'S'],
                ['clinic_code', Auth::user()->clinic],
                [DB::raw("DATE(created_at)"), DB::raw("CURDATE()")],
            ])
            ->count();

        $data = ['status'=>$status,'serv'=>$serv];
        echo json_encode($data);
        return;
    }

}















