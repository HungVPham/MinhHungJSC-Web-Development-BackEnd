<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;

class ProductsController extends Controller
{
    public function listing($url){
        $categoryCount = Category::where(['url'=>$url],['status'=>1])->count();
        if($categoryCount>0){
            $categoryDetails = Category::catDetails($url);
            $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1)->get()->toArray();
            $productCount = Product::whereIn('category_id', $categoryDetails['catIds'])->where('status', 1)->count();
            // echo "<pre>"; print_r($categoryProducts); die;
            return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts', 'productCount'));
        }else{
            abort(404);
        }
    }
}
