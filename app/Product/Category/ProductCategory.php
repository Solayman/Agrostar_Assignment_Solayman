<?php

namespace App\Product\Category;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Product\Product;


class ProductCategory extends Model
{
    protected $primaryKey="CategoryID";
    protected $table="product_category";
    protected $fillable=['CategoryName','ProductQty','ProductNumbers','IsShown','IsDisabled','is_menu','sort_id'];


    public function hasProduct() {
   		return $this->hasMany(Product::class, 'CategoryID', 'CategoryID');
    }

    public function limited_product() {
        return $this->hasProduct()->take(10);
    }
}
