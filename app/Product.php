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
        $proDetails = Product::select('product_price', 'product_discount', 'category_id', 'parentCategory_id')->where('id', $product_id)->first()->toArray();
        $catDetails = Category::select('category_discount')->where('id', $proDetails['category_id'])->first()->toArray();
        $primeCatDetails = Category::select('category_discount')->where('id', $proDetails['parentCategory_id'])->first();
        
        if($proDetails['product_discount']>0){
            $discounted_price = $proDetails['product_price'] - ($proDetails['product_price']*$proDetails['product_discount']/100);
        }else if($catDetails['category_discount']>0){
            $discounted_price = $proDetails['product_price'] - ($proDetails['product_price']*$catDetails['category_discount']/100);
        }else if($primeCatDetails['category_discount']>0){
            $discounted_price = $proDetails['product_price'] - ($proDetails['product_price']*$primeCatDetails['category_discount']/100);
            $discount_amount = $proDetails['product_price'] - $discounted_price;
        }else{
            $discounted_price = 0;
        }
        return $discounted_price;
    }

    public static function getDiscountedMaxproPrice($product_id, $sku){
        $proAttrPrice = MaxproProductAttributes::select('price')->where(['product_id'=>$product_id,'sku'=>$sku])->first();
        $proDetails = Product::select('product_discount', 'category_id', 'parentCategory_id')->where('id', $product_id)->first()->toArray();
        $catDetails = Category::select('category_discount')->where('id', $proDetails['category_id'])->first()->toArray();
        $primeCatDetails = Category::select('category_discount')->where('id', $proDetails['parentCategory_id'])->first();
        // echo  $proDetails['parentCategory_id']; die;

        if($proDetails['product_discount']>0){
            $discounted_price = $proAttrPrice['price'] - ($proAttrPrice['price']*$proDetails['product_discount']/100);
            $discount_amount = $proAttrPrice['price'] - $discounted_price;
        }else if($catDetails['category_discount']>0){
            $discounted_price = $proAttrPrice['price'] - ($proAttrPrice['price']*$catDetails['category_discount']/100);
            $discount_amount = $proAttrPrice['price'] - $discounted_price;
        }else if($primeCatDetails['category_discount']>0){
            $discounted_price = $proAttrPrice['price'] - ($proAttrPrice['price']*$primeCatDetails['category_discount']/100);
            $discount_amount = $proAttrPrice['price'] - $discounted_price;
        }else{
            $discounted_price = $proAttrPrice['price'];
            $discount_amount = 0;
        }
        return array('product_price'=>$proAttrPrice['price'], 'discounted_price'=>$discounted_price, 'discount_amount'=>$discount_amount);
    }

    public static function getDiscountedShimgePrice($product_id, $sku){
        $proAttrPrice = ShimgeProductAttributes::select('price')->where(['product_id'=>$product_id,'sku'=>$sku])->first();
        $proDetails = Product::select('product_discount', 'category_id', 'parentCategory_id')->where('id', $product_id)->first()->toArray();
        $catDetails = Category::select('category_discount')->where('id', $proDetails['category_id'])->first()->toArray();
        $primeCatDetails = Category::select('category_discount')->where('id', $proDetails['parentCategory_id'])->first();

        if($proDetails['product_discount']>0){
            $discounted_price = $proAttrPrice['price'] - ($proAttrPrice['price']*$proDetails['product_discount']/100);
            $discount_amount = $proAttrPrice['price'] - $discounted_price;
        }else if($catDetails['category_discount']>0){
            $discounted_price = $proAttrPrice['price'] - ($proAttrPrice['price']*$catDetails['category_discount']/100);
            $discount_amount = $proAttrPrice['price'] - $discounted_price;
        }else if($primeCatDetails['category_discount']>0){
            $discounted_price = $proAttrPrice['price'] - ($proAttrPrice['price']*$primeCatDetails['category_discount']/100);
            $discount_amount = $proAttrPrice['price'] - $discounted_price;
        }else{
            $discounted_price = $proAttrPrice['price'];
            $discount_amount = 0;
        }
        return array('product_price'=>$proAttrPrice['price'], 'discounted_price'=>$discounted_price, 'discount_amount'=>$discount_amount);
    }

    // public static function getDiscountedHhosePrice($product_id, $sku){
    //     $proHhosePrice = HhoseProductAttributes::where(['product_id'=>$product_id,'sku'=>$sku])->first()->toArray();
    //     $proDetails = Product::select('product_discount', 'category_id')->where('id', $product_id)->first()->toArray();
    //     $catDetails = Category::select('category_discount')->where('id', $proDetails['category_id'])->first()->toArray();

    //     if($proDetails['product_discount']>0){
    //         $discounted_price = $proHhosePrice['price'] - ($proHhosePrice['price']*$proDetails['product_discount']/100);
    //         $discount_amount = $proHhosePrice['price'] - $discounted_price;
    //     }else if($catDetails['category_discount']>0){
    //         $discounted_price = $proHhosePrice['price'] - ($proHhosePrice['price']*$catDetails['category_discount']/100);
    //         $discount_amount = $proHhosePrice['price'] - $discounted_price;
    //     }else{
    //         $discounted_price = 0;
    //         $discount_amount = 0;
    //     }
    //     return array('product_price'=>$proHhosePrice['price'], 'discounted_price'=>$discounted_price);
    // }
}
