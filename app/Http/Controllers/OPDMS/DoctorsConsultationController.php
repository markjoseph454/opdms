<?php

namespace App\Http\Controllers\OPDMS;

use App\Consultation;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DoctorsConsultationController extends Controller
{

    public function create_consultation(Request $request)
    {
        // query if a patient is currently being served
        $serving = DB::table('assignations')
                    ->where([
                        ['status', 'S'],
                        ['doctors_id', Auth::user()->id],
                        [DB::raw("DATE(created_at)"), DB::raw("CURDATE()")],
                    ])
                    ->first();

        // get the latest patient  consultation depending on consultation.updated_at
        // nonetheless of date, get if the latest consultation is created by receptionist
        // or the consulting doctor.

        if ($serving){
            if ($serving->patients_id == $request->pid){
                $data = $this->consultation_open($request);
            }else{
                $data = ['serving' => true, 'consultation' => false];
            }
        }else{
            $data = $this->consultation_open($request);
        }


//        if ($serving){
//            $data = ['serving' => true, 'consultation' => false];
//        }else{
//
//            // set status to serving
//            DB::table('assignations')
//                ->where([
//                    ['patients_id', $request->pid],
//                    ['clinic_code', Auth::user()->clinic],
//                    [DB::raw("DATE(created_at)"), DB::raw("CURDATE()")],
//                ])->update(['status'=>'S']);
//
//            // set status to serving
//            /*DB::table('queues')
//                ->where([
//                    ['patients_id', $request->pid],
//                    ['clinic_code', Auth::user()->clinic],
//                    [DB::raw("DATE(created_at)"), DB::raw("CURDATE()")],
//                ])->update(['queue_status'=>'S']);*/
//
//            $consultation = DB::select("SELECT
//                        consultations.*,
//                        users.role
//                        FROM consultations
//                        LEFT JOIN users
//                        ON users.id = consultations.users_id
//                        WHERE consultations.patients_id = ".$request->pid."
//                        AND consultations.clinic_code = ".Auth::user()->clinic."
//                        AND consultations.users_id =
//                        (
//                            CASE
//                                WHEN users.role != 7
//                                THEN consultations.users_id
//                                ELSE ".Auth::user()->id."
//                            END
//                        )
//                        ORDER BY consultations.updated_at DESC
//                        LIMIT 1");
//
//            $data = ['serving' => false, 'consultation' => $consultation];
//        }
            echo json_encode($data);
            return;
    }



    public function consultation_open($request)
    {
         // set status to serving
            DB::table('assignations')
                ->where([
                    ['patients_id', $request->pid],
                    ['clinic_code', Auth::user()->clinic],
                    [DB::raw("DATE(created_at)"), DB::raw("CURDATE()")],
                ])->update(['status'=>'S']);

        $consultation = DB::select("SELECT
                        consultations.*,
                        consultations.id as cid,
                        users.role
                        FROM consultations
                        LEFT JOIN users
                        ON users.id = consultations.users_id
                        WHERE consultations.patients_id = ".$request->pid."
                        AND consultations.clinic_code = ".Auth::user()->clinic."
                        AND consultations.users_id = 
                        (
                            CASE 
                                WHEN users.role != 7
                                THEN consultations.users_id
                                ELSE ".Auth::user()->id."
                            END
                        )
                        ORDER BY consultations.updated_at DESC
                        LIMIT 1");

        $data = ['serving' => false, 'consultation' => $consultation];
        return $data;
    }



    public function consultation_save(Request $request)
    {
        // update consultation
        if ($request->consultation_patch){

            // update consultation now
            DB::table('consultations')
            ->where('id', $request->consultation_patch)
            ->update([
                'users_id' => Auth::user()->id,
                'consultation' => $request->consultation
            ]);

            // get the consultation details
            $consultation = Consultation::find($request->consultation_patch);
            // save on patch
            $this->save_consultation_logs($request->consultation_patch, 'P');
        }else{ // save consultation
            // store consultation fresh
            $consultation = Consultation::create([
                                'patients_id' => $request->patient_id,
                                'users_id' => Auth::user()->id,
                                'clinic_code' => Auth::user()->clinic,
                                'consultation' => $request->consultation,
                            ]);
            $this->save_consultation_logs($consultation->id, 'S');
        }

        echo  json_encode($consultation);
        return;
    }


    public function save_consultation_logs($cid, $status)
    {
        // store consultation logs
        DB::table('consultation_logs')
            ->insert([
                'consultation_id' => $cid,
                'user_id' => Auth::user()->id,
                'status' => $status
            ]);
        return false;
    }


    public function end_consultation(Request $request)
    {
        DB::select("
                UPDATE assignations, queues
                SET
                assignations.status = 'F',
                queues.queue_status = 'F'
                WHERE assignations.patients_id = ".$request->pid."
                AND DATE(assignations.created_at) = CURDATE()
                AND assignations.doctors_id = ".Auth::user()->id."
                AND assignations.clinic_code = ".Auth::user()->clinic."
                AND queues.patients_id = ".$request->pid."
                AND DATE(queues.created_at) = CURDATE()
                AND queues.clinic_code = ".Auth::user()->clinic."");
        return;
    }




}
