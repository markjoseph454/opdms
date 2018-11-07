<?php

namespace App\Http\Controllers\OPDMS;

use App\Queue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class QueuedHistoryController extends Controller
{

    public function queued_history($start = false, $end = false, $status = 'A', $doctor_id = false)
    {

        /* check if status is in array */
        $status_array = array('P','H','F','C','S');
        $filter_by = (in_array($status, $status_array))? $status : false;
        $filter_by_unassigned = ($status == 'U')? true : false;

        if ($start && $end){
            $queues = DB::table('queues')
                ->whereBetween(DB::raw('DATE(queues.created_at)'), [$start, $end])
                ->where('queues.clinic_code', Auth::user()->clinic)
                ->leftJoin('assignations', function($join){
                    $join->on('assignations.patients_id', 'queues.patients_id')
                        ->on(DB::raw('DATE(assignations.created_at)'), DB::raw('DATE(queues.created_at)'))
                        ->where('assignations.clinic_code', Auth::user()->clinic);
                })
                ->leftJoin('users', function($join){
                    $join->on('users.id', 'assignations.doctors_id');
                })
                ->leftJoin('patients', function($join){
                    $join->on('patients.id', 'queues.patients_id');
                })
                ->when($doctor_id, function($query, $doctor_id){ /* when status is not equal to all */
                    return $query->where('assignations.doctors_id', $doctor_id);
                })
                ->when($filter_by, function($query, $filter_by){ /* when status is not equal to all */
                    return $query->where('assignations.status', $filter_by);
                })
                ->when($filter_by_unassigned, function($query){   /* when status is unassigned */
                    return $query->whereNull('assignations.status');
                })
                ->select('*', 'queues.patients_id as pid', 'users.last_name as dr_last_name', 'users.first_name as dr_first_name',
                    'users.middle_name as dr_middle_name', 'queues.created_at as queue_time',
                    'assignations.created_at as assigned_time', 'assignations.updated_at as assigned_uptime')
                ->orderBy('queues.created_at', 'desc')
                ->paginate(50);


        $queue_count = DB::table('queues')
                        ->whereBetween(DB::raw('DATE(queues.created_at)'), [$start, $end])
                        ->where('queues.clinic_code', Auth::user()->clinic)
                        ->leftJoin('assignations', function($join){
                            $join->on('assignations.patients_id', 'queues.patients_id')
                                ->on(DB::raw('DATE(assignations.created_at)'), DB::raw('DATE(queues.created_at)'))
                                ->where('assignations.clinic_code', Auth::user()->clinic);
                        })
                        ->leftJoin('users', function($join){
                            $join->on('users.id', 'assignations.doctors_id');
                        })
                        ->leftJoin('patients', function($join){
                            $join->on('patients.id', 'queues.patients_id');
                        })
                        ->when($doctor_id, function($query, $doctor_id){ /* when status is not equal to all */
                            return $query->where('assignations.doctors_id', $doctor_id);
                        })
                        ->when($filter_by, function($query, $filter_by){ /* when status is not equal to all */
                            return $query->where('assignations.status', $filter_by);
                        })
                        ->when($filter_by_unassigned, function($query){   /* when status is unassigned */
                            return $query->whereNull('assignations.status');
                        })
                        ->select(DB::raw('COUNT(*) as total'), 'assignations.status')
                        ->groupBy('assignations.status')
                        ->get();

        }else{
            $queues = Collection::make([]);
            $queue_count = null;
        }

        $doctors = DB::table('users')
                    ->where([
                        ['clinic', Auth::user()->clinic],
                        ['role', 7]
                    ])
                    ->select('id', DB::raw('UPPER(last_name) as last_name'), DB::raw('UPPER(first_name) as first_name'))
                    ->orderBy('last_name')
                    ->get();

        return view('OPDMS.reception.queue_history.history',
            compact('queues', 'queue_count', 'doctors', 'start', 'end', 'status', 'doctor_id'));

    }


    // post function
    public function queue_history(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $status = $request->status;
        $doctor_id = $request->doctor_id;
        return redirect()->route('que_history',
            ['start'=>$start,'end'=>$end,'status'=>$status,'doctor_id'=>$doctor_id]);
    }


}
