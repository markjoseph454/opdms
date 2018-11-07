<?php

namespace App\OPDMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClinicWithoutDoctor extends Model
{

    public static function clinic_without_doctor(){
        return DB::table('clinics_without_doctors')->pluck('clinic_id')->toArray();
    }

}
