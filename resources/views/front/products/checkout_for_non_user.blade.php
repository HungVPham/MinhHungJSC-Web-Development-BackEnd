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
        .voucher-containter{
            margin-top: 0px;
            width: 100%
        }
        .voucher-containter .btn:first-child{
            border: 2px solid black;
            color: #00000030;
            background: #ffffff;
            margin-right: 10px;
        }
        .voucher-containter .btn:first-child:hover{
            border-color: var(--MinhHung-Red) !important;
            color: #000000 !important;
        }
        h5 a:nth-child(2){
            color: #444;
        }
        h5 a:nth-child(2):hover{
            color: var(--MinhHung-Red) !important;
        }
        form .btn{
            width: inherit;
        }
        #address, #order-note{
            margin: 5px;
            margin-left: 0px;
            margin-right: 10px;
        }
        .cart-table tr td:nth-child(3), .cart-table tr td:nth-child(4), .cart-table tr th:nth-child(3), .cart-table tr th:nth-child(4) {
            display: revert;
        }
        #full_name-error, #mobile-error, #email-error, #address-error, #payment_method-error{
            display: block;
            font-size: 16px;
            font-weight: 700;
            width: 100%;
            text-align: left;
            color: var(--MinhHung-Red);
            margin-left: 5px;
        }
        p {
            margin-bottom: 0;
        }
    </style>
<!--Cart Items Details-->
<div class="small-container cart-page">
    <form name="checkoutForm" id="checkoutForm" action="{{ url('/checkout-for-non-user') }}" method="post">@csrf
    <div class="row listing head first cart">
        <h5><a href="{{ url('/') }}">Trang Chủ</a> / <a href="{{ url('/cart') }}">Giỏ Hàng</a> / Thanh Toán</h5>
    </div>
    <h2>Thanh Toán</h2>
    <div id="cart-container">
    <div style="overflow-x:auto;">
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
                <td>Phí Vận Chuyển</td>
                <td>
                    <span>0 ₫</span> 
                </td>
            </tr>
            <tr>
                <td>Tổng Thanh Toán</td>
                <td class="totalAmount">
                    <?php 
                    $format = number_format($total_price,0,",",".");
                     echo $format;
                    ?> ₫
                     <?php Session::put('total_price',$total_price); ?>
                </td>
            </tr>
        </table>
    </div>
    <div class="voucher-containter">
            <label><strong>Thông Tin Quý Khách Mua Hàng</strong></label>
            <div class="price-quotation-form-containter">
                <div class="price-quotation-input-containter">
                    <input id="full_name" name="full_name" placeholder="Họ và tên (bắt buộc)">
                </div>
                <div class="price-quotation-input-containter">
                    <input id="mobile" name="mobile" placeholder="Số điện thoại (bắt buộc)">
                </div>
                <div class="price-quotation-input-containter">
                    <input type="email" id="email" name="email" placeholder="Email (bắt buộc)">
                </div>
                <div class="price-quotation-input-containter">
                    <input id="company_name" name="company_name" placeholder="Tên doanh nghiệp (nếu có)">
                </div> 
                <div class="price-quotation-input-containter">
                    <input id="address" name="address" placeholder="Địa chỉ nhận hàng (bắt buộc)">
                </div>
                <div class="price-quotation-input-containter">
                    <input id="order_note" name="order_note" placeholder="Ghi chú đơn hàng (nếu có)">
                </div>
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
                                <strong>Chủ Đề:</strong> (Họ Tên - Số Điện Thoại) + Thanh Toán (Tên Sản Phẩm).
                            </p>
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