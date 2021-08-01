<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\Datatables\Datatables;
use DB;
use Auth;
use Carbon\Carbon;
class volunteer_controller extends Controller
{
public function show_show_volunteer(){

return view('admin.extends.volunteer.manage_volunteer');
}

public function add_volunteer(){
   return view('admin.extends.volunteer.store_volunteer');
}
public function get_all_volunteer(){
$query = DB::table('volunteer');
return DataTables::of($query)
->editColumn('created_at', function ($user) {
return $user->created_at ? with(new Carbon($user->created_at))->format('m/d/Y') : '';
})
->filterColumn('created_at', function ($query, $keyword) {
$query->whereRaw("DATE_FORMAT(created_at,'%m/%d/%Y') like ?", ["%$keyword%"]);
})

->addColumn('action', function($data){
$button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->volunteer_id.'" data-original-title="Edit" class="edit btn btn-success btn-sm edit-post"><i class="fa fa-pencil-square-o"></i></a>';
$button .= '&nbsp;&nbsp;';
$button .= '<button name="delete" id="'.$data->volunteer_id.'" class="delete btn btn-danger confirmDelete" record="Area" recordid="{{$data->AreaID}}"><i class="fa fa-trash"></i></button>';
return $button;
})
->rawColumns(['action'])
->toJson();
}
public function delete_volunteer_api($id){
$select_volunteer_table=DB::table('volunteer')->where('volunteer_id','=',$id)->first();
$volunteer_photo_path = './frontend_upload_asset/user/volunteer/';
if (file_exists($volunteer_photo_path . $select_volunteer_table->photo)) {
unlink($volunteer_photo_path . $select_volunteer_table->photo);
}
DB::table('volunteer')
->where('volunteer_id','=',$id)
->delete();
return 'successfully deleted';
}
public function single_volunteer_info($id){
$data=DB::table('volunteer')->where('volunteer_id','=',$id)->first();
return response()->json($data);
}
public function store_volunteer (Request $request){
// dd($request->all());
    $this->validate($request, [
'name' => 'required',
'email' => 'required',
'message' => 'required',
'address'=>'required',
'blood_group' => 'required',
'photo' => 'required',
'nid_number' => 'required',
]);
$volunteer_photo_name='photo.jpg';
$volunteer_input_photo = $request->file('photo');
$volunteer_photo_path = './frontend_upload_asset/user/volunteer/';
if ($volunteer_input_photo) {
$volunteer_photo_name = time() . '.' . $volunteer_input_photo->getClientOriginalExtension();
$volunteer_input_photo->move($volunteer_photo_path, $volunteer_photo_name);
}
$data = array('name' => $request->name,
'email' =>$request->email,
'phone' =>$request->phone,
'message' =>$request->message,
'blood_group' =>$request->blood_group,
'address'=>$request->address,
'photo' =>$volunteer_photo_name,
'nid_number' =>$request->nid_number,
'created_at' => date('Y-m-d H:i:s'),
'updated_at' => date('Y-m-d H:i:s'),
);
DB::table('volunteer')->insert($data);
return response()->json($data);
}
public function update_volunteer(Request $request){
   // dd($request->all());
$this->validate($request, [
'name' => 'required',
'email' => 'required',
'message' => 'required',
'blood_group' => 'required',
'photo' => 'image|mimes:jpeg,png,jpg,gif,svg',
'nid_number' => 'required',
]);
// dd($request->all());
$select_volunteer_table=DB::table('volunteer')->where('volunteer_id','=',$request->volunteer_id)->first();
$volunteer_photo_name=$select_volunteer_table->photo;
$volunteer_input_photo = $request->file('photo');
$volunteer_photo_path = './frontend_upload_asset/user/volunteer/';
if ($volunteer_input_photo) {
if (file_exists($volunteer_photo_path.$select_volunteer_table->photo)) {
unlink($volunteer_photo_path.$select_volunteer_table->photo);
}
$volunteer_photo_name = time() . '.' . $volunteer_input_photo->getClientOriginalExtension();
$volunteer_input_photo->move($volunteer_photo_path, $volunteer_photo_name);
}
$data = array('name' => $request->name,
'email' =>$request->email,
'phone' =>$request->phone,
'message' =>$request->message,
'address' =>$request->address,
'blood_group' =>$request->blood_group,
'photo' =>$volunteer_photo_name,
'nid_number' =>$request->nid_number,
'updated_at' => date('Y-m-d H:i:s'),
);
DB::table('volunteer')
->where('volunteer_id', $request->volunteer_id)
->update($data);
return response()->json($data);
}
}