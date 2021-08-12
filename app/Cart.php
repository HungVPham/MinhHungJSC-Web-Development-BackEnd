<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Session;
use App\Product;
use App\Category;
use App\Brand;
// use App\MaxproProductAttributes;
// use App\HhoseProductAttributes;
// use App\ShimgeProductAttributes;

class Cart extends Model
{
    use HasFactory;

    public static function userCartItems(){
        if(Auth::check()){
            $userCartItems = Cart::with(['product'=>function($query){
                $query->select('id', 'category_id', 'brand_id', 'main_image', 'product_name', 'section_id');
            }, 'category'=>function($query){
                $query->select('id', 'url');
            }, 'brand'=>function($query){
                $query->select('id', 'name');
            }])->where('user_id',Auth::user()->id)->orderBy('id', 'Asc')->get()->toArray();
        }else{
            $userCartItems = Cart::with(['product'=>function($query){
                $query->select('id', 'category_id', 'brand_id', 'main_image', 'product_name', 'section_id');
            },'category'=>function($query){
                $query->select('id', 'url');
            }, 'brand'=>function($query){
                $query->select('id', 'name');
            }])->where('session_id', Session::get('session_id'))->orderBy('id', 'Asc')->get()->toArray();
        }
        // echo "<pre>"; print_r($userCartItems); die;
        return $userCartItems;
    }

    public function product(){
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function category(){
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function brand(){
        return $this->belongsTo('App\Brand', 'brand_id');
    }

    // public static function getMaxproProductAttrPrice($product_id, $sku){
    //     $attrMaxproPrice = MaxproProductAttributes::select('price')->where(['product_id'=>$product_id, 'sku'=>$sku])->first();
    //     if($attrMaxproPrice){
    //         $attrMaxproPrice = $attrMaxproPrice->toArray();
    //     }
    //     return $attrMaxproPrice;
    // }

    // public static function getShimgeProductAttrPrice($product_id, $sku){
    //     $attrShimgePrice = ShimgeProductAttributes::select('price')->where(['product_id'=>$product_id, 'sku'=>$sku])->first();
    //     if($attrShimgePrice){
    //         $attrShimgePrice = $attrShimgePrice->toArray();
    //     }
    //     return $attrShimgePrice;
    // }
}
