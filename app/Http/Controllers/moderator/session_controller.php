<?php

namespace App\Http\Controllers\moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Hash;
use Yajra\Datatables\Datatables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

class session_controller extends Controller
{
 public function show_session(){

 
 	// $current = Carbon::now();
 	// echo $current->endOfWeek(Carbon::MONDAY);
 	// exit();

// $start = (Carbon::TUESDAY);
// $end = (Carbon::today());
// $start = (Carbon::TUESDAY);
// echo $end;
// exit();
// echo date('Y-m-d', strtotime('+3 month'));
// exit();

// days($request->input('start'), $request->input('end'));  
 // $this->days('2012','2015');
 	// $current = Carbon::createFromFormat('m/d/Y', '11/02/2020')->addMonth();
 	// echo $current;
 	// exit();
 // $this->days($current,'1/22/2021');
// $this->days($current,date('Y-m-d', strtotime('+1 month')));
 	$select_service=DB::table('depertment')
 	->select('depertment_id','depertment_name')
 	->get();
 	// print_r($select_service);
 	// exit();

	return view('editor.extends.session.manage_session',compact('select_service'));
}



public function add_session(){
	// echo $doctor_id;
	// exit();

	$select_service=DB::table('depertment')
 	->select('depertment_id','depertment_name')
 	->get();
	return view('editor.extends.session.add_session',compact('select_service'));
}
public function get_all_session(){
	$query = DB::table('doctor_session')
	// ->leftjoin('doctor','doctor.id','=','doctor_session.doctor_id')
	// ->leftjoin('doctor_information','doctor_information.doctor_id','=','doctor_session.doctor_id')
	->leftjoin('depertment','depertment.depertment_id','=','doctor_session.depertment_id')
	;

return DataTables::of($query)
->editColumn('session_status', function ($inquiry) {
    if ($inquiry->session_status == 0) return 'Pending';
    if ($inquiry->session_status == 1) return 'Approved';
    return 'Cancel';
})
->addColumn('action', function($data){
$button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->session_id.'" data-original-title="Edit" class="edit btn btn-success btn-sm edit-post"><i class="far fa-edit"></i></a>';
$button .= '&nbsp;&nbsp;';
$button .= '<button name="delete" id="'.$data->session_id.'" class="delete btn btn-danger confirmDelete" record="Area" recordid="{{$data->AreaID}}"><i class="fa fa-trash"></i></button>';
$button .= '&nbsp;&nbsp;';

$button.='<a href="' . route('editor_next_session_days.list', $data->session_id) .'">'.'<button class=" btn btn-info "  ><i class="fas fa-anchor"></i></button>'.'</a>';
return $button;
})
->rawColumns(['action'])
->toJson();
}
public function delete_session_api($id){

	$select_single_session=DB::table('doctor_session')->where('session_id','=',$id)->first();
	
		$doctor_photo_destination = './frontend_upload_asset/session/image/';

		if (file_exists($doctor_photo_destination.$select_single_session->session_photo)) {
			unlink($doctor_photo_destination.$select_single_session->session_photo);
			
		}

	

	// return $id;
DB::table('doctor_session')
->where('session_id','=',$id)
->delete();

DB::table('session_day_mapping')
->where('session_id','=',$id)
->delete();
return 'session successfully deleted';
}


public function single_session_info($id){


	$data=DB::table('doctor_session')->where('session_id','=',$id)->first();
	return response()->json($data);

}

public function store_session(Request $request){



	// dd($request->all());

	$session_photo_input = $request->file('session_photo');
	$session_photo_path = './frontend_upload_asset/session/image/';
if ($request->session_photo==null) {
	$session_photo_name='session_photo.jpg';
}


if ($session_photo_input) {
$session_photo_name = time().$session_photo_input->getClientOriginalName();

$session_photo_input->move($session_photo_path, $session_photo_name);
}

$doctor_session = array('session_name' => $request->session_name,
'depertment_id' =>$request->depertment_id,
'session_day' =>$request->session_day,
'session_time_start' => $request->session_time_start,
'session_time_end' => $request->session_time_end,
'visiting_price' => $request->visiting_price,
'session_status' => $request->session_status,
'session_details' => $request->session_details,
'session_photo' => $session_photo_name,
'created_at'=>Carbon::today(),
'updated_at'=>Carbon::today()
);


DB::table('doctor_session')->insert($doctor_session);

 $session_id=DB::table('doctor_session')

  						->latest()
                       ->limit(1)
                        ->first();

     // $current = Carbon::now();

     $knownDate = Carbon::now();        
Carbon::setTestNow($knownDate);      
// echo '<br/>';                 
// echo new Carbon('tomorrow');    
// echo '<br/>';
                       
// echo new Carbon('yesterday');  
// echo '<br/>';                       
// echo new Carbon('next wednesday'); 
// $current= new Carbon('next wednesday'); 
if ($request->session_day=='Saturday') {
	$current= new Carbon('next saturday'); 

}
elseif ($request->session_day=='Sunday') {
	$current= new Carbon('next sunday'); 
	
}
elseif ($request->session_day=='Monday') {
	$current= new Carbon('next monday'); 
}
elseif ($request->session_day=='Tuesday') {
	$current= new Carbon('next tuesday'); 
	}
elseif ($request->session_day=='Wednesday') {
	$current= new Carbon('next wednesday'); 
}
elseif ($request->session_day=='Thursday') {
	$current= new Carbon('next thursday'); 
}
elseif ($request->session_day=='Friday') {
	$current= new Carbon('next friday'); 
}

// echo '<br/>';
                    
// echo new Carbon('last friday'); 
// echo '<br/>';
                       
// echo new Carbon('this thursday');                    
// Carbon::setTestNow();   
	// exit();
	
// $this->days($current,date('Y-m-d H:i:s', strtotime('+3 month')),$request->session_id);
	$this->days($current,date('Y-m-d', strtotime('+3 month')),$session_id->session_id);



return redirect('/moderator/add-session/'.$request->doctor_id)->with('message', 'session Successfully Added');
}





public function update_session(Request $request){
	
	// dd($request->all());
		// $current = strtotime((Carbon::FRIDAY));
	// echo $current;
	// echo date('Y-m-d\TH:i:sO');
	// exit();

	
 	// echo $current->endOfWeek(Carbon::MONDAY);
 	// exit();

// $start = (Carbon::TUESDAY);
// $end = (Carbon::today());
// $start = (Carbon::TUESDAY);
// echo $end;
// exit();
// echo date('Y-m-d', strtotime('+3 month'));
// exit();

// days($request->input('start'), $request->input('end'));  
 // $this->days('2012','2015');
 	// $current = Carbon::createFromFormat('m/d/Y', '11/02/2020')->addMonth();
 	// echo $current;
 	// exit();
 // $this->days($current,'1/22/2021');

// exit();


	
	$select_session=DB::table('doctor_session')->where('session_id','=',$request->session_id)->first();
$doctor_session_current_photo_name=$select_session->session_photo;


$count_session_day_mapping = DB::table('session_day_mapping')
->where('session_id','=',$request->session_id)
->count();
// echo $count_session_day_mapping;
// exit();

$start_time=$select_session->session_time_start;
$end_time=$select_session->session_time_end;
$session_day=$select_session->session_day;

if ($count_session_day_mapping==0 || $session_day!=$request->session_day) {

	DB::table('session_day_mapping')->where('session_id','=',$request->session_id)->delete();
	
$knownDate = Carbon::now();        
Carbon::setTestNow($knownDate);      
// echo '<br/>';                 
// echo new Carbon('tomorrow');    
// echo '<br/>';
                       
// echo new Carbon('yesterday');  
// echo '<br/>';                       
// echo new Carbon('next wednesday'); 
// $current= new Carbon('next wednesday'); 
if ($request->session_day=='Saturday') {
	$current= new Carbon('next saturday'); 

}
elseif ($request->session_day=='Sunday') {
	$current= new Carbon('next sunday'); 
	
}
elseif ($request->session_day=='Monday') {
	$current= new Carbon('next monday'); 
}
elseif ($request->session_day=='Tuesday') {
	$current= new Carbon('next tuesday'); 
	}
elseif ($request->session_day=='Wednesday') {
	$current= new Carbon('next wednesday'); 
}
elseif ($request->session_day=='Thursday') {
	$current= new Carbon('next thursday'); 
}
elseif ($request->session_day=='Friday') {
	$current= new Carbon('next friday'); 
}

// echo '<br/>';
                    
// echo new Carbon('last friday'); 
// echo '<br/>';
                       
// echo new Carbon('this thursday');                    
// Carbon::setTestNow();   
	// exit();
	
$this->days($current,date('Y-m-d H:i:s', strtotime('+3 month')),$request->session_id);
// exit();
	
}
// exit();


	
	$doctor_session_input_photo = $request->file('session_photo');
	$session_image_destination = './frontend_upload_asset/session/image/';




if ($doctor_session_input_photo) {
$doctor_session_current_photo_name = time() . '.' . $doctor_session_input_photo->getClientOriginalExtension();

$doctor_session_input_photo->move($session_image_destination, $doctor_session_current_photo_name);

if (file_exists($session_image_destination.$select_session->session_photo)) {
	unlink($session_image_destination.$select_session->session_photo);
	
}
}

$update_session = array('session_day' => $request->session_day,
'depertment_id'=>$request->depertment_id,
'session_name' =>$request->session_name,
'session_time_start' => $request->session_time_start,
'session_time_end' => $request->session_time_end,
'session_status' => $request->session_status,
'session_photo' => $doctor_session_current_photo_name,
'session_details' => $request->session_details,
);
DB::table('doctor_session')
->where('session_id', $request->session_id)
->update($update_session);



Alert::success('Session', 'Session Successfully Updated');
return redirect('moderator/session');




}

private function days($start, $end,$session_id){
	// echo $session_id;
	// exit();
  $current = strtotime($start);
  $end = strtotime($end);
  while($current <= $end && $current <= ($current * 7)){ // go until the last day or seven days, whichever comes first
    $day = date("l", $current);
    // echo $day;
    // exit();
    // echo '<pre>';
    // print_r($day);
    // print_r(date('d-m-Y', $current));
    // print_r(date(" l", $current));
// exit();
    $store_session_days = array('session_id' => $session_id,
'day_of_week'=>date(" l", $current),
'mapping_date' =>date('Y-m-d H:i:s', $current),
// 'created_at' => Carbon::now(),
// 'updated_at' => Carbon::now(),
);
DB::table('session_day_mapping')
// ->where('session_id', $request->session_id)
->insert($store_session_days);
    // exit();
    // $availability = new Availability();
    // $availability->start_date = date('d/m/Y', $current);
    // $availability->end_date = date('d/m/Y', $end);
    // $availability->day_of_week = date("l", $current);
    // $availability->save();
    // $current = $current + 86400;
      $current = $current +(86400*7) ;
}
}
public function session_available_dates($id){
$select_all_days=DB::table('session_day_mapping')->where('session_id','=',$id)
->get();
return view('editor.extends.session.next_session_days',compact('select_all_days'));

}
}
