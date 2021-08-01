<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
class homeController extends Controller
{
public function update_profile(){
// echo Auth::id();
// exit();
$select_user=DB::table('accounts')->where('id','=',Auth::id())->first();
return view('admin.extends.update_profile',compact('select_user'));
  
}
public function update_user_info(Request $request){
// dd($request->all());
$profile_data = array('name'=> $request->name,
'phone'=> $request->phone,
'updated_at' => date('Y-m-d H:i:s'),
);
DB::table('accounts')
->where('id', Auth::id())
->update($profile_data);
return redirect('Admin/update_profile')->with('message', 'Profile  Updated  Successfully');
}
}