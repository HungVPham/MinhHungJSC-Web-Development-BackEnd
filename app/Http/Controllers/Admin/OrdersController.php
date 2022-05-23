<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Order;
use App\OrdersLog;
use App\OrderStatus;
use Session;
use App\user;


class OrdersController extends Controller
{
    public function orders(){
        Session::put('page', 'orders');
        $orders = Order::with('orders_products')->get()->toArray();
        $userDetails = User::get()->toArray();
        // dd($userDetails); die;
        return view('admin.orders.orders')->with(compact('orders', 'userDetails'));
    }

    public function orderDetails($id){
        $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
        $orderStatuses = OrderStatus::where('status',1)->get()->toArray();
        $orderLog = OrdersLog::where('order_id',$id)->orderBy('id','Desc')->get()->toArray();
        // dd($orderStatuses); die;

        if(User::where('id', $orderDetails['user_id'])->first() != Null){
            $userDetails = User::where('id', $orderDetails['user_id'])->first()->toArray();
        }else{
            $userDetails = Null;
        }
        
        // dd($userDetails); die;

        return view('admin.orders.order_details')->with(compact('orderDetails','userDetails','orderStatuses','orderLog'));
    }

    public function updateOrderStatus(Request $request){

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);
            Session::put('success_message','Trạng thái đơn hàng đã được cập nhật thành công.');

            // Update Courier Name and Tracking Number

            if(!empty($data['courier_name']) && !empty($data['tracking_number'])){
                Order::where('id',$data['order_id'])->update(['courier_name'=>$data['courier_name'],'tracking_number'=>$data['tracking_number']]);
            }

            // Send Order Status Update Email

            $orderDetails = Order::with('orders_products')->where('id', $data['order_id'])->first()->toArray();

            $email = $data['email'];

            $messageData = [
                'email' =>  $email,
                'name' => $data['name'],
                'order_id' => $data['order_id'],
                'courier_name' => $data['courier_name'],
                'tracking_number' => $data['tracking_number'],
                'orderDetails' => $orderDetails
            ];

            Mail::send('emails.order_status',$messageData,function($message) use($email){
                $message->to($email)->subject('Trạng Thái Đơn Hàng Đã Được Cập Nhật.');
            });

            // update order log
            $log = new OrdersLog;
            $log->order_id = $data['order_id'];
            $log->order_status = $data['order_status'];
            $log->save();


            return redirect()->back();
        }
   
    }
    
}
