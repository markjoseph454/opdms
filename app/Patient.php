<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon;
use DB;

class Patient extends Model
{
	protected $table = "patients";

    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'suffix', 'sex', 'birthday', 'age', 'civil_status', 'address', 'city_municipality',
        'brgy', 'contact_no', 'hospital_no', 'barcode', 'printed', 'users_id', 'profile'
    ];

    public static function age($birthday)
    {
        if ($birthday == null) {
            $age = null;
        }else{
            $now = Carbon::now()->toDateString();
            $birth = date_create($birthday);
            $today = date_create($now);
            $diff=date_diff($birth,$today);
            $age = $diff->format("%y");
            if ($age == 0){
                $age = $diff->format("%m month(s) old");
                if ($age == 0){
                    $age = $diff->format("%a day(s) old");
                }
            }
        }
        return $age;
    }

    public static function censusage($birthday)
    {
        $now = Carbon::now()->toDateString();
        $birth = date_create($birthday);
        $today = date_create($now);
        $diff=date_diff($birth,$today);
        $age = $diff->format("%y");
        return $age;
    }


    public static function address($id)
    {
        $patient = Patient::find($id);
        if ($patient->brgy){
            $address = DB::table('refbrgy')
                ->leftJoin('refcitymun', 'refbrgy.citymunCode', '=', 'refcitymun.citymunCode')
                ->leftJoin('refprovince', 'refcitymun.provCode', '=', 'refprovince.provCode')
                ->leftJoin('refregion', 'refprovince.regCode', '=', 'refregion.regCode')
                ->select('refbrgy.brgyDesc', 'refcitymun.citymunDesc', 'provDesc', 'refregion.regDesc')
                ->where('refbrgy.id', '=', $patient->brgy)
                ->get()->first();
        }elseif ($patient->city_municipality){
            $address = DB::table('refcitymun')
                ->leftJoin('refprovince', 'refcitymun.provCode', '=', 'refprovince.provCode')
                ->leftJoin('refregion', 'refprovince.regCode', '=', 'refregion.regCode')
                ->select('refcitymun.citymunDesc', 'provDesc', 'refregion.regDesc')
                ->where('refcitymun.citymunCode', '=', $patient->city_municipality)
                ->get()->first();
        }else{
            $address = false;
        }
        return $address;
    }


}
