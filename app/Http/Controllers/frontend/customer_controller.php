<?php
namespace App\Http\Controllers\frontend;
use App\Http\Controllers\Controller;
use App\CustomerVerifyModel;
use Illuminate\Http\Request;
use App\CustomerModel;
use Hash;
use Auth;
use Mail;
use DB;
use Redirect;
use Validator;
class customer_controller extends Controller
{
public function customer_login(Request $request){
// dd($request->all());
$credentials = array(
'email' => $request->input('email'),
'password' => $request->input('password'),
);
$remember = isset($input['remember']) ? $request->input('remember') : false;
if (Auth::guard('customer')->attempt($credentials, $remember)) {
return redirect('/');
}
else {
// dd("not authenticate");
return redirect('/customer-login')->with('warning','Login Failed');
}
}
public function customer_registration(Request $request){
    $obj = new CustomerModel;
$requested_data =$request->all();
$validate = Validator::make($request->all(), $obj->validation());
if ($validate->fails()) {
return back()->withInput()->withErrors($validate);
}
$requested_data['password'] = Hash::make($request->password);
$obj->fill($requested_data)->save();


$user = $requested_data;



return Redirect::to('/customer-login')->with('warning','Registration is completed. Login now!');
}
public function customer_update(Request $request){
$obj = CustomerModel::find($request->input('id'));
$obj->name = $request->input('name');
$obj->email = $request->input('email');
$obj->phone = $request->input('phone');
$obj->address = $request->input('address');
$obj->save();
Auth::guard('customer')->logout();
return Redirect::to('customer-login');
}
public function customer_logout(){
Auth::guard('customer')->logout();
return redirect('customer-login');
return Redirect::to('/customer-login')->with('warning','You have successfully logged out');
}
public function customer_password_edit()
{
return view('frontend.layouts.customer_pass_update');
}
public function customer_password_update(Request $request)
{
$this->validate($request,[
'current_password'=>'required',
'new_password'=>'required',
'confirmed_password'=>'required'
]);
$data = $request->all();
if(Hash::check($data['current_password'],Auth::guard('customer')->user()->password)){
if($data['new_password'] == $data['confirmed_password']){
// $hashPassword = Auth::guard('customer')->user()->password;
// return $hashPassword;
CustomerModel::where('id', Auth::guard('customer')->user()->id)->update(['password'=>bcrypt($data['new_password'])]);
Auth::guard('customer')->logout();
return Redirect::to('/customer_login');
}else{
session()->flash('danger','The new password and confirm password is not matched!');
return redirect()->back();
}
}else{
session()->flash('error','The current password is not matched!');
return redirect()->back();
}

}
public function user_profile($id){
$id = \Crypt::decrypt($id);
$data = CustomerModel::find($id);
return view('frontend.extend.customer.user_profile',['data'=>$data]);
}

public function customer_edit($id)
    {
        $id = \Crypt::decrypt($id);
        $data = CustomerModel::find($id);
        return view('frontend.extend.customer.customer_update',['data'=>$data]);
        
       
    }


    public function customer_pass_edit()
    {
        return view('frontend.extend.customer.customer_pass_update');
    }

    public function customer_pass_update(Request $request)
    {
        $this->validate($request,[
            'current_password'=>'required',
            'new_password'=>'required',
            'confirmed_password'=>'required'  
        ]);

        $data = $request->all();

        if(Hash::check($data['current_password'],Auth::guard('customer')->user()->password)){
            if($data['new_password'] == $data['confirmed_password']){

                // $hashPassword = Auth::guard('customer')->user()->password;
                // return $hashPassword;
            CustomerModel::where('id', Auth::guard('customer')->user()->id)->update(['password'=>bcrypt($data['new_password'])]);

                Auth::guard('customer')->logout();

                return Redirect::to('/customer-login');
            }else{
                session()->flash('danger','The new password and confirm password is not matched!');
                return redirect()->back();
            }
        }else{
            session()->flash('error','The current password is not matched!');
            return redirect()->back();
        }

       
    }
    
    public function customer_Appointment_list($id){
        $id = \Crypt::decrypt($id);
$data = CustomerModel::find($id);
$select_appointment_table=DB::table('doctor_appointment')->where('customer_id','=',$id)
->orderby('appointment_id','desc')
->get();
// print_r($select_appointment_table);
        
        return view('frontend.extend.customer.customer_appointment_list',compact('select_appointment_table'));
    }


}