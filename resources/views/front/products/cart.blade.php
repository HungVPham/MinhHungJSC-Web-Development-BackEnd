<?php 
use App\Cart;
?>
@extends('layouts.front_layout.front_layout')
@section('content')
<!--Cart Items Details-->
<div class="small-container cart-page">
    <div class="row listing head first cart">
        <h5><a href="{{ url('/') }}">Trang Chủ</a> / Giỏ Hàng</h5>
    </div>
    <h2>Giỏ Hàng</h2>
    <table>
        <tr>
            <th>Thông Tin Sản Phẩm</th>
            <th>Số Lượng</th>
            <th>Giảm Giá</th>
            <th>Thao Tác</th>
            <th>Giá Tổng</th>
        </tr>
        <?php 
        $total_maxpro_price = 0; 
        $total_shimge_price = 0; 
        ?>
        @foreach($userCartItems as $key => $cartItems)
        <?php 
        $attrMaxproPrice = Cart::getMaxproProductAttrPrice($cartItems['product_id'], $cartItems['sku']);

        $attrShimgePrice = Cart::getShimgeProductAttrPrice($cartItems['product_id'], $cartItems['sku']);
        ?>
        <tr>
            <td>
                <div class="cart-info">
                    <img src="{{ asset('images/product_images/main_image/small/'.$cartItems['product']['main_image']) }}">
                    <div>
                        <h4 title="{{ $cartItems['product']['product_name'] }}">{{ $cartItems['product']['product_name'] }}</h4>
                        <p>Mã: {{ $cartItems['sku'] }}</p>
                        <p>Giá: 
                            @if($cartItems['product']['section_id'] == 1)
                            <?php 
                            $num = $attrMaxproPrice['price'];
                            $format = number_format($num,0,",",".");
                            echo $format;
                            ?> ₫
                            @endif
                            @if($cartItems['product']['section_id'] == 3)
                            <?php 
                            $num = $attrShimgePrice['price'];
                            $format = number_format($num,0,",",".");
                            echo $format;
                            ?> ₫
                            @endif
                        </p>
                    </div>
                </div>
            </td>
            <td><input type="number" min="1" value="{{ $cartItems['quantity'] }}"></td>
            <td>0 ₫</td>
            <td><a href=""><i class="fas fa-search"></i> tìm tương tự</a> | <a href=""><i class="fas fa-trash"></i></a></td>
            <td>
                @if($cartItems['product']['section_id'] == 1)
                <?php
                    $num = $attrMaxproPrice['price'] * $cartItems['quantity'];
                    $format = number_format($num,0,",",".");
                    echo $format;
                ?> ₫
                @endif
                @if($cartItems['product']['section_id'] == 3)
                <?php
                $num = $attrShimgePrice['price'] * $cartItems['quantity'];
                $format = number_format($num,0,",",".");
                echo $format;
                ?> ₫
                @endif
            </td>
        </tr>
        @if($cartItems['product']['section_id'] == 1)
        <?php $total_maxpro_price+= ($attrMaxproPrice['price'] * $cartItems['quantity']);
        ?>
        @endif
        @if($cartItems['product']['section_id'] == 3)
        <?php $total_shimge_price+= ($attrShimgePrice['price'] * $cartItems['quantity']);
        ?>
        @endif
        @endforeach
    </table>
    @if(empty($userCartItems))
        <p class="empt-cart-noti">chưa có sản phẩm nào trong giỏ</p>
    @endif
    <div class="total-price">
        <div class="voucher-containter">
            <label for="voucher">Nhập Mã Khuyến Mãi:</label>
            <input class="voucher" type="text">
            <p style="text-align: center;"><button class="btn">&larr; Mua Sắm Tiếp</button><button @if(empty($userCartItems)) disabled @endif class="btn">Mua Hàng</button></p>
        </div>
        <table>
            <tr>
                <td>Tổng Giá</td>
                <td>
                   <?php 
                   $total_price = $total_shimge_price + $total_maxpro_price; 
                   $format = number_format($total_price,0,",",".");
                    echo $format;
                   ?> ₫
                </td>
            </tr>
            <tr>
                <td>Tổng Khuyến Mãi</td>
                <td>0 ₫</td>
            </tr>
            <tr>
                <td>Tổng Cộng</td>
                <td>
                    <?php 
                    $format = number_format($total_price,0,",",".");
                     echo $format;
                    ?> ₫
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection