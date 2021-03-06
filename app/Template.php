<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = "templates";

    protected $fillable = [
        'subcategory_id', 'description', 'content'
    ];
}
