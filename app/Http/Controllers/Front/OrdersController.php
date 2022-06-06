<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use Auth;
use App\User;
// reference the Dompdf namespace
use Dompdf\Dompdf;

class OrdersController extends Controller
{
    public function orders(){
        $orders = Order::with('orders_products')->where('user_id', Auth::user()->id)->orderBy('id','Desc')->get()->toArray();
        
        // dd($orders); die;

        return view('front.orders.orders')->with(compact('orders'));
    }

    public function orderDetails($id){

        if(Order::where('id',$id)->exists()){
            $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
        }else{
            abort(404);
        }
    
        if(Auth::user()->id == $orderDetails['user_id']){

            // dd($orderDetails); die;

            return view('front.orders.order_details')->with(compact('orderDetails'));

        }else{
            abort(404);
        }

      
    }
}
