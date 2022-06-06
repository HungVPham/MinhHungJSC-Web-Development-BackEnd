@extends('layouts.front_layout.front_layout')
@section('content')
<link href="https://fonts.googleapis.com/css?family=Kaushan+Script|Source+Sans+Pro" rel="stylesheet">
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
<style>

.wrapper-1{
  width:100%;
  height:100vh;
  display: flex;
  flex-direction: column;
}
.wrapper-2{
  padding :30px;
  text-align:center;
}
h1{
    font-family: 'Kaushan Script', cursive;
  font-size:4em;
  letter-spacing:3px;
  color: var(--MinhHung-Red) ;
  margin:0;
  margin-bottom:20px;
}
.wrapper-2 p{
  margin:0;
  font-size:1.3em;
}

@media (min-width:360px){
  h1{
    font-size:4.5em;
  }
  .go-home{
    margin-bottom:20px;
  }
}

@media (min-width:600px){
  .content{
  max-width:1000px;
  margin:0 auto;
}
  .wrapper-1{
  height: initial;
  max-width:620px;
  margin:0 auto;
  margin-top:50px;
}
}

.btn{
        border: 2px solid black !important;
        color: #00000030 !important;
        background: #ffffff !important;
    }
    .btn:hover{
        border-color: var(--MinhHung-Red) !important;
        color: #000000 !important;   
    }
</style>
<!--Cart Items Details-->
<div class="small-container cart-page">
    <div class="row listing head first cart">
        <h5><a href="{{ url('/') }}">Trang Chủ</a> / <a href="{{ url('/cart') }}">Giỏ Hàng</a> / Cám ơn quý khách!</h5>
    </div>
<div class=content>
    <div class="wrapper-1">
      <div class="wrapper-2">
        <h1>thank you !</h1>
        <p>Đơn hàng của quý khách đã được đặt thành công! </p>
        <p>Mã Đơn hàng: {{ Session::get('order_id') }} </p>
        @if(Auth::check())
        <p>Tổng trị giá: <?php 
            $grand_total = Session::get('grand_total');
            $format = number_format($grand_total,0,",",".");
             echo $format;
            ?> ₫ 
            </p>
        @else
            <p>Tổng trị giá: <?php 
                $grand_total = Session::get('total_price');
                $format = number_format($grand_total,0,",",".");
                 echo $format;
                ?> ₫ 
                </p>
        @endif
        <p>
            <a href="{{ url('/') }}" class="btn">&larr; Quay Trở Lại</a>
        </p>
      </div>
  </div>
  </div>

</div>


@endsection

<?php
Session::forget('grand_total'); 
Session::forget('total_price'); 
Session::forget('order_id'); 
Session::forget('couponAmount');
Session::forget('couponCode');
?>