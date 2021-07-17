<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;

class ProductsController extends Controller
{
    public function listing(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $url = $data['url'];
            $categoryCount = Category::where(['url'=>$url],['status'=>1])->count();
            if($categoryCount>0){
            $categoryDetails = Category::catDetails($url);
            $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);

            // check if sort products option is selected 
            if(isset($data['sortProducts']) && !empty($data['sortProducts'])){
                if($data['sortProducts']=="product_latest"){
                    $categoryProducts->orderBy('id', 'Desc');
                }else if($data['sortProducts']=="product_name_a_z"){
                    $categoryProducts->orderBy('product_name', 'Asc');
                }else if($data['sortProducts']=="product_name_z_a"){
                    $categoryProducts->orderBy('product_name', 'Desc');
                }else if($data['sortProducts']=="price_lowest"){
                    $categoryProducts->orderBy('product_price', 'Asc');
                }else if($data['sortProducts']=="price_highest"){
                    $categoryProducts->orderBy('product_price', 'Desc');
                }
            }

            $categoryProducts = $categoryProducts->Paginate(8);
            // echo "<pre>"; print_r($categoryProducts); die;
            return view('front.products.ajax_products_listing')->with(compact('categoryDetails', 'categoryProducts', 'url'));
            }else{
            abort(404);
            }

        }else{
            $url = Route::getFacadeRoot()->current()->uri();
            $categoryCount = Category::where(['url'=>$url],['status'=>1])->count();
            if($categoryCount>0){
            $categoryDetails = Category::catDetails($url);
            $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);
            $categoryProducts = $categoryProducts->Paginate(8);
            // echo "<pre>"; print_r($categoryProducts); die;
            return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts', 'url'));
            }else{
            abort(404);
            }
        }
    }
}
