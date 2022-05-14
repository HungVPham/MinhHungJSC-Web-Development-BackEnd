@extends('layouts.front_layout.front_layout')
@section('content')
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
                    <h2>Đơn Mua</h2>
                    <h5>Quản lý dơn hàng</h5>
                    <hr>
                    </div>
                    <table class="cart-table">
                        <tr>
                            <th>Đơn Hàng</th>
                            <th>Phân Loại/Số Lượng</th>
                            <th>Thanh Toán</th>
                            <th>Trị Giá</th>
                            <th>Ngày Đặt</th>
                            <th>Thao tác</th>
                        </tr>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order['id'] }}</td>
                                <td>
                                    @foreach($order['orders_products'] as $pro)
                                    &#9900; {{ $pro['sku'] }} <b>x {{ $pro['product_qty']}}</b><br>
                                    @endforeach
                                </td>
                                <td>
                                    @if($order['payment_method'] == "COD")
                                    thanh toán khi nhận hàng
                                    @else
                                    chuyển khoản
                                    @endif                            
                                </td>
                                <td>
                                    <?php 
                                    $grand_total = $order['grand_total'];
                                    $format = number_format($grand_total,0,",",".");
                                     echo $format;
                                    ?> ₫ 
                                </td>
                                <td>{{ date('d-m-Y', strtotime($order['created_at'])) }}</td>
                                <td><a href="{{ url('orders/'.$order['id']) }}" title="xem chi tiết"><i class="fas fa-edit"></i></a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>  
            </div>
        </div>
    </div>
</div>
@endsection