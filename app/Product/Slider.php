<?php

namespace App\Product;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;


class Slider extends Model
{
    protected $primaryKey="SliderID";
    protected $table="slider_image";
    protected $fillable=['ImageName','Status','Notes'];
}
