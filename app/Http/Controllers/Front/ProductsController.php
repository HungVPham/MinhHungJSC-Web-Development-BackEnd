<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\MaxproProductAttributes;
use App\HhoseProductAttributes;
use App\ShimgeProductAttributes;

class ProductsController extends Controller
{
    // listing page general controls
    public function listing(Request $request){
        Paginator::useBootstrap();
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

            $categoryProducts = $categoryProducts->Paginate(30);
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
            $categoryProducts = $categoryProducts->Paginate(30);
            // echo "<pre>"; print_r($categoryProducts); die;
            return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts', 'url'));
            }else{
            abort(404);
            }
        }
    }

    // listing page general controls
    public function detail($id){
        $productDetails = Product::with('category', 'brand', 'MaxproAttributes', 'HhoseAttributes', 'ShimgeAttributes', 'images')->find($id)->toArray();
        $total_tools_stock = MaxproProductAttributes::where('product_id', $id)->sum('stock'); 
        $total_hhose_stock = HhoseProductAttributes::where('product_id', $id)->sum('stock'); 
        $total_pump_stock = ShimgeProductAttributes::where('product_id', $id)->sum('stock'); 
        $total_stock =  $total_tools_stock + $total_hhose_stock + $total_pump_stock;
        // dd($total_stock); die;
        return view('front.products.detail')->with(compact('productDetails', 'total_tools_stock', 'total_hhose_stock', 'total_pump_stock', 'total_stock'));
    }
    /* get maxpro price by sku*/
    public function getMaxproProductPrice(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getMaxproProductPrice = MaxproProductAttributes::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku']])->first();
            return $getMaxproProductPrice->price;
        }
    }
    public function getMaxproProductVoltage(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getMaxproProductVoltage = MaxproProductAttributes::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku']])->first();
            return $getMaxproProductVoltage->voltage;
        }
    }
    public function getMaxproProductPower(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getMaxproProductPower = MaxproProductAttributes::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku']])->first();
            return $getMaxproProductPower->power;
        }
    }


    /* get hhose price by sku*/
    public function getHhoseProductPrice(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getHhoseProductPrice = HhoseProductAttributes::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku']])->first();
            return $getHhoseProductPrice->price;
        }
    }
    public function getHhoseProductDiameter(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getHhoseProductDiameter = HhoseProductAttributes::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku']])->first();
            return $getHhoseProductDiameter->diameter;
        }
    }
    public function getHhoseProductLength(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getHhoseProductLength = HhoseProductAttributes::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku']])->first();
            return $getHhoseProductLength->length_per_unit;
        }
    }
    public function getHhoseProductEmbossed(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getHhoseProductEmbossed = HhoseProductAttributes::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku']])->first();
            return $getHhoseProductEmbossed->hhose_spflex_embossed;
        }
    }
    public function getHhoseProductSmooth(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getHhoseProductSmooth = HhoseProductAttributes::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku']])->first();
            return $getHhoseProductSmooth->hhose_spflex_smoothtexture;
        }
    }



    /* get shimge price by sku*/
    public function getShimgeProductPrice(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getShimgeProductPrice = ShimgeProductAttributes::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku']])->first();
            return $getShimgeProductPrice->price;
        }
    }
    public function getShimgeProductVoltage(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getShimgeProductVoltage = ShimgeProductAttributes::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku']])->first();
            return $getShimgeProductVoltage->voltage;
        }
    }
    public function getShimgeProductPower(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getShimgeProductPower = ShimgeProductAttributes::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku']])->first();
            return $getShimgeProductPower->power;
        }
    }
    public function getShimgeProductMaxflow(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getShimgeProductMaxflow = ShimgeProductAttributes::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku']])->first();
            return $getShimgeProductMaxflow->maxflow;
        }
    }
    public function getShimgeProductVertical(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getShimgeProductVertical = ShimgeProductAttributes::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku']])->first();
            return $getShimgeProductVertical->vertical;
        }
    }
    public function getShimgeProductIndiameter(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getShimgeProductIndiameter = ShimgeProductAttributes::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku']])->first();
            return $getShimgeProductIndiameter->indiameter;
        }
    }
    public function getShimgeProductOutdiameter(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getShimgeProductOutdiameter = ShimgeProductAttributes::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku']])->first();
            return $getShimgeProductOutdiameter->outdiameter;
        }
    }
}
