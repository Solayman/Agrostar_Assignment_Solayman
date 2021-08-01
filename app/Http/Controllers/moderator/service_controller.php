<?php

namespace App\Http\Controllers\moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\Datatables\Datatables;
use DB;
use Auth;

class service_controller extends Controller
{
    public function show_service(){
	return view('admin.extends.depertment.manage_depertment');
}
public function get_all_service(){
	$query = DB::table('depertment');

return DataTables::of($query)
->editColumn('depertment_status', function ($inquiry) {
    if ($inquiry->depertment_status == 0) return 'Pending';
    if ($inquiry->depertment_status == 1) return 'Approved';
    return 'Cancel';
})
->addColumn('action', function($data){
$button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->depertment_id.'" data-original-title="Edit" class="edit btn btn-success btn-sm edit-post"><i class="far fa-edit"></i></a>';
$button .= '&nbsp;&nbsp;';
$button .= '<button name="delete" id="'.$data->depertment_id.'" class="delete btn btn-danger confirmDelete" record="Area" recordid="{{$data->AreaID}}"><i class="fa fa-trash"></i></button>';
return $button;
})
->rawColumns(['action'])
->toJson();
}
public function store_service(Request $request){
	// dd($request->all());
		$depertment_banner_photo = $request->file('depertment_banner_photo');
		$depertment_input_image = $request->file('depertment_photo');
		$district_image_photo_path = './frontend_upload_asset/depertment/image/';
		$district_banner_photo_path = './frontend_upload_asset/depertment/banner/';
if ($depertment_banner_photo) {
	// echo "district banner";
	// exit();
$depertment_banner_photo_name = time() .$depertment_banner_photo->getClientOriginalName();
$depertment_banner_photo->move($district_banner_photo_path, $depertment_banner_photo_name);
}
if($depertment_input_image){
$depertment_photo_name=time().$depertment_input_image->getClientOriginalName();
$depertment_input_image->move($district_image_photo_path,$depertment_photo_name);
}
	// exit();
$data = array('depertment_name' => $request->depertment_name,
'depertment_description' =>$request->depertment_description,
'depertment_banner_photo' => $depertment_banner_photo_name,
'depertment_photo' => $depertment_photo_name,
);
DB::table('depertment')->insert($data);
return redirect('Admin/service')->with('message', 'depertment Successfully Added');
}
public function delete_service_api($id){
	$select_depertment=DB::table('depertment')->where('depertment_id','=',$id)->first();
	$depertment_banner_photo = './frontend_upload_asset/depertment/banner/';
		$depertment_photo = './frontend_upload_asset/depertment/image/';
		if (file_exists($depertment_banner_photo.$select_depertment->depertment_banner_photo)) {
			unlink($depertment_banner_photo.$select_depertment->depertment_banner_photo);
			
		}
		if (file_exists($depertment_photo.$select_depertment->depertment_photo)) {
			unlink($depertment_photo.$select_depertment->depertment_photo);
			
		}
	// return $id;
DB::table('depertment')
->where('depertment_id','=',$id)
->delete();
return 'Depertment successfully deleted';
}
public function single_service_info($id){
	$data=DB::table('depertment')->where('depertment_id','=',$id)->first();
	return response()->json($data);
}
public function update_service(Request $request){
	// dd($request->all());
	$select_depertment=DB::table('depertment')->where('depertment_id','=',$request->depertment_id)->first();
$depertment_photo_name=$select_depertment->depertment_photo;
$depertment_banner_photo_name=$select_depertment->depertment_banner_photo;
	$depertment_image_input = $request->file('depertment_photo');
	$depertment_banner_photo_input = $request->file('depertment_banner_photo');
	$depertment_banner_destination = './frontend_upload_asset/depertment/banner/';
	$depertment_photo_destination = './frontend_upload_asset/depertment/image/';
if ($depertment_image_input) {
if (file_exists($depertment_photo_destination.$select_depertment->depertment_photo)) {
	unlink($depertment_photo_destination.$select_depertment->depertment_photo);
	
}
$depertment_photo_name = time().$depertment_image_input->getClientOriginalName();
$depertment_image_input->move($depertment_photo_destination, $depertment_photo_name);
}
if ($depertment_banner_photo_input) {
if (file_exists($depertment_banner_destination.$select_depertment->depertment_banner_photo)) {
	unlink($depertment_banner_destination.$select_depertment->depertment_banner_photo);
	
}
$depertment_banner_photo_name = time().$depertment_banner_photo_input->getClientOriginalName();
$depertment_banner_photo_input->move($depertment_banner_destination, $depertment_banner_photo_name);
}
$depertment = array('depertment_name' => $request->depertment_name,
'depertment_description' =>$request->depertment_description,
'depertment_photo' => $depertment_photo_name,
'depertment_banner_photo' => $depertment_banner_photo_name,
);
DB::table('depertment')
->where('depertment_id', $request->depertment_id)
->update($depertment);
return redirect('Admin/service')->with('message', 'service Successfully Updated');
}
}
