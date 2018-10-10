<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Secret;


class AdminController extends Controller
{
    public function decrypt($id = false)
    {
        $user = Secret::where('users_id', '=', $id)->latest()->first();
        $decrypted = Crypt::decryptString($user->secret);
        echo json_encode($decrypted);
        return;
    }
}
