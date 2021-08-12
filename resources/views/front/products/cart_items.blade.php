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
<div style="overflow-x:auto;">
<table class="cart-table">
    <tr>
        <th>Thông Tin</th>
        <th>Số Lượng</th>
        <th>Giảm Giá</th>
        <th>Thao Tác</th>
        <th>Số Tiền</th>
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
                    <h4 title="{{ $cartItems['product']['product_name'] }}"><a href="{{ url('sản-phẩm/'.$cartItems['product']['id']) }}">{{ $cartItems['product']['product_name'] }}</a></h4>
                    <p>Phân Loại Hàng: {{ $cartItems['sku'] }}</p>
                </div>
            </div>
        </td>
        <td>
            <div class="number-input">
                <button type="button" data-sectionid="{{ $cartItems['product']['section_id'] }}" data-cartid="{{ $cartItems['id'] }}" class="btnItemUpdate minus"></button>
                <input class="quantity" id="appendedInputButtons" name="quantity" readonly min="1" value="{{ $cartItems['quantity'] }}" type="number">
                <button type="button" data-sectionid="{{ $cartItems['product']['section_id'] }}" data-cartid="{{ $cartItems['id'] }}" class="btnItemUpdate plus"></button>
            </div>
            <a class="search-mobile" href="{{ url('/'.$cartItems['category']['url']) }}"><i class="fas fa-search"></i></a>
            <a class="trash-mobile btnItemDelete" data-cartid="{{ $cartItems['id'] }}"><i class="fas fa-trash"></i></a>
        </td>
        <td>
            @if($cartItems['product']['section_id'] == 1)
            <?php
            $num = $proMaxproPrice['discount_amount']*$cartItems['quantity'];
            $format = number_format($num,0,",",".");
            echo $format;
            ?> ₫
            @elseif($cartItems['product']['section_id'] == 3)
            <?php
            $num = $proShimgePrice['discount_amount']*$cartItems['quantity'];
            $format = number_format($num,0,",",".");
            echo $format;
            ?> ₫
            @endif
        </td>
        <td><a href="{{ url('/'.$cartItems['category']['url']) }}"><i class="fas fa-search"></i> tìm tương tự</a> | <a class="btnItemDelete" data-cartid="{{ $cartItems['id'] }}"><i class="fas fa-trash"></i></a></td>
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
            <td>Khuyến Mãi</td>
            <td>
                - <span class="couponAmount">0 ₫</span> 
            </td>
        </tr>
        <tr>
            <td>Tổng Thanh Toán</td>
            <td class="totalAmount">
                <?php 
                $format = number_format($total_price,0,",",".");
                 echo $format;
                ?> ₫
            </td>
        </tr>
    </table>
</div>
