<?php

namespace App;

use Illuminate\Notifications\Notifiable;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CustomerModel extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table ="customers";
    protected $primaryKey = "id";
    protected $fillable = [
        'name', 'email','gender','phone','address','password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function validation() {
    	return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
            'gender' => ['required', 'numeric'],
            'address' => ['required'],
            'phone' => ['required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }
}
