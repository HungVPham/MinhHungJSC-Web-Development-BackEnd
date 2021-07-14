@extends('layouts.front_layout.front_layout')
@section('content')
<div class="listing-head">
    <div class="row listing head first">
        <h5><a href="/">Trang Chủ</a> / <a>{{ $categoryDetails['catDetails']['category_name'] }}</a></h5>
    </div>
    <div class="listing-title-and-count">
        <div class="row listing head">
        <h2>{{ $categoryDetails['catDetails']['category_name'] }}</h2>
        </div>
        <div class="row listing head">
        <p><span style="color: var(--MinhHung-Red); font-weight: bolder;">{{ $productCount }}+</span> sản phẩm có sẵn!</p>
        </div>
    </div>
    @if(!empty($categoryDetails['catDetails']['category_description']))
    <hr>
    <div class="row listing head">
        <p class="category_description">{{ $categoryDetails['catDetails']['category_description'] }}</p>
    </div>
    @endif
    <hr>
</div>
<div class="small-container">
    <label for="select">Sắp xếp theo:</label>
    <select>
        <option>Tên sản phẩm A - Z</option>
        <option>Tên sản phẩm Z - A</option>
        <option>Giá: thấp đến cao</option>
        <option>Giá: cao đến thấp</option>
    </select>
    <div class="row listing">
        @foreach($categoryProducts as $key => $product)
        <div class="col-4">
            <a href="">
                <?php $product_image_path = 'images/product_images/main_image/medium/'.$product['main_image']; ?>
                        @if(!empty($product['main_image'])&&file_exists($product_image_path))
                        <img src="{{ asset($product_image_path) }}" alt="sản phẩm mới">
                        @else
                        <img src="{{ url('images/product_images/main_image/medium/no-img.jpg') }}" alt="không có hình ảnh sản phẩm">
                        @endif
            </a>
             <div class="product-overlay navDetail"><a>xem chi tiết</a></div>
                <div class="product-overlay addCart"><a>thêm vào giỏ</a></div>
            <small class="brand-title"> <span
                @if($product['brand_id']==1) style="color: var(--MaxPro-Orange);" @endif
                @if($product['brand_id']==2) style="color: var(--Hhose-Yellow);" @endif
                @if($product['brand_id']==3) style="color: var(--Hammer-Turquoise);" @endif
                @if($product['brand_id']==4) style="color: var(--Shimge-Blue);" @endif
                >{{ $product['brand']['name'] }}</span></small>
             <a href=""><h4 title="{{ $product['product_name'] }}">{{ $product['product_name']}}</h4></a>
             <div class="rating">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
            </div>
                <p class="price">
                    @if(!empty($product['product_price']))
                        @if($product['section_id']!=1)từ@endif ₫<?php 
                        $num = $product['product_price'];
                        $format = number_format($num);
                        echo $format;
                        ?>
                        @else 
                        <i>giá liên hệ</i>
                    @endif   
                </p>
        </div>
        @endforeach
    </div>
    <div class="page-btn">
        <span>1</span>
        <span>2</span>
        <span>3</span>
        <span>4</span>
        <span>5</span>
        <span>6</span>
        <span>&#8594;</span>
    </div>
</div>
@endsection