<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use DB;

class editor_middleware
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
        if (Auth::guard('doctor')->check()) {
        $select_doctor=DB::table('doctor')->where('id','=',Auth::guard('doctor')->user()->id)->first();
        if ($select_doctor->doctor_status==0) {
             Auth::guard('doctor')->logout();
            
            return redirect('/moderator-login')->with('warning','your account not approved');
        }
         if ($select_doctor->doctor_status==2) {
            Auth::guard('doctor')->logout();
            return redirect('/moderator-login')->with('warning','invalid attempts.please contact with administrator');
        }
        
       //      return redirect('Vendor/vendor_dashboard');
       //  // return redirect('/Supplier/login');
         return $next($request);
        }
        else{
            Auth::guard('doctor')->logout();
            return redirect('moderator-login')->with('warning','Please Log in first.');
        }
    }
}
