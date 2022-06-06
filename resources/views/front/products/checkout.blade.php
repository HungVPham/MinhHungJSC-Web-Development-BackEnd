@extends('layouts.front_layout.front_layout')
@section('content')
<?php 
use App\Product;
?>
<style>
    .number-input {
        border: 2px solid #888;
        display: inline-flex;
        height: 28px;
        margin: 0px;
        margin-bottom: 8px;
    }
    .empty-cart .btn{
        border: 2px solid black;
        color: #00000030;
        background: #ffffff;
    }
    .empty-cart .btn:hover{
        border-color: var(--MinhHung-Red) !important;
        color: #000000 !important;   
    }
    .voucher-containter .btn{
        width: 45%;
    }
    .voucher-containter .btn:first-child{
        border: 2px solid black;
        color: #00000030;
        background: #ffffff;
    }
    .voucher-containter .btn:first-child:hover{
        border-color: var(--MinhHung-Red) !important;
        color: #000000 !important;
    }
    .voucher-containter .btn:nth-child(2){
        margin-left: 10px; 
    }
    h5 a:nth-child(2){
        color: #444;
    }
    h5 a:nth-child(2):hover{
        color: var(--MinhHung-Red) !important;
    }
    .cart-table tr td:nth-child(3), .cart-table tr td:nth-child(4), .cart-table tr th:nth-child(3), .cart-table tr th:nth-child(4) {
        display: revert;
    }

    .fas{
        font-size: 20px;
    }

    #invoice_tax_num-error, #invoice_comp_name-error, #invoice_comp_address-error{
            display: block;
            font-size: 16px;
            font-weight: 700;
            width: 100%;
            text-align: left;
            color: var(--MinhHung-Red);
            margin-left: 5px;
        }
</style>
<script type="text/javascript">
  function invoiceChecked()
    {
        if($('#invoice_request').is(":checked"))   
            $("#invoiceInputs").show();
        else
            $("#invoiceInputs").hide();
    }
</script>
  
<!--Cart Items Details-->
<div class="small-container cart-page">
    <form name="checkoutForm" id="checkoutForm" action="{{ url('/checkout') }}" method="post">@csrf
        <div class="row listing head first cart">
            <h5><a href="{{ url('/') }}">Trang Chủ</a> / <a href="{{ url('/cart') }}">Giỏ Hàng</a> / Thanh Toán</h5>
        </div>
        <h2>Thanh Toán</h2>
        <div id="cart-container">
        <div style="overflow-x:auto;">
        <div id="delivery-addresses-container">
            @if(Session::has('success_message'))
            <div class="alert alert-danger" role="alert" style="color: #228B22; background-color: #ffffff; border: 1px solid #228B22;">
                {{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if(Session::has('pending_message'))
            <div class="alert alert-danger" role="alert" style="color: var(--Solid-Gold); background-color: #ffffff; border: 1px solid var(--Solid-Gold);">
                {{ Session::get('pending_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if(Session::has('error_message'))
                <div class="alert alert-danger" role="alert" style="color:  var(--Delete-Red) ; background-color: #ffffff; border: 1px solid var(--Delete-Red);">
                {{ Session::get('error_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            @endif    
            @if ($errors->any())
            <div class="alert alert-danger" style="color: var(--Delete-Red); background-color: #ffffff; border: 1px solid var(--Delete-Red)">
            <ul>
                @foreach ($errors->all() as $error)
                <li style="margin-left: 20px">{{ $error }}</li>
                @endforeach
            </ul>
            </div>
            @endif
            <div class="shopee-mail-effect"></div>
            <table id="delivery-addresses-table">
                <tr>
                    <th><i style="color: var(--MinhHung-Red)" class="fas fa-map-pin"></i>&nbsp;&nbsp;Địa Chỉ Nhận Hàng&nbsp;&nbsp;|<a title="thêm địa chỉ nhận hàng" href="{{ url('add-edit-delivery-address') }}"><i class="fas fa-plus"></i></a></th>
                </tr>
                @if(!empty($deliveryAddresses))
                    @foreach($deliveryAddresses as $address)
                    <tr>
                        <td>
                            <input type="radio" @if($address['is_default']=="Yes") checked @endif id="address {{ $address['id'] }}" name="address_id" value="{{ $address['id'] }}">@if($address['is_default']=="Yes") <span style="color: var(--Positive-Green)">(Mặc Định)</span>@endif
                            {{ $address['name'] }} -  
                            {{ $address['address'] }}, 
                            {{ $address['ward'] }}, 
                            {{ $address['district'] }}, 
                            {{ $address['province'] }}, 
                            @if(!empty($address['state']))
                            {{ $address['state'] }}, 
                            @endif
                            {{ $address['country'] }} 
                            (SĐT: {{ $address['mobile'] }})
                        </td>
                        <td><a title="sửa địa chỉ nhận hàng" href="{{ url('add-edit-delivery-address/'.Crypt::encrypt($address['id'])) }}"><i class="fas fa-edit"></i></a>@if($address['is_default']=="No")<a title="xóa địa chỉ nhận hàng" class="addressDelete" record="delivery-address" recordid="{{ Crypt::encrypt($address['id']) }}" href="javascript:void(0)"><i class="fas fa-trash"></i></a>@endif</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td style="text-align: center">Quý khách hiện chưa có địa chỉ nhận hàng.</td>
                    </tr>
                @endif
            </table>
        </div>
        <table class="cart-table">
            <tr>
                <th>Thông Tin</th>
                <th style="text-align: right">Đơn Giá</th>
                <th style="text-align: right">Số Lượng</th>
                <th>Thành Tiền</th>
            </tr>
            <?php 
            $total_maxpro_price = 0; 
            $total_shimge_price = 0; 
            $total_maxpro_discount = 0; 
            $total_shimge_discount = 0;
            ?>
            @foreach($userCartItems as $key => $cartItems)
            <?php 
            $proMaxproPrice = Product::getDiscountedMaxproPrice($cartItems['product_id'], $cartItems['sku']);        
            $proShimgePrice = Product::getDiscountedShimgePrice($cartItems['product_id'], $cartItems['sku']);
            ?>
            <tr>
                <td>
                    <div class="cart-info">
                        <?php $product_image_path = "images/product_images/main_image/small/".$cartItems['product']['main_image']; ?>
                        @if(!empty($cartItems['product']['main_image']) && file_exists($product_image_path))
                        <img style="width: 100px;" src="{{ asset('images/product_images/main_image/small/'.$cartItems['product']['main_image']) }}">
                        @else
                        <img style="width: 100px;" src="{{ asset('images/product_images/main_image/small/no-img.jpg') }}">
                        @endif
                        <div>
                            <h5> 
                                <?php echo
                                $cartItems['brand']['name']
                                ?>
                            </h5>
                            <h4 title="{{ $cartItems['product']['product_name'] }}">{{ $cartItems['product']['product_name'] }}</h4>
                            <p>Phân Loại Hàng: {{ $cartItems['sku'] }}</p>
                        </div>
                    </div>
                </td>
                <td>
                    <p style="text-align: right"> @if($cartItems['product']['section_id'] == 1)
                    <?php
                    $num = $proMaxproPrice['discounted_price'];
                    $format = number_format($num,0,",",".");
                    echo $format;
                    ?> ₫
                    @elseif($cartItems['product']['section_id'] == 3)
                    <?php
                    $num = $proShimgePrice['discounted_price'];
                    $format = number_format($num,0,",",".");
                    echo $format;
                    ?> ₫
                    @endif</p>
                </td>
                <td>
                    <p style="text-align: right">{{ $cartItems['quantity'] }}</p>
                </td>
                <td>
                    @if($cartItems['product']['section_id'] == 1)
                    <?php
                        $num = $proMaxproPrice['product_price'] * $cartItems['quantity'] - ($cartItems['quantity'] * $proMaxproPrice['discount_amount']);
                        $format = number_format($num,0,",",".");
                        echo $format;
                    ?> ₫
                    @elseif($cartItems['product']['section_id'] == 3)
                    <?php
                    $num = $proShimgePrice['product_price'] * $cartItems['quantity'] - ($cartItems['quantity'] * $proShimgePrice['discount_amount']);
                    $format = number_format($num,0,",",".");
                    echo $format;
                    ?> ₫
                    @endif
                </td>
            </tr>
            @if($cartItems['product']['section_id'] == 1)
            <?php 
            $total_maxpro_price+= ($proMaxproPrice['product_price'] * $cartItems['quantity'] - ($cartItems['quantity'] * $proMaxproPrice['discount_amount']));
            $total_maxpro_discount+= $proMaxproPrice['discount_amount']*$cartItems['quantity'];
            ?>
            @elseif($cartItems['product']['section_id'] == 3)
            <?php 
            $total_shimge_price+= ($proShimgePrice['product_price'] * $cartItems['quantity'] - ($cartItems['quantity'] * $proShimgePrice['discount_amount']));
            $total_maxpro_discount+= $proShimgePrice['discount_amount']*$cartItems['quantity'];
            ?>
            @endif
            @endforeach
        </table>
        </div>
        <div class="total-price">
            <table>
                <tr>
                    <td>Tổng Giá <small style="color: #888;">@if($total_shimge_discount + $total_maxpro_discount > 0)&nbsp;(đã trừ giảm giá <?php 
                        $total_discount = $total_shimge_discount + $total_maxpro_discount; 
                        $format = number_format($total_discount,0,",",".");
                        echo $format;
                        ?> ₫)</small>@endif
                    </td>
                    <td>
                    <?php 
                    $total_price = $total_shimge_price + $total_maxpro_price; 
                    $format = number_format($total_price,0,",",".");
                        echo $format;
                    ?> ₫
                    </td>
                </tr>
                <tr>
                    <td>
                        @if(Session::has('couponCode'))
                        Mã Khuyến Mãi: <span style="color: var(--MinhHung-Red)">{{ Session::get('couponCode') }}</span>
                        @else
                        Khuyến Mãi
                        @endif
                    </td>
                    <td>
                        - <span class="couponAmount">
                            @if(Session::has('couponAmount'))
                            <?php 
                            $format = number_format(Session::get('couponAmount'),0,",",".");
                            echo $format;
                            ?> ₫
                            @else
                            0 ₫
                            @endif
                        </span> 
                    </td>
                </tr>
                <tr>
                    <td>Tổng Thanh Toán</td>
                    <td class="totalAmount">
                        <?php 
                        $format = number_format($grand_total = $total_price - Session::get('couponAmount'),0,",",".");
                        echo $format;
                        ?> ₫
                        <?php Session::put('grand_total',$grand_total); ?>
                    </td>
                </tr>
            </table>
        </div>
            <div class="voucher-containter" style="margin-top: -150px !important;">
                <div id="user_order_note">
                    <textarea style="width: 100%;" placeholder="Ghi chú đơn hàng (nếu có)" id="order_note" name="order_note"></textarea>
                </div>
                <div id="payment-methods-container">
                    <table id="payment-methods-table">
                        <tr>
                            <th>Phương Thức Thanh Toán</th>
                        </tr>
                        <tr>
                            <td>
                                <input type="radio" id="payment_method_cod" name="payment_gateway" checked value="COD">&nbsp;Thanh Toán Khi Nhận Hàng (COD) &nbsp; | &nbsp;
                                <input type="radio" id="payment_method_banking" name="payment_gateway" value="Banking">&nbsp;Chuyển Khoản 
                                <p id="bankingInfo" style="border: 2px solid var(--MinhHung-Red); margin-top: 10px; max-width: max-content; padding: 10px; display: none;">
                                    <strong>Thông Tin Chuyển Khoản</strong>
                                    <br>
                                    <strong>Số tài khoản:</strong> 167931999.
                                    <br>
                                    <strong>Chủ tài khoản:</strong> CÔNG TY CỔ PHẦN ĐẦU TƯ VÀ PHÁT TRIỂN MINH HƯNG.
                                    <br>
                                    <strong>Ngân Hàng:</strong> Ngân hàng Á Châu (ACB) – Chi nhánh Phú Lâm.
                                    <br>
                                    <strong>Chủ Đề:</strong> (Họ Tên - Số Điện Thoại) + Thanh Toán (Mã Sản Phẩm).
                                </p>
                                <div style="margin-top: 10px; display: block;"><input type="checkbox" autocomplete="off" id="invoice_request" value="1" name="invoice_req" onchange="invoiceChecked()">&nbsp;Xuất Hóa Đơn?</div>
                                <div style="display: none;" id="invoiceInputs" class="price-quotation-form-containter">
                                    <div class="price-quotation-input-containter">
                                        <input style="height: 38px; width: 100%; font-size: 1rem;" id="invoice_tax_num" name="invoice_tax_num" placeholder=" Mã số thuế">
                                    </div>
                                    <div class="price-quotation-input-containter">
                                        <input style="height: 38px; width: 100%; font-size: 1rem;" id="invoice_comp_name" name="invoice_comp_name" placeholder=" Tên doanh nghiệp">
                                    </div>
                                    <div class="price-quotation-input-containter">
                                        <input style="height: 38px; width: 100%; font-size: 1rem;" id="invoice_comp_address" name="invoice_comp_address" placeholder=" Địa chỉ doanh nghiệp">
                                    </div>
                                </div>     
                            </td>
                        </tr>
                    </table>
                </div>
                <p><a href="{{ url('/cart') }}" class="btn">&larr; Xem Lại Giỏ</a><button type="submit" class="btn">Đặt Hàng</button></p>
                
            </div>
        </div>
    </form>
</div>
@endsection