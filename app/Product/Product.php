<?php

namespace App\Product;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Product\ImageMapping;
use App\Supplier\Supplier;

class Product extends Model
{
    protected $primaryKey="ProductID";
    protected $table="product";
    protected $fillable=['CategoryID','VendorID','IsShown','CostPrice','SalePrice','Qty','MinQty','ProductName'];



    public function vendor(){
      	return $this->hasOne(Supplier::class, 'SupplierID','VendorID');
   	}

   	public function images() {
   		return $this->hasMany(ImageMapping::class, 'ProductID', 'ProductID');
   	}
}
