<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Cart;
use Auth;
use App\MaxproProductAttributes;
use App\HhoseProductAttributes;
use App\ShimgeProductAttributes;
use Session;

class ProductsController extends Controller
{
    // listing page general controls
    public function listing(Request $request){
        Paginator::useBootstrap();
        if($request->ajax()){
            $data = $request->all();
            echo "<pre>"; print_r($data); die;
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
    
    // detail page general controls
    public function detail($id){
        $productDetails = Product::with(['category', 'brand', 'MaxproAttributes'=>function($query){
            $query->where('status', 1);
        }, 'HhoseAttributes'=>function($query){
            $query->where('status', 1);
        }, 'ShimgeAttributes'=>function($query){
            $query->where('status', 1);
        }, 'images'=>function($query){
            $query->where('status', 1);}])->find($id)->toArray();
        $total_tools_stock = MaxproProductAttributes::where('product_id', $id)->sum('stock'); 
        $total_hhose_stock = HhoseProductAttributes::where('product_id', $id)->sum('stock'); 
        $total_pump_stock = ShimgeProductAttributes::where('product_id', $id)->sum('stock'); 
        $total_stock =  $total_tools_stock + $total_hhose_stock + $total_pump_stock;
        $relatedProducts = Product::with('brand')->where('category_id', $productDetails['category']['id'])->where('id','!=',$id)->where('status', 1)->limit(4)->inRandomOrder()->get()->toArray();
        // dd($productDetails); die;
        return view('front.products.detail')->with(compact('productDetails', 'total_tools_stock', 'total_hhose_stock', 'total_pump_stock', 'total_stock', 'relatedProducts'));
    }

    /* get maxpro info by sku*/
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
    public function getMaxproProductStock(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getMaxproProductStock = MaxproProductAttributes::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku']])->first();
            return $getMaxproProductStock->stock;
        }
    }
    /* get hhose info by sku*/
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
    public function getHhoseProductStock(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getHhoseProductStock = HhoseProductAttributes::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku']])->first();
            return $getHhoseProductStock->stock;
        }
    }
    /* get shimge info by sku*/
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
    public function getShimgeProductStock(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getShimgeProductStock = ShimgeProductAttributes::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku']])->first();
            return $getShimgeProductStock->stock;
        }
    }

    // add to cart functions 
    public function addtocartmaxpro(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

           // generate section id if not exists
           $session_id = Session::get('session_id');
           if(empty($session_id)){
               $session_id = Session::getId();
               Session::put('session_id', $session_id);
           } 

           // check if product sku is already in user/session cart 
           if(Auth::check()){
            // User is logged in
                $countProducts = Cart::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku'], 'user_id'=>Auth::user()->id])->count();
           }else{
                // User is not logged in
                $countProducts = Cart::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku'], 'session_id'=>Session::get('session_id')])->count();   
           }

           if($countProducts>0){
                $message = "Mã sản phẩm đã tồn tại trong giỏ hàng.";
                session::flash('error_message', $message);
                return redirect()->back();
           }

           // save product in cart

           $cart = new Cart;
           $cart->session_id = $session_id;
           $cart->product_id = $data['product_id'];
           $cart->sku = $data['sku'];
           $cart->quantity = $data['quantity'];
           $cart->save();
           
           $message = "Sản phẩm đã được thêm vào giỏ hàng.";
           session::flash('success_message', $message);
           return redirect()->back();
        }
    }
    public function addtocarthhose(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            // generate section id if not exists
           $session_id = Session::get('session_id');
           if(empty($session_id)){
               $session_id = Session::getId();
               Session::put('session_id', $session_id);
           } 

           // check if product sku is already in user/session cart
           if(Auth::check()){
            // User is logged in
                $countProducts = Cart::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku'], 'user_id'=>Auth::user()->id])->count();
           }else{
                // User is not logged in
                $countProducts = Cart::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku'], 'session_id'=>Session::get('session_id')])->count();   
           }
           
           if($countProducts>0){
                $message = "Mã sản phẩm đã tồn tại trong giỏ hàng.";
                session::flash('error_message', $message);
                return redirect()->back();
           }

            // save product in cart

           $cart = new Cart;
           $cart->session_id = $session_id;
           $cart->product_id = $data['product_id'];
           $cart->sku = $data['sku'];
           $cart->quantity = $data['quantity'];
           $cart->save();
           
           $message = "Sản phẩm đã được thêm vào giỏ hàng.";
           session::flash('success_message', $message);
           return redirect()->back();
        }
    } 
    public function addtocartshimge(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            // generate section id if not exists
           $session_id = Session::get('session_id');
           if(empty($session_id)){
               $session_id = Session::getId();
               Session::put('session_id', $session_id);
           } 

            // check if product sku is already in user/session cart 
           if(Auth::check()){
            // User is logged in
                $countProducts = Cart::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku'], 'user_id'=>Auth::user()->id])->count();
           }else{
                // User is not logged in
                $countProducts = Cart::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku'], 'session_id'=>Session::get('session_id')])->count();   
           }

           if($countProducts>0){
                $message = "Mã sản phẩm đã tồn tại trong giỏ hàng.";
                session::flash('error_message', $message);
                return redirect()->back();
           }

           // save product in cart
        
           $cart = new Cart;
           $cart->session_id = $session_id;
           $cart->product_id = $data['product_id'];
           $cart->sku = $data['sku'];
           $cart->quantity = $data['quantity'];
           $cart->save();

           
           $message = "Sản phẩm đã được thêm vào giỏ hàng.";
           session::flash('success_message', $message);
           return redirect()->back();
        }
    }  

    // display added items in cart page
    public function cart(){
        $userCartItems = Cart::userCartItems();
        // echo "<pre>"; print_r($userCartItems); die;
        return view('front.products.cart')->with(compact('userCartItems'));
    }
}
