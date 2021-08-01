<?php

namespace App\Product\Category;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;



class ProductArea extends Model
{
    protected $primaryKey="AreaID";
    protected $table="product_area";
    protected $fillable=['AreaName','Description','TotalVendors','IsShown','IsDisabled'];


   
}
