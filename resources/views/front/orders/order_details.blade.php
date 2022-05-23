@extends('layouts.front_layout.front_layout')
@section('content')
<?php use App\Product; ?>
<style>
    #name-error,#last_name-error, #mobile-error, #chkPwd, #current_pwd-error, #new_pwd-error, #confirm_pwd-error{
    display: block;
    font-size: 16px;
    font-weight: 700;
    width: 100%;
    text-align: left;
    color: var(--MinhHung-Red);
    margin-left: 5px;
    margin-top: -10px
    }
    a:not([href]):not([class]), a:not([href]):not([class]):hover {
        color: var(--Solid-White);
        text-decoration: none;
    }
    .pwd-toggle{
    width: 50px !important;
    position: absolute;
    right: -10px;
    top: 0;
    margin-top: 5px;
    color: rgba(0, 0,0, 0.3) !important;
    cursor: pointer;
    }
    .pwd-toggle.on{
        display: none;
    }

    input{
        margin-bottom: 10px;
    }

    .select2{
        margin-bottom: 10px;
    }
</style>
<div class="myAccount-page">
    <div class="small-container">
        <div class="row">
            <div class="myAccount-page-col-1">
                <div class="tab">
                    <a style="cursor: default;">{{ Auth::user()->last_name }} {{ Auth::user()->name }}</a>
                    <a href="{{ url('/my-account') }}"><i class="fas fa-user"></i>&nbsp;&nbsp;Hồ Sơ Của Tôi</a>
                    <a href="{{ url('/add-edit-delivery-address') }}"><i class="fas fa-map-pin"></i>&nbsp;&nbsp;Địa Chỉ Nhận Hàng</a>
                    <a href="{{ url('/orders') }}"><i style="color: var(--MinhHung-Red)" class="fas fa-shopping-bag"></i>&nbsp;&nbsp;Đơn Mua</a>
                </div>
            </div>
            <div class="myAccount-page-col-2">
                <div class="tabcontent">
                    <div class="tabcontent-title">
                    <h2>Thông Tin Đơn Hàng <b>{{ $orderDetails['id'] }}</b></h2>
                    <hr>
                    </div>
                    <div class="form-container-newPwd">
                        <form id="deliveryAddressForm">
                            <table class="cart-table">
                                <tr>
                                    <th style="text-align: left !important">Đơn Hàng</th>    
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>Ngày Đặt: </td>
                                    <td style="text-align: left !important">{{ date('d-m-Y', strtotime($orderDetails['created_at'])) }}</td>
                                </tr>
                                <tr>
                                    <td><b>Trạng Thái:</b></td>
                                    <td style="text-align: left !important">
                                        @if($orderDetails['order_status'] ==  "New")
                                        <b style="color: var(--MaxPro-Orange)">chờ xác nhận</b>
                                        @endif
                                        @if($orderDetails['order_status'] ==  "Pending")
                                        <b style="color: var(--Info-Yellow)">đang giao hàng</b>
                                        @endif
                                        @if($orderDetails['order_status'] ==  "Completed")
                                        <b style="color: #228B22;">đã giao hàng</b>
                                        @endif
                                        @if($orderDetails['order_status'] ==  "Cancelled")
                                        <b style="color: var(--MinhHung-Red)">đã hủy</b>
                                        @endif             
                                    </td>
                                </tr>
                                @if(!empty($orderDetails['courier_name']) && !empty($orderDetails['tracking_number']))
                                <tr>
                                    <td><b>Đại Lý Giao Hàng:</b></td>
                                    <td style="text-align: left !important">{{ $orderDetails['courier_name'] }}</td>
                                </tr>
                                <tr>
                                    <td><b>Số Tracking:</b></td>
                                    <td style="text-align: left !important">{{ $orderDetails['tracking_number'] }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Phí Giao Hàng: </td>
                                    <td style="text-align: left !important">
                                        <?php 
                                        $shipping_charges = $orderDetails['shipping_charges'];
                                        $format = number_format($shipping_charges,0,",",".");
                                        echo $format;
                                        ?> ₫ 
                                    </td>
                                </tr>
                                <tr>
                                    <td>Mã Khuyến Mãi: </td>
                                   
                                    <td style="text-align: left !important">
                                        @if($orderDetails['coupon_code'] ==  NULL)
                                        không áp dụng
                                        @else
                                        {{ $orderDetails['coupon_code'] }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Giá Trị Khuyến Mãi: </td>
                                    <td style="text-align: left !important">
                                        @if($orderDetails['coupon_amount'] ==  NULL)
                                        0 ₫
                                        @else
                                        <?php 
                                        $coupon_amount = $orderDetails['coupon_amount'];
                                        $format = number_format($coupon_amount,0,",",".");
                                        echo $format;
                                        ?> ₫ 
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tổng Giá Trị: </td>
                                    <td style="text-align: left !important">
                                        <?php 
                                        $grand_total = $orderDetails['grand_total'];
                                        $format = number_format($grand_total,0,",",".");
                                        echo $format;
                                        ?> ₫ 
                                    </td>
                                </tr>
                                <tr>
                                    <td>Thanh Toán: </td>
                                    <td style="text-align: left !important"> 
                                         @if($orderDetails['payment_method'] == "COD")
                                        thanh toán khi nhận hàng
                                        @else
                                        chuyển khoản
                                        @endif         
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ghi chú đơn hàng: </td>
                                    <td  style="text-align: left !important">
                                        @if(!empty($orderDetails['note']))
                                        {{ $orderDetails['note']}} 
                                        @else
                                        không có ghi chú
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </form> 
                        <form id="deliver-addresses-container">
                            <table class="cart-table">
                                <tr>
                                    <th style="text-align: left !important">Giao Hàng</th>     
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>Địa Chỉ:</td>
                                    <td style="text-align: left !important">{{ $orderDetails['address'] }}</td>
                                </tr>
                                <tr>
                                    <td>Phường/Xã:</td>
                                    <td style="text-align: left !important">{{ $orderDetails['ward'] }}</td>
                                </tr>
                                <tr>
                                    <td>Quận/Huyện:</td>
                                    <td style="text-align: left !important">{{ $orderDetails['district'] }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 8rem">Tỉnh/Thành Phố:</td>
                                    <td style="text-align: left !important">{{ $orderDetails['province'] }}</td>
                                </tr>
                                <tr>
                                    <td >Người Nhận Hàng:</td>
                                    <td style="text-align: left !important">{{ $orderDetails['name'] }}</td>
                                </tr>
                                <tr>
                                    <td style="width: fit-content">Số Liên Hệ:</td>
                                    <td style="text-align: left !important">{{ $orderDetails['mobile'] }}</td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <br>
                    <table class="cart-table">
                        <tr>
                            <th>Tên Sản Phẩm</th>
                            <th>Hình Ảnh</th>
                            <th>Phân Loại</th>
                            <th>Số Lượng</th>   
                            <th>Trị Giá</th>         
                        </tr>
                        @foreach ($orderDetails['orders_products'] as $product)
                            <tr>
                                <td>
                                    <div class="cart-info">
                                    <h4 title="{{ $product['product_name'] }}"><a href="{{ url('products/'.$product['product_id']) }}">{{ $product['product_name'] }}</a></h4>
                                    </div>
                                </td>
                                <td><?php $getProductImage = Product::getProductImage($product['product_id']) ?>
                                <img style="width: auto;" src="{{ asset('images/product_images/main_image/small/'.$getProductImage) }}"></td>
                                <td>
                                    {{ $product['sku'] }}                          
                                </td>
                                <td>{{ $product['product_qty'] }}</td>
                                <td>
                                    <?php 
                                    $grand_total = $product['product_price'];
                                    $format = number_format($grand_total,0,",",".");
                                     echo $format;
                                    ?> ₫ 
                                </td>                  
                            </tr>
                        @endforeach
                    </table>
                </div>  
            </div>
        </div>
    </div>
</div>
@endsection