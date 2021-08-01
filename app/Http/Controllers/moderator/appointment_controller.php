<?php

namespace App\Http\Controllers\moderator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Hash;
use Yajra\Datatables\Datatables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class appointment_controller extends Controller
{
    public function show_appointment(){
	return view('editor.extends.appointment.manage_appointment');
}

public function add_appointment($session_id){
	// echo $doctor_id;
	// exit();
	return view('editor.extends.appointment.add_appointment',compact('session_id'));
}
public function get_all_appointment(){
$query = DB::table('doctor_appointment')
->leftjoin('customers','customers.id','=','doctor_appointment.customer_id')
->leftjoin('session_day_mapping','session_day_mapping.day_mapping_id','=','doctor_appointment.date_id')
->select('doctor_appointment.appointment_id','doctor_appointment.customer_id','doctor_appointment.date_id','doctor_appointment.session_name','doctor_appointment.applicant_name','doctor_appointment.contact_number','doctor_appointment.email','doctor_appointment.start_time','doctor_appointment.end_time','doctor_appointment.date','doctor_appointment.description','doctor_appointment.appointment_status','doctor_appointment.created_at','doctor_appointment.updated_at','customers.name','session_day_mapping.day_mapping_appointment_status')
;
return DataTables::of($query)
->editColumn('appointment_status', function ($inquiry) {
if ($inquiry->appointment_status == 0) return 'Open';
else if ($inquiry->appointment_status == 1) return 'Deny Appointment';
else if ($inquiry->appointment_status == 2) return 'Complete And Confirm';
return 'Cancel';
})

 // ->editColumn('created_at', '{{ $created_at->diffForHumans() }}')
  // ->filterColumn('created_at', function ($query, $keyword) {
  //   $query->whereRaw("DATE_FORMAT(created_at,'%Y-%m-%d') like ?", ["%$keyword%"]); //date_format when searching using date
  // })

 // ->editColumn('created_at', '{{ $created_at->diffForHumans() }}')
->addColumn('action', function($data){

$button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->appointment_id.'" data-original-title="Edit" class="edit btn btn-success btn-sm edit-post"><i class="far fa-edit"></i></a>';
$button .= '&nbsp;&nbsp;';
$button .= '<button name="delete" id="'.$data->appointment_id.'" class="delete btn btn-danger confirmDelete" record="Area" recordid="{{$data->AreaID}}"><i class="fa fa-trash"></i></button>';
$button .= '&nbsp;&nbsp;';
$button.='<a href="' . route('editor_appointment.deny', $data->appointment_id) .'">'.'<button class=" btn btn-info "  ><i class="fa fa-window-close"></i></button>'.'</a>';
$button .= '&nbsp;&nbsp;';
$button.='<a href="' . route('editor_appointment.complete', $data->appointment_id) .'">'.'<button class=" btn btn-warning  text-white"  ><i class="fas fa-check-circle"></i></button>'.'</a>';
return $button;
})
->rawColumns(['action'])
->toJson();
}
public function delete_appointment_api($id){
$select_single_appointment=DB::table('doctor_appointment')->where('appointment_id','=',$id)->first();
// return $id;
$select_appointment_table=DB::table('doctor_appointment')->where('appointment_id','=',$id)->first();



	$select_day_mapping_table=DB::table('session_day_mapping')->where('day_mapping_id','=',$select_appointment_table->date_id)->first();

	if ($select_day_mapping_table !=null) {
		$update_appointment = array('day_mapping_appointment_status' => 0,
'created_at'=>Carbon::today(),
'updated_at'=>Carbon::today()
);

	DB::table('session_day_mapping')
->where('day_mapping_id', $select_day_mapping_table->day_mapping_id)
->update($update_appointment);
	}

	DB::table('doctor_appointment')
->where('appointment_id','=',$id)
->delete();

return 'appointment successfully deleted';
}


public function single_appointment_info($id){
$data=DB::table('doctor_appointment')->where('appointment_id','=',$id)->first();
return response()->json($data);
}

public function store_appointment(Request $request){
// dd($request->all());

$appointment_photo_input = $request->file('applicant_image');
$appointment_photo_path = './frontend_upload_asset/appointment/image/';
if ($appointment_photo_input) {
$appointment_photo_name = time().$appointment_photo_input->getClientOriginalName();
$appointment_photo_input->move($appointment_photo_path, $appointment_photo_name);
}
$doctor_appointment = array('doctor_id' => $request->doctor_id,
'session_id' =>$request->session_id,
'id' =>$request->id,
'applicant_name' => $request->applicant_name,
'patient_name' => $request->patient_name,
'patient_age' => $request->patient_age,
'gender' => $request->gender,
'contact_number' => $request->contact_number,
'email' => $request->email,
'description' => $request->description,
'applicant_image' => $appointment_photo_name,
'created_at'=>Carbon::today(),
'updated_at'=>Carbon::today()
);
DB::table('doctor_appointment')->insert($doctor_appointment);
return redirect('/moderator/add-appointment/'.$request->doctor_id)->with('message', 'appointment Successfully Added');
}





public function update_appointment(Request $request){
// dd($request->all());
$select_appointment=DB::table('doctor_appointment')->where('appointment_id','=',$request->appointment_id)->first();
$doctor_session_current_photo_name=$select_appointment->applicant_image;

$doctor_appointment_input_photo = $request->file('applicant_image');
$appointment_image_destination = './frontend_upload_asset/appointment/image/';
if ($doctor_appointment_input_photo) {
$appointment_photo_name = time() . '.' . $doctor_appointment_input_photo->getClientOriginalExtension();
$doctor_appointment_input_photo->move($appointment_image_destination, $appointment_photo_name);
if (file_exists($appointment_image_destination.$select_appointment->applicant_image)) {
unlink($appointment_image_destination.$select_appointment->applicant_image);

}
}
$update_doctor_appointment = array('doctor_id' => $request->doctor_id,
'session_id' =>$request->session_id,
'id' =>$request->id,
'applicant_name' => $request->applicant_name,
'patient_name' => $request->patient_name,
'patient_age' => $request->patient_age,
'gender' => $request->gender,
'contact_number' => $request->contact_number,
'email' => $request->email,
'description' => $request->description,
'applicant_image' => $appointment_photo_name,
'created_at'=>Carbon::today(),
'updated_at'=>Carbon::today()
);
DB::table('doctor_session')
->where('session_id', $request->session_id)
->update($update_doctor_appointment);
Alert::success('Session Status', 'Session Successfully Updated');
return redirect('moderator/appointment');
}

public function deny_appointment($id){


	// echo $id;
	$select_appointment_table=DB::table('doctor_appointment')->where('appointment_id','=',$id)->first();

$update_appointment_status = array('appointment_status' => 1,
'updated_at'=>Carbon::today()
);

	DB::table('doctor_appointment')
->where('appointment_id', $id)
->update($update_appointment_status);

	$select_day_mapping_table=DB::table('session_day_mapping')->where('day_mapping_id','=',$select_appointment_table->date_id)->first();

	if ($select_day_mapping_table !=null) {
		$update_appointment = array('day_mapping_appointment_status' => 0,
'created_at'=>Carbon::today(),
'updated_at'=>Carbon::today()
);

	DB::table('session_day_mapping')
->where('day_mapping_id', $select_day_mapping_table->day_mapping_id)
->update($update_appointment);
	}
	// print_r($select_appointment_table);
	// exit();
	

Alert::success('Appointment', 'Appointment Deny');
return redirect('/moderator/appointment');

}
public function complete_appointment($id){


	// echo $id;
		$select_appointment_table=DB::table('doctor_appointment')->where('appointment_id','=',$id)->first();

$update_appointment_status = array('appointment_status' => 2,
'updated_at'=>Carbon::today()
);

DB::table('doctor_appointment')
->where('appointment_id', $id)
->update($update_appointment_status);

	$select_appointment_table=DB::table('doctor_appointment')->where('appointment_id','=',$id)->first();
	$select_day_mapping_table=DB::table('session_day_mapping')->where('day_mapping_id','=',$select_appointment_table->date_id)->first();

	if ($select_day_mapping_table !=null) {
		$update_appointment = array('day_mapping_appointment_status' => 2,
'created_at'=>Carbon::today(),
'updated_at'=>Carbon::today()
);

	DB::table('session_day_mapping')
->where('day_mapping_id', $select_day_mapping_table->day_mapping_id)
->update($update_appointment);
	}
	// print_r($select_appointment_table);
	// exit();
	

Alert::success('Appointment', 'Appointment Completed');
return redirect('/moderator/appointment');

}

public function update_appointment_info(Request $request){

// dd($request->all());

	$update_appointment = array(
		'applicant_name' => $request->applicant_name,
		'email' => $request->email,
		'contact_number' => $request->contact_number,
		'description' => $request->description,
'updated_at'=>Carbon::today()
);

	DB::table('doctor_appointment')
->where('appointment_id', $request->appointment_id)
->update($update_appointment);
	

Alert::success('Appointment', 'Appointment successfully updated');
return redirect('/moderator/appointment');
}


}
