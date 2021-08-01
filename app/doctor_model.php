<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
// class doctor_model extends Model 
class doctor_model extends Authenticatable 
{
use Notifiable;
/**
* The attributes that are mass assignable.
*
* @var array
*/
protected $table ="doctor";
protected $primaryKey = "id";
protected $fillable = [
'doctor_name', 'email','doctor_phone','doctor_status','password',
];
/**
* The attributes that should be hidden for arrays.
*
* @var array
*/
protected $hidden = [
'password','remember_token',
];
public function validation() {
	return [
'doctor_name' => ['required', 'string', 'max:255'],
'email' => ['required', 'string', 'email', 'max:255', 'unique:doctor'],
'doctor_phone' => ['required'],
 // 'doctor_password' => 'required|between:8,255|confirmed',
  'password' => 'required|between:8,255',
  

];
}
}