<?php

namespace App\Product;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;


class ImageMapping extends Model
{
    protected $primaryKey="ProductImageMapping";
    protected $table="product_image_mapping";
    protected $fillable=['Image','ProductID','IndexID'];
}
