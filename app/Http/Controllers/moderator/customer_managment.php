<?php

namespace App\Http\Controllers\moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\Datatables\Datatables;
use DB;
use Auth;
use Carbon\Carbon;
use Hash;
class customer_managment extends Controller
{
 
public function show_customers(){
	// exit();
	return view('editor.extends.customer_managment.manage_customer');
}
public function get_all_customers(){
	$query = DB::table('customers');
return DataTables::of($query)
->editColumn('gender', function ($inquiry) {
    if ($inquiry->gender == 0) return 'Female';
    if ($inquiry->gender == 1) return 'Male';
    return 'Cancel';
})
->addColumn('action', function($data){
$button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-success btn-sm edit-post"><i class="far fa-edit"></i></a>';
$button .= '&nbsp;&nbsp;';
$button .= '<button name="delete" id="'.$data->id.'" class="delete btn btn-danger confirmDelete" record="Area" recordid="{{$data->AreaID}}"><i class="fa fa-trash"></i></button>';
// $button .= '&nbsp;&nbsp;';
$button.='<a href="' . route('editor_customer_appointment.list', $data->id) .'">'.'<button class=" btn btn-info "  ><i class="fa fa-list"></i></button>'.'</a>';
$button .= '&nbsp;&nbsp;';
$button.='<a href="' . route('change_customer_password_by_editory.editor', $data->id) .'">'.'<button class=" btn btn-info "  ><i class="fas fa-lock"></i></button>'.'</a>';
return $button;
})
->rawColumns(['action'])
->toJson();
}

public function delete_customer_api($id){

	

DB::table('customers')
->where('id','=',$id)
->delete();
return 'Customer successfully deleted';
}
public function single_customer_info($id){
	$data=DB::table('customers')->where('id','=',$id)->first();
	return response()->json($data);
}
public function update_customer(Request $request){
	// dd($request->all());
	
$customer = array('name' => $request->name,
'email' =>$request->email,
'phone' => $request->phone,
'gender' => $request->gender,
'address' => $request->address,
'updated_at' => Carbon::now(),
);
DB::table('customers')
->where('id', $request->id)
->update($customer);
return redirect('moderator/Manage-customers')->with('message', 'Customer Successfully Updated');
}

public function customer_appointment_list($id){


	$select_customer_appointment_list=DB::table('doctor_appointment')->where('customer_id','=',$id)->get();
	return view('editor.extends.customer_managment.select_customer_appointment_list',compact('select_customer_appointment_list'));
}

public function change_customer_password($id){
  $select_customer_table=DB::table('customers')
  ->where('id','=',$id)
  ->select('id','name')
  ->first();
return view('editor.extends.customer_managment.change_customer_password',compact('select_customer_table'));

}

public function update_customer_password  (Request $request){

 $this->validate($request, [
        'password' => ['required','min:6'],
        ]);

  // dd($request->all());

  $data = array('password' => Hash::make($request->password),
"updated_at" => date('Y-m-d H:i:s')
);
DB::table('customers')
->where('id',  $request->id)
->update($data);
Alert::success('Customer Status', 'Customer password Successfully Updated');
return redirect('/moderator/Manage-customers');

}
}
