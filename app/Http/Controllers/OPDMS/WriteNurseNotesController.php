<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Jsonable;
use App\Consultation;
use DB;
use Auth;
use Carbon\Carbon;

class WriteNurseNotesController extends Controller
{

    public function write_nurse_notes(Request $request)
    {
        /*$consultation = Consultation::where('consultations.patients_id', $request->pid)
            ->where('consultations.clinic_code', Auth::user()->clinic)
            ->whereDate('consultations.created_at', Carbon::now()->toDateString())
            ->leftJoin('users', 'users.id', 'consultations.users_id')
            ->select('consultations.*', 'users.clinic', 'users.role')
            ->latest('consultations.created_at')->first();*/


        $user = DB::table('assignations')
            ->where([
                ['assignations.patients_id', $request->pid],
                ['assignations.clinic_code', Auth::user()->clinic],
            ])
            ->whereDate('assignations.created_at', Carbon::now()->toDateString())
            ->select('doctors_id')
            ->latest()
            ->first();

        if ($user){
            $consultation = DB::table('consultations')
                ->where([
                    ['consultations.patients_id', $request->pid],
                    ['consultations.clinic_code', Auth::user()->clinic],
                ])
                ->where('consultations.users_id', DB::raw("
                        CASE 
                            WHEN users.role <> 7
                            THEN consultations.users_id
                            ELSE ".$user->doctors_id."
                        END
                    "))
                ->leftJoin('users', 'users.id', 'consultations.users_id')
                ->select('consultations.*', 'users.clinic', 'users.role')
//                ->latest('consultations.created_at')
                ->latest('consultations.updated_at')
                ->first();
        }else{
            $consultation = null;
        }


        if ($consultation){
            // check if the one who created this consultation is doctor or reception or nurse
            if ($consultation->role == 7 && Auth::user()->id != $consultation->users_id){
                $consultation_form = str_replace('id="doctors" class="mceEditable" style="width: 330px; height: 668px;"',
                    'id="doctors" class="mceNonEditable" style="width: 330px; height: 668px;"', $consultation->consultation);
            }else{
                $consultation_form = $consultation->consultation;
            }
        }else{
            $consultation_form = '';
        }
        $data = ['consultation'=>$consultation, 'consultation_form' => $consultation_form];
        echo json_encode($data);
        return;
    }



    // specifically a consultation is updated
    public function write_nurse_notes_two(Request $request)
    {
        $consultation = Consultation::where('consultations.id', $request->id)
            ->leftJoin('users', 'users.id', 'consultations.users_id')
            ->select('consultations.*', 'users.clinic', 'users.role')
            ->latest('consultations.created_at')->first();

        if ($consultation){
            // check if the one who created this consultation is doctor or reception or nurse
            if ($consultation->role == 7 && Auth::user()->id != $consultation->users_id){
                $consultation_form = str_replace('id="doctors" class="mceEditable" style="width: 330px; height: 668px;"',
                    'id="doctors" class="mceNonEditable" style="width: 330px; height: 668px;"', $consultation->consultation);
            }else{
                $consultation_form = $consultation->consultation;
            }
        }else{
            $consultation_form = '';
        }
        $data = ['consultation'=>$consultation, 'consultation_form' => $consultation_form];
        echo json_encode($data);
        return;
    }



    public function store(Request $request)
    {
        // check if for update the consultation
        if ($request->consultation_patch){
            // replace mceNonEditable with mceEditable
            // if for update the consultation check if the user who created is a doctor or a nurse or receptionist
            // and is allowed to edit the doctor consultation part
            $consultation_form = str_replace('id="doctors" class="mceNonEditable" style="width: 330px; height: 668px;"',
                'id="doctors" class="mceEditable" style="width: 330px; height: 668px;"', $request->consultation);
            if (!$consultation_form){
                $consultation_form = $request->consultation;
            }
            // update now the consultation
            $consultation = Consultation::find($request->consultation_patch); // find consultation id
            $consultation->consultation = $consultation_form;
            $consultation->save();

            $consultation_check = Consultation::where('patients_id', $consultation->id)
                ->leftJoin('users', 'users.id', 'consultations.users_id')
                ->select('consultations.*', 'users.clinic', 'users.role')
                ->first();
            if ($consultation_check){
                // check if the one who created this consultation is doctor or reception or nurse
                // create mceNonEditable if the user who created the consultation is a doctor
                if ($consultation_check->role == 7 && Auth::user()->id != $consultation_check->users_id){
                    $consultation_form = str_replace('id="doctors" class="mceEditable" style="width: 330px; height: 668px;"',
                        'id="doctors" class="mceNonEditable" style="width: 330px; height: 668px;"',
                        $consultation->consultation);
                }else{
                    $consultation_form = $consultation->consultation;
                }
            }else{
                $consultation_form = '';
            }
            $data = ['consultation'=>$consultation, 'consultation_form' => $consultation_form, 'saving_error' => false];
            echo json_encode($data);
            return;
        }else{
            // this is just to check if the patient status is still pending if not
            $assignation = DB::table('assignations')
                ->where([
                    ['assignations.patients_id', $request->patient_id],
                    ['assignations.clinic_code', Auth::user()->clinic],
                ])
                ->whereDate('assignations.created_at', Carbon::now()->toDateString())
                ->select('status')
                ->latest()
                ->first();


            $saving_error = false; // set saving error to false
            if ($assignation){
                if ($assignation->status == 'S'){ // if status is already serving the do not save nurse notes
                    $consultation = null;
                    $saving_error = true;
                }else{
                    $consultation = $this->save_consultation($request);
                }
            }else{
                $consultation = $this->save_consultation($request);
            }
            $data = ['consultation'=>$consultation, 'saving_error'=>$saving_error];
            echo json_encode($data);
            return;
        }

    }

    public function update(Request $request)
    {
        // replace mceNonEditable with mceEditable
        $consultation_form = str_replace('id="doctors" class="mceNonEditable" style="width: 330px; height: 668px;"',
            'id="doctors" class="mceEditable" style="width: 330px; height: 668px;"', $request->consultation);
        if (!$consultation_form){
            $consultation_form = $request->consultation;
        }
        $consultation = Consultation::find($request->consultation_patch); // find consultation id
        $consultation->consultation = $consultation_form;
        $consultation->save();

        $consultation_check = Consultation::where('patients_id', $consultation->id)
                ->leftJoin('users', 'users.id', 'consultations.users_id')
                ->select('consultations.*', 'users.clinic', 'users.role')
                ->first();
        if ($consultation_check){
            // check if the one who created this consultation is doctor or reception or nurse
            if ($consultation_check->role == 7 && Auth::user()->id != $consultation_check->users_id){
                $consultation_form = str_replace('id="doctors" class="mceEditable" style="width: 330px; height: 668px;"',
                    'id="doctors" class="mceNonEditable" style="width: 330px; height: 668px;"',
                    $consultation->consultation);
            }else{
                $consultation_form = $consultation->consultation;
            }
        }else{
            $consultation_form = '';
        }
        $data = ['consultation'=>$consultation, 'consultation_form' => $consultation_form];
        echo json_encode($data);
        return;
    }



    public function save_consultation($request)
    {
        $consultation = Consultation::create([
            'patients_id' => $request->patient_id,
            'users_id' => Auth::user()->id,
            'clinic_code' => Auth::user()->clinic,
            'consultation' => $request->consultation,
        ]);
        return $consultation;
    }

}
