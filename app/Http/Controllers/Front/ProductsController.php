<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Mail;
// use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Section;
use App\Product;
use App\Cart;
use App\Coupon;
use App\User;
use App\DeliveryAddress;
use Auth;
use App\MaxproProductAttributes;
use App\HhoseProductAttributes;
use App\ShimgeProductAttributes;
use App\Country;
use App\Province;
use App\District;
use App\Ward;
use Session;
use App\Order;
use App\OrdersProduct;
use DB;
use App\ShippingCharge;

class ProductsController extends Controller
{
    
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
    } // categories listing page general controls

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
    } // section listing page general controls
    
    public function detail($id){

        $productDetails = Product::with(['category', 'brand', 'MaxproAttributes'=>function($query){
            $query->where('status', 1);
        }, 'HhoseAttributes'=>function($query){
            $query->where('status', 1);
        }, 'ShimgeAttributes'=>function($query){
            $query->where('status', 1);
        }, 'images'=>function($query){
            $query->where('status', 1);}])->where('status', 1)->findOrFail($id)->toArray();
        
        $total_tools_stock = MaxproProductAttributes::where(['product_id'=>$id, 'status'=>1])->sum('stock'); 
        $total_hhose_stock = HhoseProductAttributes::where(['product_id'=>$id, 'status'=>1])->sum('stock'); 
        $total_pump_stock = ShimgeProductAttributes::where(['product_id'=>$id, 'status'=>1])->sum('stock'); 
        $total_stock =  $total_tools_stock + $total_hhose_stock + $total_pump_stock;
        $relatedProducts = Product::with('brand')->where('category_id', $productDetails['category']['id'])->where('id','!=',$id)->where('status', 1)->limit(4)->inRandomOrder()->get()->toArray();
        // dd($productDetails); die;
        return view('front.products.detail')->with(compact('productDetails', 'total_tools_stock', 'total_hhose_stock', 'total_pump_stock', 'total_stock', 'relatedProducts'));
    } // detail page general controls
  
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
    }  /* get maxpro info by sku*/
   
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
    } /* get hhose info by sku*/
   
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
    } /* get shimge info by sku*/

    // add to cart functions 
    public function addtocartmaxpro(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $rules = [
                'sku' => 'required',
            ];  
            $customMessages = [
                'sku.required' => 'Quý khách vui lòng thêm mã sản phẩm quan tâm.'
            ];
            $this->validate($request, $rules, $customMessages);

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

           if(Auth::check()){
               $user_id = Auth::user()->id;
           }else{
               $user_id = 0;
           }

           // save product in cart

           $cart = new Cart;
           $cart->session_id = $session_id;
           $cart->user_id = $user_id;

           $cart->section_id = 1;
        
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
    } // add maxpro product attribute to cart
    // public function addtocarthhose(Request $request){
    //     if($request->isMethod('post')){
    //         $data = $request->all();
    //         // echo "<pre>"; print_r($data); die;

    //         // generate section id if not exists
    //        $session_id = Session::get('session_id');
    //        if(empty($session_id)){
    //            $session_id = Session::getId();
    //            Session::put('session_id', $session_id);
    //        } 

    //        // check if product sku is already in user/session cart
    //        if(Auth::check()){
    //         // User is logged in
    //             $countProducts = Cart::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku'], 'user_id'=>Auth::user()->id])->count();
    //        }else{
    //             // User is not logged in
    //             $countProducts = Cart::where(['product_id'=>$data['product_id'], 'sku'=>$data['sku'], 'session_id'=>Session::get('session_id')])->count();   
    //        }
           
    //        if($countProducts>0){
    //             $message = "Mã sản phẩm đã tồn tại trong giỏ hàng.";
    //             session::flash('error_message', $message);
    //             return redirect()->back();
    //        }

    //         // save product in cart

    //        $cart = new Cart;
    //        $cart->session_id = $session_id;
    //        $cart->product_id = $data['product_id'];
    //        $cart->category_id = $data['category_id'];
    //        $cart->brand_id = $data['brand_id'];
    //        $cart->sku = $data['sku'];
    //        $cart->quantity = $data['quantity'];
    //        $cart->save();
           
    //        $message = "Sản phẩm đã được thêm vào giỏ hàng.";
    //        session::flash('success_message', $message);
    //        return redirect()->back();
    //     }
    // } 
    public function addtocartshimge(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                'sku' => 'required',
            ];  
            $customMessages = [
                'sku.required' => 'Quý khách vui lòng thêm mã sản phẩm quan tâm.'
            ];
            $this->validate($request, $rules, $customMessages);

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

           
           if(Auth::check()){
            $user_id = Auth::user()->id;
            }else{
                $user_id = 0;
            }

           // save product in cart
        
           $cart = new Cart;
           $cart->session_id = $session_id;
           $cart->user_id = $user_id;
           $cart->product_id = $data['product_id'];
           $cart->category_id = $data['category_id'];
           $cart->brand_id = $data['brand_id'];

           $cart->section_id = 3;

           $cart->sku = $data['sku'];
           $cart->quantity = $data['quantity'];
           $cart->save();

           
           $message = "Sản phẩm đã được thêm vào giỏ hàng.";
           session::flash('success_message', $message);
           return redirect()->back();
        }
    }  // add shimge product attribute to cart

    public function getPriceQuotation(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                'sku' => 'required',
            ];  
            $customMessages = [
                'sku.required' => 'Quý khách vui lòng thêm mã sản phẩm quan tâm.'
            ];
            $this->validate($request, $rules, $customMessages);

            if(empty($data['email'])){
                // send price quotation email to admin
                $email = "hung.v.pham002@gmail.com";
                $messageData = [
                    'email' => $data['sender'],
                    'full_name' => $data['full_name'],
                    'mobile' => $data['mobile'],
                    'company' => $data['company'],
                    'sku' => $data['sku'],
                    'product_name' => $data['product_name'],
                    'brand_name' => $data['brand_name'],
                    'category_name' => $data['category_name'],
                    'product_id' => $data['product_id'],
                ];
                Mail::send('emails.price_quotation',$messageData,function($message) use($email){ 
                    $message->to($email)->subject('Yêu Cầu Báo Giá');
                });
    
                $message = "Cám ơn quý khách đã gửi yêu cầu báo giá sản phẩm.
                Vui lòng kiểm tra email để nhận thông tin trong thời gian sớm nhất!";
                session::flash('success_message', $message);
                return redirect()->back();
            }
         }
    } // send email to interest user about product price quotes

    public function getStockRefill(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                'full_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'mobile' => 'required',
                'sender' => 'required',
                'sku' => 'required',
            ];  
            $customMessages = [
                'full_name.regex' => 'Tên không hợp lệ. Quý khách vui lòng thử lại.',
                'full_name.required' => 'Quý khách vui lòng điền họ tên để nhận thông báo.',
                'mobile.required' => 'Quý khách vui lòng điền số điện thoại để nhận thông báo.',
                'sender.required' => 'Quý khách vui lòng điền email để nhận thông báo.',
                'sku.required' => 'Quý khách vui lòng thêm mã sản phẩm quan tâm.'
            ];
            $this->validate($request, $rules, $customMessages);

            if(empty($data['email'])){
                // send stock refill alert email to admin
                $email = "hung.v.pham002@gmail.com";
                $messageData = [
                    'email' => $data['sender'],
                    'full_name' => $data['full_name'],
                    'mobile' => $data['mobile'],
                    'company' => $data['company'],
                    'sku' => $data['sku'],
                    'product_name' => $data['product_name'],
                    'brand_name' => $data['brand_name'],
                    'category_name' => $data['category_name'],
                    'product_id' => $data['product_id'],
                ];
                Mail::send('emails.stock_refill',$messageData,function($message) use($email){ 
                    $message->to($email)->subject('Yêu Cầu thông báo khi tồn kho');
                });
    
                $message = "Cám ơn quý khách đã gửi yêu cầu thông báo khi tồn kho sản phẩm.
                Vui lòng kiểm tra email để nhận thông tin trong thời gian sớm nhất!";
                session::flash('success_message', $message);
                return redirect()->back();
            }
         }
    } // send email to interest user about product stock refill

    
    public function cart(){
        $userCartItems = Cart::userCartItems();
        // echo "<pre>"; print_r($userCartItems); die;
        return view('front.products.cart')->with(compact('userCartItems'));
    }// display added items in cart page

    public function updateCartItemQty(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die; 

            // get cart details
            $cartDetails = Cart::find($data['cartid']);

            // get available product stocks
            if($data['secid']==1){
                $availableMaxproStock = MaxproProductAttributes::select('stock')->where(['product_id'=>$cartDetails['product_id'], 'sku'=>$cartDetails['sku']])->first()->toArray();

                // check if maxpro product stock is available
                if($data['qty']>$availableMaxproStock['stock']){
                    $userCartItems = Cart::userCartItems();

                    $couponAmount = 0;
                    $couponCode = null;
                    Session::put('couponAmount',$couponAmount);
                    Session::put('couponCode',$couponCode);

                    return response()->json([
                        'status'=>false,
                        'message'=>'Đã đạt đến số lượng mua tối đa cho phép của sản phẩm này.',
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                    ]);
                }
            }else if($data['secid']==3){
                $availableShimgeStock = ShimgeProductAttributes::select('stock')->where(['product_id'=>$cartDetails['product_id'], 'sku'=>$cartDetails['sku']])->first()->toArray();

                // check if shimge pumps stock is available
                if($data['qty']>$availableShimgeStock['stock']){
                    $userCartItems = Cart::userCartItems();

                    $couponAmount = 0;
                    Session::put('couponAmount',$couponAmount);

                    return response()->json([
                        'status'=>false,
                        'message'=>'Đã đạt đến số lượng mua tối đa cho phép của sản phẩm này.',
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                    ]);
                }
            }

            // check if sku is available
            if($data['secid']==1){
                $availableMaxproSKU = MaxproProductAttributes::where(['product_id'=>$cartDetails['product_id'], 'sku'=>$cartDetails['sku'], 'status'=>1])->count();

                // check if maxpro product stock is available
                if($availableMaxproSKU==0){
                    $userCartItems = Cart::userCartItems();

                    $couponAmount = 0;
                    $couponCode = null;
                    Session::put('couponAmount',$couponAmount);
                    Session::put('couponCode',$couponCode);

                    return response()->json([
                        'status'=>false,
                        'message'=>'Mã sản phẩm hiện không khả dụng.',
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                    ]);
                }
            }else if($data['secid']==3){
                $availableMaxproSKU = ShimgeProductAttributes::where(['product_id'=>$cartDetails['product_id'], 'sku'=>$cartDetails['sku'], 'status'=>1])->count();

                // check if shimge pumps stock is available
                if($availableMaxproSKU==0){
                    $userCartItems = Cart::userCartItems();
                    
                    $couponAmount = 0;
                    $couponCode = null;
                    Session::put('couponAmount',$couponAmount);
                    Session::put('couponCode',$couponCode);

                    return response()->json([
                        'status'=>false,
                        'message'=>'Mã sản phẩm hiện không khả dụng.',
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                    ]);
                }
            }
            
    
            Cart::where('id', $data['cartid'])->update(['quantity'=>$data['qty']]);
            $userCartItems = Cart::userCartItems();
            $totalCartItems = totalCartItems();

            $couponAmount = 0;
            $couponCode = null;
            Session::put('couponAmount',$couponAmount);
            Session::put('couponCode',$couponCode);

            return response()->json([
                'status'=>true,
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
            ]);
        }
    }// update cart item qty via ajax

    public function deleteCartItem(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            Cart::where('id', $data['cartid'])->delete();
            $userCartItems = Cart::userCartItems();
            $totalCartItems = totalCartItems();

            $couponAmount = 0;
            $couponCode = null;
            Session::put('couponAmount',$couponAmount);
            Session::put('couponCode',$couponCode);

            return response()->json([
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
            ]);
        }
    }// delete cart item via ajax

    public function applyCoupon(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $couponCount = Coupon::where('coupon_code',$data['code'])->count();
            $userCartItems = Cart::userCartItems();
            $totalCartItems = totalCartItems();

            if($couponCount==0){
                $message = 'Mã khuyến mãi không tồn tại.';

                Session::forget('couponCode');
                Session::forget('couponAmount');
                
                return response()->json([
                    'status'=>false, 
                    'message'=>$message,
                    'totalCartItems'=>$totalCartItems,
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                ]);
            }else{
                // check for other coupon conditions
                $couponDetails = Coupon::where('coupon_code', $data['code'])->first();
                // echo "<pre>"; print_r($couponDetails); die;

                if($couponDetails->status==0){
                    $message = 'Mã khuyến mãi hiện chưa hoạt động.';
                }

                $expiry_date = $couponDetails->expiry_date;
                $current_date = date('Y-m-d');
                if($expiry_date < $current_date){
                    $message = 'Mã khuyến mãi đã hết hạn sử dụng.'.' ['.$expiry_date.']';
                }

                // Check if coupon is single/multiple
                if($couponDetails->coupon_type == "Single"){
                    // check if orders table if coupon already availed by the user
                    $couponCount = Order::where(['coupon_code'=>$data['code'], 'user_id'=>Auth::user()->id])->count();
                    
                    if($couponCount >= 1){
                        $message = 'Mã khuyến mãi đã được sử dụng.';
                    }
                }

                $catArr = explode(",",$couponDetails->categories);
                if(!empty($couponDetails['categories'])){
                    foreach($userCartItems as $key => $item){
                        if(!in_array($item['product']['category_id'], $catArr)){
                            $message = 'Mã khuyến mãi không áp dụng cho sản phẩm trong giỏ.';
                        }
                    }
                }
                
                $userArr = explode(",",$couponDetails->users);
                if(!empty($couponDetails['users'])){
                    foreach($userArr as $key => $user){
                        $getUserID = User::select('id')->where('email', $user)->first()->toArray();
                        $userID[] = $getUserID['id'];
                    }
                    foreach($userCartItems as $key => $item){
                        if(!in_array($item['user_id'],$userID)){
                            $message = 'Mã khuyến mãi không áp dụng cho bạn, nếu đây là sự nhầm lẫn, xin vui lòng liên hệ với chúng tôi.';
                        }
                    }
                }

                $total_amount = 0;
                foreach($userCartItems as $key => $item){
                    if($item['product']['section_id']==1){
                        $attrPrice = Product::getDiscountedMaxproPrice($item['product_id'], $item['sku']);
                    }elseif($item['product']['section_id']==3){
                        $attrPrice = Product::getDiscountedShimgePrice($item['product_id'], $item['sku']);
                    }
                    $total_amount = $total_amount + ($attrPrice['discounted_price']*($item['quantity']));
                }
                
                // echo $total_amount; die;

                if(isset($message)){
                    return response()->json([
                        'status'=>false, 
                        'message'=>$message,
                        'totalCartItems'=>$totalCartItems,
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                    ]);
                }else{
                    // echo "Coupon can successfully be redeem"; die;
                    if($couponDetails->amount_type=="Fixed"){
                        $couponAmount = $couponDetails->amount;
                        $totalAmount = $total_amount - $couponDetails->amount;
                    }else{
                        $couponAmount = $total_amount*$couponDetails->amount/100;
                        $totalAmount = $total_amount- ($total_amount*$couponDetails->amount/100);
                    }
                    // echo $couponAmount; die;
                    Session::put('couponAmount',$couponAmount);
                    Session::put('couponCode',$data['code']);

                    $message = "Mã giảm giá đã được áp dụng thành công!";

                    return response()->json([
                        'status'=>true, 
                        'message'=>$message,
                        'totalCartItems'=>$totalCartItems,
                        'couponAmount'=>$couponAmount,
                        'totalAmount'=>$totalAmount,
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                    ]);
                }
            }
        }
    }// apply coupon via ajax

    public function checkout(Request $request){

        $userCartItems = Cart::userCartItems();

        $total_maxpro_price = 0; 
        $total_shimge_price = 0; 
        $total_maxpro_discount = 0; 
        $total_shimge_discount = 0;
        $total_weight = 0;

        foreach($userCartItems as $key => $cartItems){
            // echo "<pre>"; print_r($cartItems); die;

            $product_weight = $cartItems['product']['product_weight'];

            $total_weight += $product_weight * $cartItems['quantity'];

            $proMaxproPrice = Product::getDiscountedMaxproPrice($cartItems['product_id'], $cartItems['sku']);        
            $proShimgePrice = Product::getDiscountedShimgePrice($cartItems['product_id'], $cartItems['sku']);

            if($cartItems['product']['section_id'] == 1){
                $total_maxpro_price+= ($proMaxproPrice['product_price'] * $cartItems['quantity'] - ($cartItems['quantity'] * $proMaxproPrice['discount_amount']));
                $total_maxpro_discount+= $proMaxproPrice['discount_amount']*$cartItems['quantity'];
            }elseif($cartItems['product']['section_id'] == 3){
                $total_shimge_price+= ($proShimgePrice['product_price'] * $cartItems['quantity'] - ($cartItems['quantity'] * $proShimgePrice['discount_amount']));
                $total_shimge_discount+= $proShimgePrice['discount_amount']*$cartItems['quantity'];
            }
        }

        $total_price = $total_shimge_price + $total_maxpro_price; 

        $deliveryAddresses = DeliveryAddress::deliveryAddresses();

        foreach($deliveryAddresses as $key => $value){
            $shippingCharges = ShippingCharge::getShippingCharges($value['province_id'], $value['district_id'], $value['ward_id'], $total_weight);

            $deliveryAddresses[$key]['shipping_charges'] = $shippingCharges;
        }


        // dd($userCartItems); die;
      
        if($request->isMethod('post')){
            $data = $request->all();

            // Website Security Checks

            // fetch user cart items 
            foreach($userCartItems as $key => $cart){
                // Prevent disabled product to order

                $product_count = Product::getProductCount($cart['product_id']);
                $productAttr_count = Product::getProductAttributeCount($cart['section_id'], $cart['product_id'], $cart['sku']);
                $productAttr_stock = Product::getProductAttributeStock($cart['section_id'], $cart['product_id'], $cart['sku']);
                $category_count = Product::getCategoryCount($cart['category_id']);

                if($product_count == 0 || $category_count == 0){
                    Product::deleteCartProduct($cart['product_id']);
                    $message = "Dòng sản phẩm ".$cart['product']['product_name']." hiện không có sẵn.";
                    session::flash('error_message', $message);
                    return redirect('/cart');
                }

                if($productAttr_count == 0 || $productAttr_stock == 0){
                    Product::deleteCartProductAttr($cart['product_id'], $cart['sku']);
                    $message = "Mã sản phẩm ".$cart['sku']." hiện không có sẵn.";
                    session::flash('error_message', $message);
                    return redirect('/cart');
                }
            }

            if(empty($data['address_id'])){
                $message = "Xin vui lòng chọn địa chỉ nhận hàng!";
                session::flash('error_message', $message);
                return redirect()->back();
            }

            if(empty($data['payment_gateway'])){
                $message = "Xin vui lòng chọn phương thức thanh toán!";
                session::flash('error_message', $message);
                return redirect()->back();
            }

            // print_r($data); die;

            if($data['payment_gateway'] == "COD"){
                $payment_method = "COD";
            }else{
                $payment_method = "Banking";
            }

            // Get delivery details from address id

            $deliveryAddress = DeliveryAddress::where('id', $data['address_id'])->first()->toArray();
           // dd($deliveryAddress); die;
           
           // get shipping charges 

           $shipping_charges = ShippingCharge::getShippingCharges($deliveryAddress['province_id'], $deliveryAddress['district_id'], $deliveryAddress['ward_id'], $total_weight);

           // calculate grand_total

           $grand_total = $total_price + $shipping_charges - Session::get('couponAmount');

            // insert ggrand total in session

            Session::put('grand_total', $grand_total);

            DB::beginTransaction();

            // insert order details

            $numbers = '0123456789';
            $characters = 'abcdefghijklmnopqrstuvwxyz';
            $randomString = '';
            
            for ($i = 0; $i < 4; $i++) {
                $index = rand(0, strlen($numbers) - 1);
                $randomString .= $numbers[$index];
            }

            $randomString .= '-';

            for ($i = 4; $i < 7; $i++) {
                $index = rand(0, strlen($characters) - 1);
                $randomString .= $characters[$index];
            }

            $randomString .= '-';

            for ($i = 7; $i < 10; $i++) {
                $index = rand(0, strlen($numbers) - 1);
                $randomString .= $numbers[$index];
            }
        
            $uuid = $randomString;

            $order = new Order;

            $order->order_id = $uuid;

            $order->user_id = Auth::user()->id;
            $order->name = $deliveryAddress['name'];
            $order->address = $deliveryAddress['address'];
            $order->ward = $deliveryAddress['ward'];
            $order->district = $deliveryAddress['district'];
            $order->province = $deliveryAddress['province'];
            $order->state = $deliveryAddress['state'];
            $order->country = $deliveryAddress['country'];
            $order->mobile = $deliveryAddress['mobile'];
            $order->email = Auth::user()->email;
            $order->shipping_charges = $shipping_charges;
            $order->coupon_code = Session::get('couponCode');
            $order->coupon_amount = Session::get('couponAmount');
            $order->order_status = "New";
            $order->payment_method = $payment_method;
            $order->payment_gateway = $data['payment_gateway'];
            $order->grand_total = Session::get('grand_total');
            $order->company_name = Auth::user()->company_name;
            $order->note = $data['order_note'];

            if(empty($data['invoice_req'])){
                $data['invoice_req'] = 0;
            }

            if($data['invoice_req'] == 1){
                $order->invoice_req = $data['invoice_req'];
                $order->invoice_tax_num = $data['invoice_tax_num'];
                $order->invoice_comp_name = $data['invoice_comp_name'];
                $order->invoice_comp_address = $data['invoice_comp_address'];
            }
        
            $order->save();

            // Get last Order Id

            $order_id = DB::getPdo() -> lastInsertId();

            // Get User Cart Items
            $cartItems = Cart::where('user_id', Auth::user() -> id)->get()->toArray();

            foreach($cartItems as $key => $item){
                $cartItem = new OrdersProduct;
                $cartItem->order_id = $order_id;
                $cartItem->user_id = Auth::user()->id;

                $getProductDetails = Product::select('product_code','product_name','section_id')->where('id',$item['product_id'])->first()->toArray();

                $cartItem->product_id = $item['product_id'];
                $cartItem->product_name = $getProductDetails['product_name'];
                $cartItem->product_code = $getProductDetails['product_code'];
                $cartItem->sku = $item['sku'];

                if($getProductDetails['section_id'] == 1){
                    $getDiscountedAttrPrice = Product::getDiscountedMaxproPrice($item['product_id'], $item['sku']);
                }else if($getProductDetails['section_id'] == 3){
                    $getDiscountedAttrPrice = Product::getDiscountedShimgePrice($item['product_id'], $item['sku']);
                }

                $cartItem->product_price = $getDiscountedAttrPrice['discounted_price'];
                $cartItem->product_qty = $item['quantity'];

                $cartItem->save();

                // reduce stock script starts

                if($getProductDetails['section_id'] == 1){
                    $getProductStock = MaxproProductAttributes::where(['product_id'=>$item['product_id'],'sku'=>$item['sku']])->first()->toArray();
                }else if($getProductDetails['section_id'] == 3){
                    $getProductStock = ShimgeProductAttributes::where(['product_id'=>$item['product_id'],'sku'=>$item['sku']])->first()->toArray();
                }

                $newStock = $getProductStock['stock'] - $item['quantity'];

                if($getProductDetails['section_id'] == 1){
                    $getProductStock = MaxproProductAttributes::where(['product_id'=>$item['product_id'],'sku'=>$item['sku']])->update(['stock'=>$newStock]);
                }else if($getProductDetails['section_id'] == 3){
                    $getProductStock = ShimgeProductAttributes::where(['product_id'=>$item['product_id'],'sku'=>$item['sku']])->update(['stock'=>$newStock]);
                }

                // reduce stock script ends  
            }

            // empty the user cart

           

            Session::put('order_id', $uuid);

            DB::commit();

            // echo "Order Placed"; die;

            // Insert order id in Session Variable
        
            if($data['payment_gateway'] == "COD" || $data['payment_gateway'] == "Banking"){

                $orderDetails = Order::with('orders_products')->where('id', $order_id)->first()->toArray();

                // dd($orderDetails); die;

                // Send order email

                $email = Auth::user()->email;
                $messageData = [
                    'email' => $email,
                    'name' => Auth::user()->name,
                    'order_id' => $order_id,
                    'orderDetails' => $orderDetails
                ];

                Mail::send('emails.order',$messageData,function($message) use($email){
                    $message->to($email)->subject('Đơn Hàng Đã Được Đặt Thành Công! - MinhHưngJSC');
                });



                return redirect('/thanks');
            }

        }

        // dd($deliveryAddresses); die;
        
        if(!empty($userCartItems)){
        return view('front.products.checkout')->with(compact('userCartItems', 'deliveryAddresses', 'total_price'));
        }else{
            abort(404);
        }
    }

    public function checkOutForNonUser(Request $request){

        $userCartItems = Cart::userCartItems();

        $provinces = Province::get()->toArray();

        if($request->isMethod('post')){
            // Website Security Checks

            // fetch user cart items 
            foreach($userCartItems as $key => $cart){
                // Prevent disabled product to order

                $product_count = Product::getProductCount($cart['product_id']);
                $productAttr_count = Product::getProductAttributeCount($cart['section_id'], $cart['product_id'], $cart['sku']);
                $productAttr_stock = Product::getProductAttributeStock($cart['section_id'], $cart['product_id'], $cart['sku']);
                $category_count = Product::getCategoryCount($cart['category_id']);

                if($product_count == 0 || $category_count == 0){
                    Product::deleteCartProduct($cart['product_id']);
                    $message = "Dòng sản phẩm ".$cart['product']['product_name']." hiện không có sẵn.";
                    session::flash('error_message', $message);
                    return redirect('/cart');
                }

                if($productAttr_count == 0 || $productAttr_stock == 0){
                    Product::deleteCartProductAttr($cart['product_id'], $cart['sku']);
                    $message = "Mã sản phẩm ".$cart['sku']." hiện không có sẵn.";
                    session::flash('error_message', $message);
                    return redirect('/cart');
                }
            }


            $data = $request->all();
            // echo Session::get('grand_total');
            // print_r($data); die;

            $rules = [
                'province' => 'required',
                'district' => 'required',
                'ward' => 'required',
            ];  
            $customMessages = [
                'province.required' => 'Vui lòng chọn tỉnh/thành.',
                'district.required' => 'Vui lòng chọn quận/huyện.',
                'ward.required' => 'Vui lòng chọn phường/xã.',
            ];
            $this->validate($request, $rules, $customMessages);

            if(empty($data['email'])){
                if(empty($data['payment_gateway'])){
                    $message = "Xin vui lòng chọn phương thức thanh toán!";
                    session::flash('error_message', $message);
                    return redirect()->back();
                }
    
                // print_r($data); die;
    
                if($data['payment_gateway'] == "COD"){
                    $payment_method = "COD";
                }else{
                    $payment_method = "Banking";
                }
    
                DB::beginTransaction();
    
                
                // insert order details
    
                $numbers = '0123456789';
                $characters = 'abcdefghijklmnopqrstuvwxyz';
                $randomString = '';
                
                for ($i = 0; $i < 4; $i++) {
                    $index = rand(0, strlen($numbers) - 1);
                    $randomString .= $numbers[$index];
                }
    
                $randomString .= '-';
    
                for ($i = 4; $i < 7; $i++) {
                    $index = rand(0, strlen($characters) - 1);
                    $randomString .= $characters[$index];
                }
    
                $randomString .= '-';
    
                for ($i = 7; $i < 10; $i++) {
                    $index = rand(0, strlen($numbers) - 1);
                    $randomString .= $numbers[$index];
                }
            
                $uuid = $randomString;
    
                $order = new Order;
    
                $order->order_id = $uuid;

                $getProvinces = Province::where('id', $data['province'])->get();
                $getProvinces = json_decode(json_encode($getProvinces),true);
                $getDistricts = District::where('id', $data['district'])->get();
                $getDistricts = json_decode(json_encode($getDistricts),true);
                $getWards = Ward::where('id', $data['ward'])->get();
                $getWards = json_decode(json_encode($getWards),true);
    
                $order->name = $data['full_name'];
                $order->country = "Việt Nam";
                $order->province = $getProvinces[0]['_prefix'].' '.$getProvinces[0]['_name'];
                $order->district = $getDistricts[0]['_prefix'].' '.$getDistricts[0]['_name'];
                $order->ward = $getWards[0]['_prefix'].' '.$getWards[0]['_name'];
                $order->address = $data['address'];
                $order->mobile = $data['mobile'];
                $order->email = $data['sender'];
                $order->shipping_charges = Session::get('shipping_charges');
                $order->order_status = "New";
                $order->payment_method = $payment_method;
                $order->payment_gateway = $data['payment_gateway'];
                $order->grand_total = Session::get('grand_total');
                $order->company_name = $data['company_name'];
                $order->note = $data['order_note'];

                if(empty($data['invoice_req'])){
                    $data['invoice_req'] = 0;
                }
    
                if($data['invoice_req'] == 1){
                    $order->invoice_req = $data['invoice_req'];
                    $order->invoice_tax_num = $data['invoice_tax_num'];
                    $order->invoice_comp_name = $data['invoice_comp_name'];
                    $order->invoice_comp_address = $data['invoice_comp_address'];
                }

                $order->save();
    
                $order_id = DB::getPdo() -> lastInsertId();
    
                 // Get User Cart Items
                 $cartItems = Cart::where('session_id',Session::get('session_id'))->get()->toArray();
    
                 foreach($cartItems as $key => $item){
                     $cartItem = new OrdersProduct;
                     $cartItem->order_id = $order_id;
     
                     $getProductDetails = Product::select('product_code','product_name','section_id')->where('id',$item['product_id'])->first()->toArray();
     
                     $cartItem->product_id = $item['product_id'];
                     $cartItem->product_name = $getProductDetails['product_name'];
                     $cartItem->product_code = $getProductDetails['product_code'];
                     $cartItem->sku = $item['sku'];
     
                     if($getProductDetails['section_id'] == 1){
                         $getDiscountedAttrPrice = Product::getDiscountedMaxproPrice($item['product_id'], $item['sku']);
                     }else if($getProductDetails['section_id'] == 3){
                         $getDiscountedAttrPrice = Product::getDiscountedShimgePrice($item['product_id'], $item['sku']);
                     }
     
                     $cartItem->product_price = $getDiscountedAttrPrice['discounted_price'];
                     $cartItem->product_qty = $item['quantity'];
     
                     $cartItem->save();

                    // reduce stock script starts

                    if($getProductDetails['section_id'] == 1){
                        $getProductStock = MaxproProductAttributes::where(['product_id'=>$item['product_id'],'sku'=>$item['sku']])->first()->toArray();
                    }else if($getProductDetails['section_id'] == 3){
                        $getProductStock = ShimgeProductAttributes::where(['product_id'=>$item['product_id'],'sku'=>$item['sku']])->first()->toArray();
                    }

                    $newStock = $getProductStock['stock'] - $item['quantity'];

                    if($getProductDetails['section_id'] == 1){
                        $getProductStock = MaxproProductAttributes::where(['product_id'=>$item['product_id'],'sku'=>$item['sku']])->update(['stock'=>$newStock]);
                    }else if($getProductDetails['section_id'] == 3){
                        $getProductStock = ShimgeProductAttributes::where(['product_id'=>$item['product_id'],'sku'=>$item['sku']])->update(['stock'=>$newStock]);
                    }

                    // reduce stock script ends
                 }
             
                Session::put('order_id', $uuid);
    
                DB::commit();
    
                if($data['payment_gateway'] == "COD" || $data['payment_gateway'] == "Banking"){
    
                    $orderDetails = Order::with('orders_products')->where('id', $order_id)->first()->toArray();
    
                    // dd($orderDetails); die;
    
                    // Send order email
    
                    $email = $data['sender'];
                    $full_name =  $data['full_name'];
                    
                    $messageData = [
                        'email' => $email,
                        'name' => $full_name,
                        'orderDetails' => $orderDetails
                    ];
    
                    Mail::send('emails.order',$messageData,function($message) use($email){
                        $message->to($email)->subject('Đơn Hàng Đã Được Đặt Thành Công! - MinhHưngJSC');
                    });
    
                    return redirect('/thanks');
                }
            }
        
           // echo "Order Placed"; die;

        }

        if(!empty($userCartItems)){
            return view('front.products.checkout_for_non_user')->with(compact('userCartItems', 'provinces'));
        }else{
            abort(404);
        }
        
    }

    public function thanks(){
        // Empty the User Cart

        if(Session::has('order_id')){
            
            if(Auth::check()){
                Cart::where('user_id',Auth::user()->id)->delete();
            }else{
                Cart::where('session_id',Session::get('session_id'))->delete();
            }

            return view('front.products.thanks');
    
        }else{
            abort(404);
        }

    }

    public function addEditDeliveryAddress($id=null, Request $request){
        
        if($id == ""){
            $title = "Thêm Địa Chỉ Nhận Hàng";
            $address = new DeliveryAddress;
            $message = "Địa chỉ nhận hàng đã được thêm.";
            $getWards = NULL;
            $getDistricts = NULL;
        }else{
            $title = "Sửa Địa Chỉ Nhận Hàng";
            $message = "Địa chỉ nhận hàng đã được sửa.";
            $address = DeliveryAddress::findOrFail(Crypt::decrypt($id));
            $getWards = Ward::where('_district_id', $address['district_id'])->get();
            $getWards = json_decode(json_encode($getWards),true);
            $getDistricts = District::where('_province_id', $address['province_id'])->get();
            $getDistricts = json_decode(json_encode($getDistricts),true);
        }

        $countries = Country::where('status', 1)->get()->toArray();
        $provinces = Province::get()->toArray();

        $deliveryAddresses = DeliveryAddress::deliveryAddresses();

        $addressCount = DeliveryAddress::where('status', 1)->get()->count();
        $defaultAddressCount = DeliveryAddress::where('is_default', "Yes")->get()->count();

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                'name' => 'regex:/^[\pL\s\-]+$/u',
                'province' => 'required',
                'district' => 'required',
                'ward' => 'required',
            ];  
            $customMessages = [
                'name.regex' => 'Tên không hợp lệ.',
                'province.required' => 'Vui lòng chọn tỉnh/thành.',
                'district.required' => 'Vui lòng chọn quận/huyện.',
                'ward.required' => 'Vui lòng chọn phường/xã.',
            ];
            $this->validate($request, $rules, $customMessages);

            $getProvinces = Province::where('id', $data['province'])->get();
            $getProvinces = json_decode(json_encode($getProvinces),true);
            $getDistricts = District::where('id', $data['district'])->get();
            $getDistricts = json_decode(json_encode($getDistricts),true);
            $getWards = Ward::where('id', $data['ward'])->get();
            $getWards = json_decode(json_encode($getWards),true);

            $address->name = $data['name'];
            $address->user_id = Auth::user()->id;
            $address->address = $data['address'];
            $address->province = $getProvinces[0]['_prefix'].' '.$getProvinces[0]['_name'];
            $address->district = $getDistricts[0]['_prefix'].' '.$getDistricts[0]['_name'];
            $address->ward = $getWards[0]['_prefix'].' '.$getWards[0]['_name'];
            $address->province_id = $data['province'];
            $address->district_id = $data['district'];
            $address->ward_id = $data['ward'];
            // $address->state = $data['state'];

            if($addressCount<=0){
                $address->is_default = "Yes";
            }else{
                if(!empty($data['is_default'])){
                    $address->is_default = $data['is_default'];
                }else{
                    $address->is_default = "No";
                }
            }

            if($addressCount>0){
                DeliveryAddress::where("is_default", "Yes")->where("id", '!=', Crypt::decrypt($data['id']))->update(["is_default"=>"No"]);
            }

            $address->country = "Việt Nam";
            $address->mobile = $data['mobile'];
            $address->status = 1;
            $address->save();

            session::flash('success_message', $message);
            return redirect('/add-edit-delivery-address');
        }
        return view('front.users.add_edit_delivery_address')->with(compact('countries', 'title','deliveryAddresses', 'address', 'provinces', 'getDistricts', 'getWards', 'addressCount', 'defaultAddressCount'));
    }

    public function deleteDeliveryAddress($id){
            DeliveryAddress::where('id', Crypt::decrypt($id))->delete();
            $message = "Địa chỉ nhận hàng đã được xóa!";

            session::flash('success_message', $message);
            return redirect()->back();
    }

    public function appendDistrictLevel(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getDistricts = District::where('_province_id', $data['province_id'])->get();
            $getDistricts = json_decode(json_encode($getDistricts),true);
            // echo "<pre>"; print_r($getDistricts); die;
            return view('front.users.append_districts_level')->with(compact('getDistricts'));
        }
    }

    public function appendWardLevel(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getWards = Ward::where('_district_id', $data['district_id'])->get();
            $getWards = json_decode(json_encode($getWards),true);
            // echo "<pre>"; print_r($getWards); die;
            return view('front.users.append_wards_level')->with(compact('getWards'));
        }
    }


    public function appendShippingCharges(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $userCartItems = Cart::userCartItems();

            $total_weight = 0;
          
            foreach($userCartItems as $key => $cartItems){

                $product_weight = $cartItems['product']['product_weight'];

                $total_weight += $product_weight * $cartItems['quantity'];

            }

            $getWard = Ward::where('id', $data['ward_id'])->get()->toArray();

            $shipping_charges = ShippingCharge::getShippingCharges($getWard[0]['_province_id'], $getWard[0]['_district_id'], $getWard[0]['id'], $total_weight);

            Session::put('shipping_charges', $shipping_charges);

            return view('front.users.append_shipping_charges')->with(compact('shipping_charges'));
        }
    }

    public function appendGrandTotal(Request $request){
        if($request->ajax()){

            $userCartItems = Cart::userCartItems();

            $total_maxpro_price = 0; 
            $total_shimge_price = 0; 
            $total_maxpro_discount = 0; 
            $total_shimge_discount = 0;
          
            foreach($userCartItems as $key => $cartItems){

                $proMaxproPrice = Product::getDiscountedMaxproPrice($cartItems['product_id'], $cartItems['sku']);        
                $proShimgePrice = Product::getDiscountedShimgePrice($cartItems['product_id'], $cartItems['sku']);
    
                if($cartItems['product']['section_id'] == 1){
                    $total_maxpro_price+= ($proMaxproPrice['product_price'] * $cartItems['quantity'] - ($cartItems['quantity'] * $proMaxproPrice['discount_amount']));
                    $total_maxpro_discount+= $proMaxproPrice['discount_amount']*$cartItems['quantity'];
                }elseif($cartItems['product']['section_id'] == 3){
                    $total_shimge_price+= ($proShimgePrice['product_price'] * $cartItems['quantity'] - ($cartItems['quantity'] * $proShimgePrice['discount_amount']));
                    $total_shimge_discount+= $proShimgePrice['discount_amount']*$cartItems['quantity'];
                }
                
            }
    
            $grand_total = $total_shimge_price + $total_maxpro_price + Session::get('shipping_charges'); 

            Session::put('grand_total', $grand_total);

            return view('front.users.append_grand_total')->with(compact('grand_total'));

        }
    }
}
