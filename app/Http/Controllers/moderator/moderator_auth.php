<?php

namespace App\Http\Controllers\moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\doctor_model;
use Hash;
use Auth;
use Mail;
use DB;
use Redirect;
use Validator;

class moderator_auth extends Controller
{

public function moderator_registration_page(){
$select_doctor_depertment=DB::table('depertment')->select('depertment_id','depertment_name')->get();
$select_doctor_district=DB::table('district')->select('district_id','district_name')->get();
// print_r($select_doctor_area);
// exit();
return view('doctor.doctor_registration',compact('select_doctor_depertment','select_doctor_district'));

}

    public function moderator_login(Request $request){
    	
    


$validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = array(
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        );
        
        $remember = isset($input['remember']) ? $request->input('remember') : false;
        $doctor_info = DB::table('doctor')
            ->where('email','=', $request->input('email'))
            ->first();
        
        if($doctor_info){
            if($doctor_info->doctor_status == 0){
                return redirect('/moderator-login')->with('warning','Your account is not approved yet.');
            }else{
                if (Auth::guard('doctor')->attempt($credentials, $remember)) {
                    return redirect('/moderator/moderator-dashboard');
                }
                else {
                    return redirect('/moderator-login')->with('warning','Invalid email and password.');
                }
            }
        }else{
            return redirect('/moderator-login')->with('warning','Email is not found.');
        }





    }


    public function moderator_dashboard(){

return view('editor.extends.dashboard');

    }

public function moderator_registration(){
	return view('doctor.doctor_registration');


}
    public function store_moderator(Request $request){

// dd($request->all());


// $obj = new doctor_model;
//         $requested_data =$request->all();
//         $validate = Validator::make($request->all(), $obj->validation());
//         if ($validate->fails()) {
//             return back()->withInput()->withErrors($validate);
//         }

        // $requested_data['password'] = Hash::make($request->password);
        // $obj->fill($requested_data)->save();
        
      $data = array('doctor_name' => $request->doctor_name,
            'email' => $request->email,
            'doctor_phone' => $request->doctor_phone,
            'password' => Hash::make($request->password),
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s')
        );
        DB::table('doctor')->insert($data);

        $recent_doctor_id=DB::table('doctor') ->orderByRaw('updated_at - created_at DESC')
        ->orderByDesc('created_at')
        ->limit(1)
        ->first();

         $doctor_full_information_table = array('doctor_id' =>$recent_doctor_id->id ,
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s')
        );
        DB::table('doctor_information')->insert($doctor_full_information_table);
       
        
        
        
        return Redirect::to('/moderator-registration')->with('warning','Registration is completed. Login now!');
}


public function moderator_logout(){


    // echo 'doctor logout';
    Auth::guard('doctor')->logout();

        // return Redirect::to('/moderator-login');
         return Redirect::to('/moderator-login')->with('warning','you have successfully logged out!');
}


    
}
