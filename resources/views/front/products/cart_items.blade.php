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
</style>
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
                <img src="{{ asset('images/product_images/main_image/small/'.$cartItems['product']['main_image']) }}">
                <div>
                    <h5> 
                        <?php echo
                        $cartItems['brand']['name']
                        ?>
                    </h5>
                    <h4 title="{{ $cartItems['product']['product_name'] }}">{{ $cartItems['product']['product_name'] }}</h4>
                    <p>Mã: {{ $cartItems['sku'] }}</p>
                    <p>Giá: 
                        @if($cartItems['product']['section_id'] == 1)
                        <?php 
                        $num = $proMaxproPrice['product_price'];
                        $format = number_format($num,0,",",".");
                        echo $format;
                        ?> ₫
                        @endif
                        @if($cartItems['product']['section_id'] == 3)
                        <?php 
                        $num = $proShimgePrice['product_price'];
                        $format = number_format($num,0,",",".");
                        echo $format;
                        ?> ₫
                        @endif
                    </p>
                </div>
            </div>
        </td>
        <td>
            <div class="number-input">
                <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()"></button>
                <input class="quantity" min="1" name="quantity" min="1" value="{{ $cartItems['quantity'] }}" type="number">
                <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
            </div>
        </td>
        <td>
            @if($cartItems['product']['section_id'] == 1)
            <?php
            $num = $proMaxproPrice['discount_amount']*$cartItems['quantity'];
            $format = number_format($num,0,",",".");
            echo $format;
            ?> ₫
            @endif
            @if($cartItems['product']['section_id'] == 3)
            <?php
            $num = $proShimgePrice['discount_amount']*$cartItems['quantity'];
            $format = number_format($num,0,",",".");
            echo $format;
            ?> ₫
            @endif
        </td>
        <td><a href="{{ url('/'.$cartItems['category']['url']) }}"><i class="fas fa-search"></i> tìm tương tự</a> | <a href=""><i class="fas fa-trash"></i></a></td>
        <td>
            @if($cartItems['product']['section_id'] == 1)
            <?php
                $num = $proMaxproPrice['product_price'] * $cartItems['quantity'] - ($cartItems['quantity'] * $proMaxproPrice['discount_amount']);
                $format = number_format($num,0,",",".");
                echo $format;
            ?> ₫
            @endif
            @if($cartItems['product']['section_id'] == 3)
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
    @endif
    @if($cartItems['product']['section_id'] == 3)
    <?php 
    $total_shimge_price+= ($proShimgePrice['product_price'] * $cartItems['quantity'] - ($cartItems['quantity'] * $proShimgePrice['discount_amount']));
    $total_maxpro_discount+= $proShimgePrice['discount_amount']*$cartItems['quantity'];
    ?>
    @endif
    @endforeach
</table>
<div class="total-price">
    <div class="voucher-containter">
        <label for="voucher">Nhập Mã Khuyến Mãi:</label>
        <input class="voucher" type="text">
        <p style="text-align: center;"><button onclick="goBack()" class="btn">&larr; Mua Sắm Tiếp</button><button @if(empty($userCartItems)) disabled @endif class="btn">Mua Hàng</button></p>
    </div>
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
            <td>Tổng Khuyến Mãi</td>
            <td>
                <?php 
               $total_voucher = 0; 
               $format = number_format($total_voucher,0,",",".");
                echo $format;
               ?> ₫
            </td>
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