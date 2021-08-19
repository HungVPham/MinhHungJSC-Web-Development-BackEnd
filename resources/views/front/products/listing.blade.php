<?php use App\Product; ?>
@extends('layouts.front_layout.front_layout')
@section('content')
<style>
    #comparision-container input[type="checkbox"]{
      appearance: none;
      -webkit-appearance: none;
      height: 18px;
      width: 18px;
      background-color: #d5d5d5;
      outline: none;
      cursor: pointer;
      border: 1px solid #333;
      align-items: center;
      justify-content: center;
      display: flex;
      float: right;
      margin-top: 7px;
    }
    #comparision-container input[type="checkbox"]:after{
      font-family: "Font Awesome 5 Free";
      font-weight: 900;
      content: "\f00c";
      font-size: 13px;
      color: #ffffff;
      display: none;

    }
    #comparision-container input[type="checkbox"]:hover{
      background-color: #a5a5a5;
    }
    #comparision-container input[type="checkbox"]:checked{
      appearance: none;
      -webkit-appearance: none;
      background-color: var(--Positive-Green);
      height: 18px;
      width: 18px;
      align-items: center;
      justify-content: center;
      display: flex;
    }
    #comparision-container input[type="checkbox"]:checked::after{
      display: block;
    }
    .page-link{
        border: none;
    }
    
    .page-item{
        font-size: 1.2rem;
        font-weight: 700;
        margin-left: 15px;
    }
    .page-item .page-link{
        color: var(--MinhHung-Red);
    }
    .page-item.active .page-link {
        background-color: var(--MinhHung-Red);
        color: var(--Solid-White);
    }
    .page-item:last-child .page-link, .page-item:first-child .page-link{
        font-weight: 900;
    }
    
</style>
<div class="listing-head">
    <div class="row listing head first">
        <h5><a href="{{ url('/') }}">Trang Chủ</a> / <a 
            @if(!empty($categoryDetails['catDetails']['parent_id']))
            style="color: #222" 
            @elseif(empty($categoryDetails['catDetails']['parent_id']))
            style="color: #666" 
            @endif
        href="{{ url('/'.$categoryDetails['catDetails']['section']['url']) }}">{{ $categoryDetails['catDetails']['section']['name'] }}</a> / <?php echo $categoryDetails['breadcrumbs'] ?></h5>
    </div>
    <div class="listing-title-and-count">
        <div class="row listing head">
        <h2>{{ $categoryDetails['catDetails']['category_name'] }}</h2>
        </div>
        <div class="row listing head">
        <p><span style="color: var(--MinhHung-Red); font-weight: bolder;">{{ $countCategoryProducts }}+</span> sản phẩm có sẵn!</p>
        </div>
    </div>
    @if(!empty($categoryDetails['catDetails']['category_description']))
    <hr>
    <div class="row listing head">
        <p class="category_description">
            <?php echo
            $categoryDetails['catDetails']['category_description']
            ?>
        </p>
    </div>
    @endif
    <hr>
</div>
<div class="small-container listing">
    @if($countCategoryProducts>0)
        <form class="sorting-dropdown">
            <label for="sortProducts">Sắp xếp theo:</label>
            <select name="sortProducts" id="sortProducts" class="select2-no-search">
                <option value="">chọn bộ lọc...</option>
                <option value="product_latest" @if(isset($_GET['sortProducts']) && $_GET['sortProducts']=="product_latest") selected @endif>Mới &rarr; Cũ</option>
                <option value="product_name_a_z" @if(isset($_GET['sortProducts']) && $_GET['sortProducts']=="product_name_a_z") selected @endif>Tên A &rarr; Z</option>
                <option value="product_name_z_a" @if(isset($_GET['sortProducts']) && $_GET['sortProducts']=="product_name_z_a") selected @endif>Tên Z &rarr; A</option>
                <option value="price_lowest" @if(isset($_GET['sortProducts']) && $_GET['sortProducts']=="price_lowest") selected @endif>Giá: thấp &rarr; cao</option>
                <option  value="price_highest" @if(isset($_GET['sortProducts']) && $_GET['sortProducts']=="price_highest") selected @endif>Giá: cao &rarr; thấp</option>
            </select>
            <i title="hiện thị danh sách" class="mybtn fas fa-th-list" onclick="Button(0); listToggleListOff();listToggleBtnOff()"></i>
            <i title="hiện thị lưới" class="mybtn fas fa-th-large Active" onclick="Button(1); listToggleListOn();listToggleBtnOn()"></i>
        </form>
        <div class="row listing body">
            @foreach($categoryProducts as $key => $product)
            <div class="col-4">
                <a href="{{ url('products/'.$product['id']) }}">
                    @if(isset($product['main_image']))
                        <?php $product_image_path = 'images/product_images/main_image/medium/'.$product['main_image']; ?>
                    @else
                        <?php $product_image_path = '' ?>
                    @endif
                        @if(!empty($product['main_image'])&&file_exists($product_image_path))
                        <img src="{{ asset($product_image_path) }}" alt="sản phẩm mới">
                        @else
                        <img src="{{ url('images/product_images/main_image/medium/no-img.jpg') }}" alt="không có hình ảnh sản phẩm">
                    @endif
                </a>
                <div class="product-overlay navDetail"><a  href="{{ url('products/'.$product['id']) }}">xem chi tiết</a></div>
                    <div class="product-overlay addCart"><a href="{{ url('products/'.$product['id']) }}">thêm vào giỏ</a></div>
                <div class="list-item-container">
                <small class="brand-title"> 
                    <span>
                        <?php echo
                        $product['brand']['name']
                        ?>
                    </span>
                </small>
                <a href="{{ url('products/'.$product['id']) }}"><h4 title="{{ $product['product_name'] }}">{{ $product['product_name']}}</h4></a>
                <div class="rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                </div>
                <?php $discounted_price = Product::getDiscountedPrice($product['id']); ?>
                @if($product['section_id']==3)
                <style>
                .row.listing.body.list .col-4 .list-item-container .price strong{
                    display: block;
                }
                </style>
                @endif
                <p class="price">
                    @if(!empty($product['product_price']))
                        @if($product['section_id']!=1)từ@endif 
                            @if($discounted_price>0)
                                <del> 
                                    <?php 
                                    $num = $product['product_price'];
                                    $format = number_format($num,0,",",".");
                                    echo $format;
                                    ?> ₫
                                </del>
                                <strong style="color: var(--MinhHung-Red);">&nbsp;
                                    <?php 
                                    $num = $discounted_price;
                                    $format = number_format($num,0,",",".");
                                    echo $format;
                                ?> ₫
                                </strong>
                            @else
                                <?php 
                                $num = $product['product_price'];
                                $format = number_format($num,0,",",".");
                                echo $format;
                                ?> ₫
                            @endif
                    @else 
                        <i>giá liên hệ</i>
                    @endif   
                </p>
                </div>
                <div class="list-product-description">
                    @if(!empty($product['product_description']))
                    <?php echo $product['product_description'] ?>
                    @else
                    <h5><i>chưa có thông tin.</i></h5>
                    @endif
                </div>
                <div class="list-item-container controls">
                    <div id="comparision-container">
                    <label for="comparison-checkbox">So Sánh</label>
                    <input id="comparison-checkbox" name="comparison-checkbox" type="checkbox">
                    </div>
                    <p class="navList-Detail"><a href="{{ url('products/'.$product['id']) }}">Xem Chi Tiết</a></p>
                    <p class="addList-Cart"><a href="{{ url('products/'.$product['id']) }}">Thêm Vào Giỏ</a></p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="page-btn">
            <a href="" class="btn compare">So Sánh Đã Chọn [0]</a>
            @if(isset($_GET['sortProducts']) && !empty($_GET['sortProducts']))
            {{ $categoryProducts->appends(['sortProducts' => $_GET['sortProducts']])->links() }}
            @else
            {{ $categoryProducts->links() }}
            @endif
        </div>
        @else
        <p style="text-align: center; margin-bottom: 40px;">chưa có sản phẩm nào, vui lòng kiểm tra lại sau.</p>
        @endif
</div>
@endsection