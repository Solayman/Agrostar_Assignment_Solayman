<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerVerifyModel extends Model
{
    protected $table = 'customer_verify';
    protected $primaryKey = 'id';
    protected $fillable = ['name','phone','address','verify_code'];

    public function validation() {
    	return [
    		'name' => 'required',
    		'phone' => 'required',
            'email' => 'required|email',
    		'address' => 'required',
    	];
    }
}
