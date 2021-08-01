<?php
namespace App\Http\Controllers\moderator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Yajra\Datatables\Datatables;
use RealRashid\SweetAlert\Facades\Alert;
class patient_info_controller extends Controller
{

public function manage_patients(){

return view('editor.extends.patient_info.manage_patient_info');
}
                                
public function get_all_patient_info(){
$query = DB::table('patient_info');
return DataTables::of($query)
->addColumn('action', function($data){
$button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->patient_id.'" data-original-title="Edit" class="edit btn btn-success btn-sm edit-post"><i class="far fa-edit"></i></a>';
$button .= '&nbsp;&nbsp;';
$button .= '<button name="delete" id="'.$data->patient_id.'" class="delete btn btn-danger confirmDelete" record="Area" recordid="{{$data->AreaID}}"><i class="fa fa-trash"></i></button>';
$button .= '&nbsp;&nbsp;';
$button.='<a href="' . route('patient_prescription_editor.show', $data->patient_id) .'">'.'<button class=" btn btn-info "  ><i class="fa fa-list"></i></button>'.'</a>';
return $button;
})
->rawColumns(['action'])
->toJson();
}
                                
                             
                                
public function delete_patient_info_api($id){

DB::table('patient_info')
->where('patient_id','=',$id)
->delete();
$select_all_featured_image=DB::table('patient_info_image_mapping')->where('patient_id','=',$id)->get();
$product_features_image_location = './frontend_upload_asset/patient_info/prescription_image/';
foreach ($select_all_featured_image as $select_all_featured_images) {
if(file_exists($product_features_image_location.$select_all_featured_images->prescription_image)){
unlink($product_features_image_location.$select_all_featured_images->prescription_image);
}
}
DB::table('patient_info_image_mapping')->where('patient_id','=',$id)->delete();
return 'successfully deleted';
}
public function get_single_patient_information($id){
$data=DB::table('patient_info')
->where('patient_id','=',$id)
->first();
return response()->json($data);
}
public function update_patient_info(Request $request){

$data = array('patient_name' => $request->patient_name,
'patient_phone' => $request->patient_phone,
'patient_email' => $request->patient_email,
"updated_at" => date('Y-m-d H:i:s')
);
DB::table('patient_info')
->where('patient_id',  $request->patient_id)
->update($data);
Alert::success('Patient Status', 'Patient Successfully Updated');
return redirect('/moderator/manage-patients');
}
public function patient_prescription_multiple_immage($id){
$select_patient_table=DB::table('patient_info')
->where('patient_id','=',$id)
->first();

$select_all_featured_images=DB::table('patient_info_image_mapping')
->where('patient_id','=',$id)
// ->select('image_mapping_id','patient_id','prescription_image','created_at','updated_at''status')
->orderby('image_mapping_id','desc')
->get();

$select_single_featured_images=DB::table('patient_info_image_mapping')
->where('patient_id','=',$id)
// ->select('image_mapping_id','patient_id','prescription_image','created_at','updated_at''status')
->orderby('image_mapping_id','desc')
->first();
// print_r($select_all_featured_images);
// exit();
return view('editor.extends.patient_info.featured_images',compact('select_patient_table','select_all_featured_images','select_single_featured_images'));
}
public function change_featured_image_status($id){
$select_featured_image=DB::table('patient_info_image_mapping')->where(' image_mapping_id','=',$id)->first();
$status=$select_featured_image->status;
// echo $slider_status;
// exit();
if($status==1){
$status=0;
// echo 'slider status 1 to 0';
// exit();
}
elseif ($status==0) {
$status=1;
// echo 'slider status 0 to 1';
// exit();
}
// exit();
$data = array('status'=> $status,
'updated_at'=> date('Y-m-d H:i:s'),
);
DB::table('patient_info_image_mapping')
->where('image_mapping_id', $id)
->update($data);
Alert::success('Patient info featured Status', 'Patient info featured image Successfully Updated');
return redirect('/moderator/multiple-immage-manage/'.$select_featured_image->product_id);
}
public function delete_prescribtion_image($id){
$select_prescribtion_image=DB::table('patient_info_image_mapping')->where('image_mapping_id','=',$id)->first();
$patient_id=$select_prescribtion_image->patient_id;
$path='./frontend_upload_asset/patient_info/prescription_image/';
if(file_exists($path.$select_prescribtion_image->prescription_image)){
unlink($path.$select_prescribtion_image->prescription_image);
}

DB::table('patient_info_image_mapping')
->where('image_mapping_id', $id)
->delete();
Alert::success('Patient Prescription Image Status', 'Patient Prescription image Successfully deleted');
return redirect('/moderator/patient_multiple-immage-manage/'.$patient_id);

}
public function store_patient_featured_images(Request $request){
$patient_info_id=$request->patient_id;
$select_featured_image=DB::table('ow_featured_product_image')->where('Featured_Product_Image_id','=',$patient_info_id)->first();

// dd($request->all());
$patient_prescribtion_image_destination = './frontend_upload_asset/patient_info/prescription_image/';
if($request->has('patient_priscribtion_image')){
foreach ($request->patient_priscribtion_image as $patient_priscribtion_images) {
// $file=$request->file('product_features_image');
$patient_featured_image_name = time() .  $patient_priscribtion_images->getClientOriginalName();
// $product_features_image_name = time() . '.' . $product_features_images->getClientOriginalExtension();
$patient_priscribtion_images->move($patient_prescribtion_image_destination, $patient_featured_image_name);

$data = array('prescription_image' => $patient_featured_image_name,
"patient_id"=>$patient_info_id,
"created_at" => date('Y-m-d H:i:s'),
"updated_at" => date('Y-m-d H:i:s')
);
DB::table('patient_info_image_mapping')->insert($data);

}
}
Alert::success('Patient images Status', 'Patient images Status Successfully Added');
return redirect('/moderator/patient_multiple-immage-manage/'.$request->patient_id);
}
}