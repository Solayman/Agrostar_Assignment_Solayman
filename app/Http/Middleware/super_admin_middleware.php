<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Auth;

class super_admin_middleware
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
       if(Auth::check())
      {
          // if(Auth::user()->Admin==12)
          // {
               
          // }

          $super_admin = DB::table('accounts')->where('id', Auth::user()->id)
          // ->where('Admin','=',12)
          ->first();

          if($super_admin->Admin==12){

            // return redirect('home');
            return $next($request);

          }

          else{
            
            Auth::logout();

            return redirect('/login')->with('warning','Invalid Attemp');

          }

          
          }

          else{
            Auth::logout();

        return redirect('/login')->with('warning','please log in first');

          }
         
      
      
    }
}
