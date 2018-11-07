<?php

namespace App\Http\Controllers\OPDMS;

use App\Secret;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Validator;
use Illuminate\Validation\Rule;
use File;
use Hash;

class UserAccountController extends Controller
{

    public function show($id)
    {
        $user = User::find($id);
        return view('OPDMS.partials.account.update_account', compact('user'));
    }


    public function generatePassword()
    {
        $password = Str::random(6);
        echo json_encode($password);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'last_name' => 'required|max:35',
            'first_name' => 'required|max:35',
            'middle_name' => 'nullable|max:35',
            'username' => [
                'required',
                'max:35',
                Rule::unique('users')->ignore($id), // if user does not change his username then retain old username
            ],
            'password' => 'required|confirmed|min:6',
            'old_password' => [
                'required',
                function($attribute, $value, $fail){ // check old password
                    $password = User::find(request('id'));
                    if(!Hash::check($value, $password->password) && $value != 'laravel'){ // use laravel text to skip old password
                        $fail('The :attribute field doesn\'t match to the current password');
                    }
                },
            ],
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }else{

            $user = User::find($id);

            if ($request->hasFile('profile')) {
                $image_name = time().'.'.request('profile')->getClientOriginalExtension();
                request('profile')->move(public_path('users'), $image_name);
                if ($user->profile){
                    unlink('public/users/'.$user->profile); // delete old profile pic
                }
            }else{
                $image_name = $user->profile;
            }


            /*-- create user details --*/

            User::find($id)->update([
                'last_name' => strtoupper($request->last_name),
                'first_name' => strtoupper($request->first_name),
                'middle_name' => strtoupper($request->middle_name),
                'profile' => $image_name,
                'username' => $request->username,
                'password' => bcrypt($request->password)
            ]);


            Secret::where('users_id', $id)
                ->update([
                   'secret' => Crypt::encryptString($request->password)
                ]);

            return redirect()
                ->back()
                ->with('toastr', array('success', 'Account successfully updated.'))
                ->withInput();
        }


    }


}
