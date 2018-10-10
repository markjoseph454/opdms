<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mssclassification extends Model
{
	protected $table = "mssclassification";

    protected $fillable = [
        'patients_id', 'users_id', 'mss_id', 'interviewed', 'relpatient', 'mswd','referral','gender','civil_statuss',
        'living_arrangement','education','occupation','category','fourpis','sectorial',
        'household','duration','philhealth','membership','validity','created_at'
    ];
}
