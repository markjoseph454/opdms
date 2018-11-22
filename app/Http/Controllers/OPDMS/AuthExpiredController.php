<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AuthExpiredController extends Controller
{
    public function auth_expired()
    {
        echo json_encode(Cache::has('active_'.Auth::user()->id));
        return;
    }
}
