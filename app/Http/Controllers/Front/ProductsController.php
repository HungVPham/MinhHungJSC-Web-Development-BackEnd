<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Section;
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
    public function listing(){
        Paginator::useBootstrap();
        $url = Route::getFacadeRoot()->current()->uri();
        $categoryCount = Category::where(['url'=>$url],['status'=>1])->count();
        if($categoryCount>0){
        $categoryDetails = Category::catDetails($url);
        $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);
        $countCategoryProducts = $categoryProducts -> count();
        
        // check if sort products option is selected 
        if(isset($_GET['sortProducts']) && !empty($_GET['sortProducts'])){
            if($_GET['sortProducts']=="product_latest"){
                $categoryProducts->orderBy('id', 'Desc');
            }else if($_GET['sortProducts']=="product_name_a_z"){
                $categoryProducts->orderBy('product_name', 'Asc');
            }else if($_GET['sortProducts']=="product_name_z_a"){
                $categoryProducts->orderBy('product_name', 'Desc');
            }else if($_GET['sortProducts']=="price_lowest"){
                $categoryProducts->orderBy('product_price', 'Asc');
            }else if($_GET['sortProducts']=="price_highest"){
                $categoryProducts->orderBy('product_price', 'Desc');
            }
        }

        $categoryProducts = $categoryProducts->Paginate(12);
        // echo "<pre>"; print_r($categoryDetails); die;
        return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts', 'url', 'countCategoryProducts'));
        }else{
        abort(404);
        }
    }

    public function Section(){
        Paginator::useBootstrap();
        $url = Route::getFacadeRoot()->current()->uri();
        $sectionCount = Section::where(['url'=>$url],['status'=>1])->count();
        if($sectionCount>0){
        $sectionDetails = Section::secDetails($url);
        $sectionProducts = Product::with('brand')->whereIn('section_id', $sectionDetails['secIds'])->where('status', 1);
        $countSectionProducts = $sectionProducts -> count();

        if(isset($_GET['sort']) && !empty($_GET['sort'])){
            if($_GET['sort']=="product_latest"){
                $sectionProducts->orderBy('id', 'Desc');
            }else if($_GET['sort']=="product_name_a_z"){
                $sectionProducts->orderBy('product_name', 'Asc');
            }else if($_GET['sort']=="product_name_z_a"){
                $sectionProducts->orderBy('product_name', 'Desc');
            }else if($_GET['sort']=="price_lowest"){
                $sectionProducts->orderBy('product_price', 'Asc');
            }else if($_GET['sort']=="price_highest"){
                $sectionProducts->orderBy('product_price', 'Desc');
            }
        }

        $sectionProducts = $sectionProducts->Paginate(12);
        // echo "<pre>"; print_r($sectionProducts); die;
        return view('front.products.section')->with(compact('sectionDetails', 'sectionProducts', 'url', 'countSectionProducts'));
        }else{
        abort(404);
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
        
        if($productDetails['status'] == 1){
        $total_tools_stock = MaxproProductAttributes::where('product_id', $id)->sum('stock'); 
        $total_hhose_stock = HhoseProductAttributes::where('product_id', $id)->sum('stock'); 
        $total_pump_stock = ShimgeProductAttributes::where('product_id', $id)->sum('stock'); 
        $total_stock =  $total_tools_stock + $total_hhose_stock + $total_pump_stock;
        $relatedProducts = Product::with('brand')->where('category_id', $productDetails['category']['id'])->where('id','!=',$id)->where('status', 1)->limit(4)->inRandomOrder()->get()->toArray();
        // dd($productDetails); die;
        return view('front.products.detail')->with(compact('productDetails', 'total_tools_stock', 'total_hhose_stock', 'total_pump_stock', 'total_stock', 'relatedProducts'));
        }else{
            abort(404);
        }
    }

    /* get maxpro info by sku*/
    public function getMaxproProductPrice(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getDiscountedMaxproPrice = Product::getDiscountedMaxproPrice($data['product_id'], $data['sku']);
            
            return $getDiscountedMaxproPrice;
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
            $getDiscountedHhosePrice = Product::getDiscountedHhosePrice($data['product_id'], $data['sku']);
            
            return $getDiscountedHhosePrice;
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
            $getDiscountedShimgePrice = Product::getDiscountedShimgePrice($data['product_id'], $data['sku']);
            
            return $getDiscountedShimgePrice;
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
           $cart->category_id = $data['category_id'];
           $cart->brand_id = $data['brand_id'];
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
           $cart->category_id = $data['category_id'];
           $cart->brand_id = $data['brand_id'];
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
           $cart->category_id = $data['category_id'];
           $cart->brand_id = $data['brand_id'];
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

    public function updateCartItemQty(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die; 
            // $cartDetails = Cart::find($data['cartid']);
            Cart::where('id', $data['cartid'])->update(['quantity'=>$data['qty']]);
            $userCartItems = Cart::userCartItems();
            return response()->json(['view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))]);
        }
    }
}
