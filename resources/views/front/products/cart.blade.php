@extends('layouts.front_layout.front_layout')
@section('content')
<!--Cart Items Details-->
<div class="small-container cart-page">
    <div class="row listing head first cart">
        <h5><a href="{{ url('/') }}">Trang Chủ</a> / Giỏ Hàng</h5>
    </div>
    <h2>Giỏ Hàng</h2>
    <div id="AppendCartItems">
       @include('front.products.cart_items')
    </div>  
</div>
@endsection