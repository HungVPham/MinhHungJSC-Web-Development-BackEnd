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
    </style>
<!--Cart Items Details-->
<div class="small-container cart-page">
    <div class="row listing head first cart">
        <h5><a href="{{ url('/') }}">Trang Chủ</a> / <a href="{{ url('/cart') }}">Giỏ Hàng</a> / Thanh Toán</h5>
    </div>
    <h2>Thanh Toán</h2>
    <div id="cart-container">
    @if(!empty($userCartItems)) 
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
                </td>
            </tr>
        </table>
    </div>
    <div class="voucher-containter">
        <form id="OrderForNonUserForm" action="{{ url('/order-for-non-user') }}" method="post">@csrf
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
                    <input id="company" name="company" placeholder="Tên doanh nghiệp (nếu có)">
                </div> 
                <div class="price-quotation-input-containter">
                    <input id="address" name="address" placeholder="Địa chỉ nhận hàng (bắt buộc)">
                </div>
                <div class="price-quotation-input-containter">
                    <input id="order-note" name="order-note" placeholder="Ghi chú đơn hàng (nếu có)">
                </div>
            </div>     
        <div id="payment-methods-container">
            <table id="payment-methods-table">
                <tr>
                    <th>Phương Thức Thanh Toán</th>
                </tr>
                    <tr>
                        <td>
                            <input type="radio" id="payment_method_cod" name="payment_method" checked value="cod">&nbsp;Thanh Toán Khi Nhận Hàng (COD) &nbsp; | &nbsp;
                            <input type="radio" id="payment_method_banking" name="payment_method" value="banking">&nbsp;Chuyển Khoản
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
    </form>
    </div>
    @else
    <div class="empty-cart">
        <svg viewBox="656 573 264 182" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <rect id="bg-line" stroke="none" fill-opacity="0.2" fill="var(--Solid-Gold)" fill-rule="evenodd" x="656" y="624" width="206" height="38" rx="19"></rect>
            <rect id="bg-line" stroke="none" fill-opacity="0.2" fill="var(--Solid-Gold)" fill-rule="evenodd" x="692" y="665" width="192" height="29" rx="14.5"></rect>
            <rect id="bg-line" stroke="none" fill-opacity="0.2" fill="var(--Solid-Gold)" fill-rule="evenodd" x="678" y="696" width="192" height="33" rx="16.5"></rect>
            <g id="shopping-bag" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(721.000000, 630.000000)">
                <polygon id="Fill-10" fill="#00000070" points="4 29 120 29 120 0 4 0"></polygon>
                <polygon id="Fill-14" fill="#cb1c22" points="120 29 120 0 115.75 0 103 12.4285714 115.75 29"></polygon>
                <polygon id="Fill-15" fill="#cb1c22" points="4 29 4 0 8.25 0 21 12.4285714 8.25 29"></polygon>
                <polygon id="Fill-33" fill="#00000070" points="110 112 121.573723 109.059187 122 29 110 29"></polygon>
                <polygon id="Fill-35" fill-opacity="0.5" fill="#FFFFFF" points="2 107.846154 10 112 10 31 2 31"></polygon>
                <path d="M107.709596,112 L15.2883462,112 C11.2635,112 8,108.70905 8,104.648275 L8,29 L115,29 L115,104.648275 C115,108.70905 111.7365,112 107.709596,112" id="Fill-36" fill="#cb1c22"></path>
                <path d="M122,97.4615385 L122,104.230231 C122,108.521154 118.534483,112 114.257931,112 L9.74206897,112 C5.46551724,112 2,108.521154 2,104.230231 L2,58" id="Stroke-4916" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
                <polyline id="Stroke-4917" stroke="#000000" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" points="2 41.5 2 29 122 29 122 79"></polyline>
                <path d="M4,50 C4,51.104 3.104,52 2,52 C0.896,52 0,51.104 0,50 C0,48.896 0.896,48 2,48 C3.104,48 4,48.896 4,50" id="Fill-4918" fill="#000000"></path>
                <path d="M122,87 L122,89" id="Stroke-4919" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
                <polygon id="Stroke-4922" stroke="#000000" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" points="4 29 120 29 120 0 4 0"></polygon>
                <path d="M87,46 L87,58.3333333 C87,71.9 75.75,83 62,83 L62,83 C48.25,83 37,71.9 37,58.3333333 L37,46" id="Stroke-4923" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
                <path d="M31,45 C31,41.686 33.686,39 37,39 C40.314,39 43,41.686 43,45" id="Stroke-4924" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
                <path d="M81,45 C81,41.686 83.686,39 87,39 C90.314,39 93,41.686 93,45" id="Stroke-4925" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
                <path d="M8,0 L20,12" id="Stroke-4928" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
                <path d="M20,12 L8,29" id="Stroke-4929" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
                <path d="M20,12 L20,29" id="Stroke-4930" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
                <path d="M115,0 L103,12" id="Stroke-4931" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
                <path d="M103,12 L115,29" id="Stroke-4932" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
                <path d="M103,12 L103,29" id="Stroke-4933" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
            </g>
            <g id="glow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(768.000000, 615.000000)">
                <rect id="Rectangle-2" fill="#000000" x="14" y="0" width="2" height="9" rx="1"></rect>
                <rect fill="#000000" transform="translate(7.601883, 6.142354) rotate(-12.000000) translate(-7.601883, -6.142354) " x="6.60188267" y="3.14235449" width="2" height="6" rx="1"></rect>
                <rect fill="#000000" transform="translate(1.540235, 7.782080) rotate(-25.000000) translate(-1.540235, -7.782080) " x="0.54023518" y="6.28207994" width="2" height="3" rx="1"></rect>
                <rect fill="#000000" transform="translate(29.540235, 7.782080) scale(-1, 1) rotate(-25.000000) translate(-29.540235, -7.782080) " x="28.5402352" y="6.28207994" width="2" height="3" rx="1"></rect>
                <rect fill="#000000" transform="translate(22.601883, 6.142354) scale(-1, 1) rotate(-12.000000) translate(-22.601883, -6.142354) " x="21.6018827" y="3.14235449" width="2" height="6" rx="1"></rect>
            </g>
            <polygon id="plus" stroke="none" fill="#7DBFEB" fill-rule="evenodd" points="689.681239 597.614697 689.681239 596 690.771974 596 690.771974 597.614697 692.408077 597.614697 692.408077 598.691161 690.771974 598.691161 690.771974 600.350404 689.681239 600.350404 689.681239 598.691161 688 598.691161 688 597.614697"></polygon>
            <polygon id="plus" stroke="none" fill="#EEE332" fill-rule="evenodd" points="913.288398 701.226961 913.288398 699 914.773039 699 914.773039 701.226961 917 701.226961 917 702.711602 914.773039 702.711602 914.773039 705 913.288398 705 913.288398 702.711602 911 702.711602 911 701.226961"></polygon>
            <polygon id="plus" stroke="none" fill="#FFA800" fill-rule="evenodd" points="662.288398 736.226961 662.288398 734 663.773039 734 663.773039 736.226961 666 736.226961 666 737.711602 663.773039 737.711602 663.773039 740 662.288398 740 662.288398 737.711602 660 737.711602 660 736.226961"></polygon>
            <circle id="oval" stroke="none" fill="#A5D6D3" fill-rule="evenodd" cx="699.5" cy="579.5" r="1.5"></circle>
            <circle id="oval" stroke="none" fill="#CFC94E" fill-rule="evenodd" cx="712.5" cy="617.5" r="1.5"></circle>
            <circle id="oval" stroke="none" fill="#8CC8C8" fill-rule="evenodd" cx="692.5" cy="738.5" r="1.5"></circle>
            <circle id="oval" stroke="none" fill="#3EC08D" fill-rule="evenodd" cx="884.5" cy="657.5" r="1.5"></circle>
            <circle id="oval" stroke="none" fill="#66739F" fill-rule="evenodd" cx="918.5" cy="681.5" r="1.5"></circle>
            <circle id="oval" stroke="none" fill="#C48C47" fill-rule="evenodd" cx="903.5" cy="723.5" r="1.5"></circle>
            <circle id="oval" stroke="none" fill="#A24C65" fill-rule="evenodd" cx="760.5" cy="587.5" r="1.5"></circle>
            <circle id="oval" stroke="#66739F" stroke-width="2" fill="none" cx="745" cy="603" r="3"></circle>
            <circle id="oval" stroke="#EFB549" stroke-width="2" fill="none" cx="716" cy="597" r="3"></circle>
            <circle id="oval" stroke="#cb1c22" stroke-width="2" fill="none" cx="681" cy="751" r="3"></circle>
            <circle id="oval" stroke="#3CBC83" stroke-width="2" fill="none" cx="896" cy="680" r="3"></circle>
            <polygon id="diamond" stroke="#C46F82" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none" points="886 705 889 708 886 711 883 708"></polygon>
            <path d="M736,577 C737.65825,577 739,578.34175 739,580 C739,578.34175 740.34175,577 742,577 C740.34175,577 739,575.65825 739,574 C739,575.65825 737.65825,577 736,577 Z" id="bubble-rounded" stroke="#3CBC83" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" fill="none"></path>
        </svg>
        <h3 style="margin-bottom: 0px">Giỏ Hàng Quý Khách Hiện Đang Trống!</h3>
        <p>
            <a href="{{ url('/') }}" class="btn">&larr; Quay Trở Lại</a>
        </p>
    </div>
    @endif
    </div>
</div>
@endsection