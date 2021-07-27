<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category(){
        return $this->belongsTo('App\Category', 'category_id');
    }

    // public function subcategory(){
    //     return $this->belongsTo('App\Category', 'subcategory_id');
    // }

    public function brand(){
        return $this->belongsTo('App\Brand', 'brand_id')->select('id','name');
    }

    public function section(){
        return $this->belongsTo('App\Section', 'section_id')->select('id','name');
    }

    public function MaxproAttributes(){
        return $this->hasMany('App\MaxproProductAttributes');
    }

    public function HhoseAttributes(){
        return $this->hasMany('App\HhoseProductAttributes');
    }

    public function ShimgeAttributes(){
        return $this->hasMany('App\ShimgeProductAttributes');
    }

    public function images(){
        return $this->hasMany('App\productsImage');
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\Rating');
    }

    public static function getDiscountedPrice($product_id){
        $proDetails = Product::select('product_price', 'product_discount', 'category_id')->where('id', $product_id)->first()->toArray();
        $catDetails = Category::select('category_discount')->where('id', $proDetails['category_id'])->first()->toArray();
        if($proDetails['product_discount']>0){
            $discounted_price = $proDetails['product_price'] - ($proDetails['product_price']*$proDetails['product_discount']/100);
        }else if($catDetails['category_discount']>0){
            $discounted_price = $proDetails['product_price'] - ($proDetails['product_price']*$catDetails['category_discount']/100);
        }else{
            $discounted_price = 0;
        }
        return $discounted_price;
    }
}
