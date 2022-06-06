<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Order;
use App\OrdersLog;
use App\OrderStatus;
use Session;
use App\User;

// reference the Dompdf namespace
use Dompdf\Dompdf;


class OrdersController extends Controller
{
    public function orders(){
        Session::put('page', 'orders');
        $orders = Order::with('orders_products')->get()->toArray();
        $userDetails = User::get()->toArray();
        // dd($userDetails); die;
        return view('admin.orders.orders')->with(compact('orders', 'userDetails'));
    }

    public function deleteOrder($id){
        // Delete Product 
        Order::where('id',$id)->delete();

        $message = 'Đơn hàng đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
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
            Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status'], 'shipping_charges'=>$data['shipping_charges']]);
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

    public function viewOrderInvoice($id){
        $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();

        if(User::where('id', $orderDetails['user_id'])->first() != Null){
            $userDetails = User::where('id', $orderDetails['user_id'])->first()->toArray();
        }else{
            $userDetails = Null;
        }

        if($orderDetails['order_status'] == "Pending" || $orderDetails['order_status'] == "Completed"){
            return view('admin.orders.order_invoice')->with(compact('orderDetails', 'userDetails'));
        }else{
            abort(404);
        }
        
    }

    public function printPDFInvoice($id){
        $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();

        if(User::where('id', $orderDetails['user_id'])->first() != Null){
            $userDetails = User::where('id', $orderDetails['user_id'])->first()->toArray();
        }else{
            $userDetails = Null;
        }

        if($orderDetails['order_status'] == "Pending" || $orderDetails['order_status'] == "Completed"){

            $output = '<!DOCTYPE html>
            <html>
              <head>
                <meta charset=utf-8">
                <title>Hóa Đơn</title>
               <style>
               .clearfix:after {
                content: "";
                display: table;
                clear: both;
              }
              
              a {
                color: #5D6975;
                text-decoration: underline;
              }
              
              body {
                position: relative;
                width: 21cm;  
                height: 29.7cm; 
                margin: 0 auto; 
                color: #001028;
                background: #FFFFFF; 
                font-family: DejaVu Sans, sans-serif;
                font-size: 11px; 
              }
              
              header {
                padding: 10px 0;
                margin-bottom: 30px;
              }
              
              #logo {
                text-align: center;
                margin-bottom: 10px;
              }
              
              #logo img {
                width: 90px;
              }
              
              h1 {
                border-top: 1px solid  #5D6975;
                border-bottom: 1px solid  #5D6975;
                color: #5D6975;
                font-size: 2.4em;
                line-height: 1.4em;
                font-weight: normal;
                text-align: center;
                margin: 0 0 20px 0;
                background: url(dimension.png);
              }
              
              #project {
                float: left;
              }
              
              #project span {
                color: #5D6975;
                text-align: right;
                width: 52px;
                margin-right: 10px;
                display: inline-block;
                font-size: 0.8em;
              }
              
              #company {
                float: right;
                text-align: right;
              }
              
              #project div,
              #company div {
                white-space: nowrap;        
              }
              
              table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                margin-bottom: 20px;
              }
              
              table tr:nth-child(2n-1) td {
                background: #F5F5F5;
              }
              
              table th,
              table td {
                text-align: center;
              }
              
              table th {
                padding: 5px 20px;
                color: #5D6975;
                border-bottom: 1px solid #C1CED9;
                white-space: nowrap;        
                font-weight: normal;
              }
              
              table .service,
              table .desc {
                text-align: left;
              }
              
              table td {
                padding: 20px;
                text-align: right;
              }
              
              table td.service,
              table td.desc {
                vertical-align: top;
              }
              
              table td.unit,
              table td.qty,
              table td.total {
                font-size: 1.2em;
              }
              
              table td.grand {
                border-top: 1px solid #5D6975;;
              }
              
              #notices .notice {
                color: #5D6975;
                font-size: 1.2em;
              }
              
              footer {
                color: #5D6975;
                width: 100%;
                height: 30px;
                position: absolute;
                bottom: 0;
                border-top: 1px solid #C1CED9;
                padding: 8px 0;
                text-align: center;
              }

       
               </style>
              </head>
              <body>
                <header class="clearfix">
                  <h1>Hóa Đơn Giá Trị Gia Tăng (Mã Đơn Mua:'.$orderDetails['order_id'].')</h1>
                  <div id="company" class="clearfix">
                    <div>Công Ty Cổ Phần Đầu Tư và Phát Triển Minh Hưng</div>
                    <div>56 Trương Phước Phan, P.Bình Trị Đông, Q.Bình Tân<br /> TP.HCM 700000, Việt Nam</div>
                    <div>(028) 62 666 333</div>
                    <div><a href="mailto:salesminhhung@gmail.com">salesminhhung@gmail.com</a></div>
                  </div>
                  <div id="project">
                    <div><span>Khách Hàng</span> '.$orderDetails['name'].'</div>
                    <div><span>Địa chỉ</span> '.$orderDetails['address'].'</div>
                    <div><span>Phường/Xã</span> '.$orderDetails['ward'].'</div>
                    <div><span>Quận/Huyện</span> '.$orderDetails['district'].'</div>
                    <div><span>Tỉnh/Thành Phố:</span> '.$orderDetails['province'].'</div>
                    <div><span>Quốc Gia:</span> Việt Nam</div>
                    <div><span>EMAIL</span> <a href="mailto:'.$orderDetails['email'].'">'.$orderDetails['email'].'</a></div>
                    <div><span>Ngày đạt hàng:</span> '.date('d-m-Y', strtotime($orderDetails['created_at'])).'</div>
                  </div>
                </header>
                <main>
                  <table>
                    <thead>
                      <tr>
                        <th class="service">Tên Sản Phẩm</th>
                        <th class="desc">Mã Sản Phẩm</th>
                        <th>Giá Trị</th>
                        <th>Số Lượng</th>
                        <th>Số Tiền</th>
                      </tr>
                    </thead>
                    <tbody>';

                    $subTotal = 0;
                    foreach($orderDetails['orders_products'] as $pro){

                      $unit_price = $pro['product_price'];
                      $unit_price_formatted = number_format($unit_price,0,",",".");

                      
                      $total_price = $pro['product_price'] * $pro['product_qty'];
                      $total_price_formatted = number_format($total_price,0,",",".");

                      $output.= '<tr>
                        <td class="service">'.$pro['product_name'].'</td>
                        <td class="desc">'.$pro['sku'].'</td>
                        <td class="unit"> '.$unit_price_formatted.' ₫ </td>
                        <td class="qty"> '.$pro['product_qty'].'</td>
                        <td class="total"> '.$total_price_formatted.' ₫ </td>
                      </tr>';
                      $subTotal = $subTotal + ($pro['product_price'] * $pro['product_qty']);

                    }
                      $subTotal_formatted = number_format($subTotal,0,",",".");
                      $output.= '
                      <tr>
                        <td colspan="4">Tổng Giá</td>
                        <td class="total">'.$subTotal_formatted.' ₫</td>
                      </tr>
                      <tr>
                        <td colspan="4">Khuyến Mãi</td>
                        <td class="total"> - '.number_format($orderDetails['coupon_amount'] ,0,",",".").' ₫</td>
                      </tr>
                      <tr>
                        <td colspan="4">Phí Vận Chuyển</td>
                        <td class="total">'.number_format($orderDetails['shipping_charges'] ,0,",",".").' ₫</td>
                      </tr>
                      <tr>
                        <td colspan="4" class="grand total">Tổng Thanh Toán</td>
                        <td class="grand total">'.number_format($orderDetails['grand_total'] + $orderDetails['shipping_charges'],0,",",".").' ₫</td>
                      </tr>
                    </tbody>
                  </table>
                  <div id="notices">
                    <div>Ghi Chú Đơn Mua:</div>
                    <div class="notice">'.$orderDetails['note'].'</div>
                  </div>
                </main>
                <footer>
                  Hóa đơn điện tử hợp pháp không cần dấu hay chữ ký.
                </footer>
              </body>
            </html>';

            // instantiate and use the dompdf class
            $dompdf = new Dompdf();
            $dompdf->loadHtml($output);

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'landscape');

            // Render the HTML as PDF
            $dompdf->render();
   
            $fileNo = $orderDetails['order_id'];

            $name = $orderDetails['name'];

            $description = "Hoá Đơn Điện Tử";

            // Output the generated PDF to Browser
            $dompdf->stream($fileNo."-".$name."-".$description.".pdf");

        }else{
            abort(404);
        }    
    }
}
