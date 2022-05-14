<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Mail;
// use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Crypt;
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

             // send price quotation email to admin
             $email = "hung.v.pham002@gmail.com";
             $messageData = [
                 'email' => $data['email'],
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
    } // send email to interest user about product price quotes

    public function getStockRefill(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                'full_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'mobile' => 'required',
                'email' => 'required',
            ];  
            $customMessages = [
                'full_name.regex' => 'Tên không hợp lệ. Quý khách vui lòng thử lại.',
                'full_name.required' => 'Quý khách vui lòng điền họ tên để nhận thông báo.',
                'mobile.required' => 'Quý khách vui lòng điền số điện thoại để nhận thông báo.',
                'email.required' => 'Quý khách vui lòng điền email để nhận thông báo.',
            ];
            $this->validate($request, $rules, $customMessages);

             // send stock refill alert email to admin
             $email = "hung.v.pham002@gmail.com";
             $messageData = [
                 'email' => $data['email'],
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
        if($request->isMethod('post')){
            $data = $request->all();
            // echo Session::get('grand_total');

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

            DB::beginTransaction();

            // insert order details

            $order = new Order;
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
            $order->shipping_charges = 0;
            $order->coupon_code = Session::get('couponCode');
            $order->coupon_amount = Session::get('couponAmount');
            $order->order_status = "New";
            $order->payment_method = $payment_method;
            $order->payment_gateway = $data['payment_gateway'];
            $order->grand_total = Session::get('grand_total');
            $order->company_name = Auth::user()->company_name;
            $order->note = $data['order_note'];

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
            }

            // empty the user cart

           

            Session::put('order_id', $order_id);

            DB::commit();

            // echo "Order Placed"; die;

            // Insert order id in Session Variable
        
            if($data['payment_gateway'] == "COD" || $data['payment_gateway'] == "Banking"){
                return redirect('/thanks');
            }

        }

        $userCartItems = Cart::userCartItems();
        $deliveryAddresses = DeliveryAddress::deliveryAddresses();
        
        if(!empty($userCartItems)){
        return view('front.products.checkout')->with(compact('userCartItems', 'deliveryAddresses'));
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

    public function checkOutForNonUser(Request $request){

        if($request->isMethod('post')){

            $data = $request->all();
            // echo Session::get('grand_total');

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

            $order = new Order;
            $order->name = $data['full_name'];
            $order->address = $data['address'];
            $order->mobile = $data['mobile'];
            $order->email = $data['email'];
            $order->shipping_charges = 0;
            $order->order_status = "New";
            $order->payment_method = $payment_method;
            $order->payment_gateway = $data['payment_gateway'];
            $order->grand_total = Session::get('total_price');
            $order->company_name = $data['company_name'];
            $order->note = $data['order_note'];

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
             }
         
            Session::put('order_id', $order_id);

            DB::commit();

            if($data['payment_gateway'] == "COD" || $data['payment_gateway'] == "Banking"){
                return redirect('/thanks');
            }

           // echo "Order Placed"; die;


        }
        $userCartItems = Cart::userCartItems();

        if(!empty($userCartItems)){
            return view('front.products.checkout_for_non_user')->with(compact('userCartItems'));
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


}
