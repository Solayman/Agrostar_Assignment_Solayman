<?php

namespace App\Product;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;


class RelatedProduct extends Model
{
    protected $primaryKey="RelationID";
    protected $table="product_relation";
    protected $fillable=['ProductID1','ProductID2','Status','Notes'];
}
