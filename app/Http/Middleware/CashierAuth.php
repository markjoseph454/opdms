<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

class CashierAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->role == 10) {
                return $next($request);
            }else{
                Session::flash('toaster', array('warning', 'Warning! Unauthorized Access.'));
                return redirect()->back();
            }
        }else{
            Session::flash('toaster', array('error', 'Kindly login first!'));
            return redirect()->route('loginpage');
        }
    }
}
