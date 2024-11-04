@extends('layouts.front_layout.front_layout')
@section('content')
<?php
use App\Section;
use App\Product;
use App\Popup;
use App\Blog;
$sections = Section::sections();
$getPopup = Popup::getPopup();
$countPopup = Popup::countPopup();
?>
@if($countPopup != 0)
<div class="popup_background">
    <div id="popup">
            
        <!-- and here comes the image -->
        <a href="/{{ $getPopup['link'] }}"><img src="{{ url('images/popup_images/'.$getPopup['image']) }}" title="{{ $getPopup['alt'] }}" alt="{{ $getPopup['alt'] }}"></a>
            
            <!-- Now this is the button which closes the popup-->
        <div class="panel-footer">
            <i id="close" class="fas fa-times"></i>
        </div>
            
            <!-- and finally we close the POPUP FRAME-->
            <!-- everything on it will show up within the popup so you can add more things not just an image -->
    </div>
</div>
@endif
<div class="categories">    
    <div id="section-container" class="small-container">
        <div class="row">
            @foreach($sections as $section)
            @if(count($section['categories'])>0)
            <div id="section" class="col-3">
                <a id="category-nav" @if(count($section['categories'])>0) href="/{{ $section['url'] }}" @endif><?php $section_image_path = "images/section_images/".$section['section_image']; ?>
                    @if(!empty($section['section_image']) && file_exists($section_image_path))
                    <img loading="lazy" src="{{ asset('images/section_images/'.$section['section_image']) }}" alt="thể loại sản phẩm">
                    @endif<div class="image_overlay">
                    <div class="image_title" style="text-align: center;">{{ __($section['name']) }}</div>
                </div></a>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>
<!------sản phẩm nổi bật------->
<div class="small-container"> 
    <h2 class="title">
        {{ __('Sản Phẩm Nổi Bật') }}
    </h2>
    <div class="slider-nav-container" style="width: 100%; margin: 0 auto !important; position: relative;">
        @if($featuredItemsCount > 4)
        <i class="fas fa-chevron-left prev"></i>
        <i class="fas fa-chevron-right next"></i>
        @endif
        <div class="row">
            <div></div>
            <div class="flexleft-container">
                <p style="float: right"><span style="color: var(--MinhHung-Red); font-weight: bolder;">{{ $featuredItemsCount }}+</span> {{ __('Sản Phẩm Nổi Bật') }}!</p>
            </div>
        </div>
        <div class="row" @if($featuredItemsCount > 4) id="featuredCarousel" @endif>
            @foreach($featuredItemsChunk as $key => $featuredItem)
                @foreach($featuredItem as $item)
                <?php $discounted_price = Product::getDiscountedPrice($item['id']); ?>
                <div class="col-4">
                    <a href="{{ url('products/'.$item['id']) }}">
                        <?php $product_image_path = 'images/product_images/main_image/medium/'.$item['main_image']; ?>
                                @if(!empty($item['main_image'])&&file_exists($product_image_path))
                                <img  loading="lazy" src="{{ asset($product_image_path) }}" alt="sản phẩm mới">
                                @else
                                <img  loading="lazy" src="{{ url('images/product_images/main_image/medium/no-img.jpg') }}" alt="không có hình ảnh sản phẩm">
                                @endif
                    </a>
                     <div class="product-overlay navDetail"><a href="{{ url('products/'.$item['id']) }}">{{ __('xem chi tiết') }}</a></div>
                        <div class="product-overlay addCart"><a href="{{ url('products/'.$item['id']) }}">{{ __('thêm vào giỏ') }}</a></div>
                    <small class="brand-title">
                    <span>
                        <?php echo
                        $item['brand']['name']
                        ?>
                    </span>
                    </small>
                     <a href="{{ url('products/'.$item['id']) }}"><h4 title="{{ $item['product_name'] }}">{{ $item['product_name']}}</h4></a>
                     <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                        <p class="price">
                        @if(!empty($item['product_price']))
                            @if($item['section_id']!=1){{ __('từ') }} @endif
                            @if($discounted_price>0)
                                <del> 
                                    <?php 
                                    $num = $item['product_price'];
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
                                $num = $item['product_price'];
                                $format = number_format($num,0,",",".");
                                echo $format;
                                ?> ₫
                            @endif
                        @else 
                            <i>{{ __('giá liên hệ') }}</i>
                        @endif   
                        </p>
                </div>
                @endforeach
            @endforeach
        </div>
    </div>
    <!------sản phẩm mới nhất------->
    <h2 class="title">{{ __('Sản Phẩm Mới Nhất') }}</h2>
    <div class="row">
        <div class="flexleft-container">
            <p style="float: right !important;"><span style="color: var(--MinhHung-Red); font-weight: bolder;">8+</span> {{ __('Sản Phẩm Mới Nhất') }}!</p>
        </div>
        @foreach($newMaxproProducts as $newTool)
        <?php $discounted_price = Product::getDiscountedPrice($newTool['id']); ?>
        <div class="col-4">
            <a href="{{ url('products/'.$newTool['id']) }}">
                <?php $product_image_path = 'images/product_images/main_image/medium/'.$newTool['main_image']; ?>
                        @if(!empty($newTool['main_image'])&&file_exists($product_image_path))
                        <img loading="lazy" src="{{ asset($product_image_path) }}" alt="sản phẩm mới">
                        @else
                        <img loading="lazy" src="{{ url('images/product_images/main_image/medium/no-img.jpg') }}" alt="không có hình ảnh sản phẩm">
                        @endif
            </a>
             <div class="product-overlay navDetail"><a href="{{ url('products/'.$newTool['id']) }}">{{ __('xem chi tiết') }}</a></div>
                <div class="product-overlay addCart"><a href="{{ url('products/'.$newTool['id']) }}">{{ __('thêm vào giỏ') }}</a></div>
            <small class="brand-title">
                <span>
                    <?php echo
                    $newTool['brand']['name']
                    ?>
                </span>
            </small>
             <a href="{{ url('products/'.$newTool['id']) }}"><h4 title="{{ $newTool['product_name'] }}">{{ $newTool['product_name']}}</h4></a>
             <div class="rating">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
            </div>
            <p class="price">
                @if(!empty($newTool['product_price']))
                        @if($discounted_price>0)
                        <del> 
                            <?php 
                            $num = $newTool['product_price'];
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
                        $num = $newTool['product_price'];
                        $format = number_format($num,0,",",".");
                        echo $format;
                        ?> ₫
                    @endif
                @else 
                    <i>{{ __('giá liên hệ') }}</i>
                @endif   
            </p>
        </div>
        @endforeach
        @foreach($newHhoseProducts as $newHose)
        <div class="col-4">
            <a href="{{ url('products/'.$newHose['id']) }}">
                <?php $product_image_path = 'images/product_images/main_image/medium/'.$newHose['main_image']; ?>
                        @if(!empty($newHose['main_image'])&&file_exists($product_image_path))
                        <img loading="lazy" src="{{ asset($product_image_path) }}" alt="sản phẩm mới">
                        @else
                        <img loading="lazy" src="{{ url('images/product_images/main_image/medium/no-img.jpg') }}" alt="không có hình ảnh sản phẩm">
                        @endif
            </a>
             <div class="product-overlay navDetail"><a href="{{ url('products/'.$newHose['id']) }}">{{ __('xem chi tiết') }}</a></div>
                <div class="product-overlay addCart"><a href="{{ url('products/'.$newHose['id']) }}">{{ __('thêm vào giỏ') }}</a></div>
            <small class="brand-title">
                <span>
                    <?php echo
                    $newHose['brand']['name']
                    ?>
                </span>
            </small>
             <a href="{{ url('products/'.$newHose['id']) }}"><h4 title="{{ $newHose['product_name'] }}">{{ $newHose['product_name']}}</h4></a>
             <div class="rating">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
            </div>
            <p class="price">
                @if(!empty($newHose['product_price']))
                    @if($newHose['section_id']!=1)từ@endif <?php 
                    $num = $newHose['product_price'];
                    $format = number_format($num,0,",",".");
                    echo $format;
                    ?> ₫
                @else
                    <i>{{ __('giá liên hệ') }}</i>
                @endif   
            </p>
        </div>
        @endforeach
        @foreach($newShimgeProducts as $newPump)
        <?php $discounted_price = Product::getDiscountedPrice($newPump['id']); ?>
        <div class="col-4">
            <a href="{{ url('products/'.$newPump['id']) }}">
                <?php $product_image_path = 'images/product_images/main_image/medium/'.$newPump['main_image']; ?>
                        @if(!empty($newPump['main_image'])&&file_exists($product_image_path))
                        <img loading="lazy" src="{{ asset($product_image_path) }}" alt="sản phẩm mới">
                        @else
                        <img loading="lazy" src="{{ url('images/product_images/main_image/medium/no-img.jpg') }}" alt="không có hình ảnh sản phẩm">
                        @endif
            </a>
             <div class="product-overlay navDetail"><a href="{{ url('products/'.$newPump['id']) }}">{{ __('xem chi tiết') }}</a></div>
                <div class="product-overlay addCart"><a href="{{ url('products/'.$newPump['id']) }}">{{ __('thêm vào giỏ') }}</a></div>
            <small class="brand-title">
                <span>
                    <?php echo
                    $newPump['brand']['name']
                    ?>
                </span>
            </small>
             <a href="{{ url('products/'.$newPump['id']) }}"><h4 title="{{ $newPump['product_name'] }}">{{ $newPump['product_name']}}</h4></a>
             <div class="rating">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
            </div>
            <p class="price">
                @if(!empty($newPump['product_price']))
                        {{ __('từ') }} @if($discounted_price>0)
                        <del> 
                            <?php 
                            $num = $newPump['product_price'];
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
                        $num = $newPump['product_price'];
                        $format = number_format($num,0,",",".");
                        echo $format;
                        ?> ₫
                    @endif
                @else 
                    <i>{{ __('giá liên hệ') }}</i>
                @endif   
            </p>
        </div>
        @endforeach
    </div>
</div>
<!------sản phẩm độc quyền------->
@foreach($exclusiveProduct as $exclusive)
  @if($exclusive['section_id']==1)
  <style>
  .offer{
    background: radial-gradient(var(--MaxPro-Orange), var(--MaxPro-Orange), var(--MaxPro-Orange), var(--MaxPro-Orange-Hover));
    }
  </style>
  @endif
  @if($exclusive['section_id']==2)
  <style>
    .offer{
    background: radial-gradient(var(--Hhose-Yellow), var(--Hhose-Yellow), var(--Hhose-Yellow), var(--Hhose-Yellow-Hover));
    }
    .offer .small-container .row .col-2 p{
    color: var(--Solid-Black);
    }


    .offer .small-container .row .col-2 small{
    color: var(--Solid-Black);
    }
  </style>
  @endif
  @if($exclusive['section_id']==3)
  <style>
    .offer{
    background: radial-gradient(var(--Shimge-Blue), var(--Shimge-Blue), var(--Shimge-Blue), var(--Shimge-Blue-Hover));
    }
  </style>
  @endif
<div class="offer">
    <div class="small-container">
        <div class="row">
            <div class="col-2">
                <div class="offer-img">
                <?php $product_image_path = 'images/product_images/main_image/large/'.$exclusive['main_image']; ?>
                        @if(!empty($item['main_image'])&&file_exists($product_image_path))
                        <img loading="lazy" src="{{ asset($product_image_path) }}" alt="sản phẩm độc quyền">
                        @else
                        <img loading="lazy"src="{{ url('images/product_images/main_image/medium/no-img.jpg') }}" alt="không có hình ảnh sản phẩm">
                        @endif
                </div>
            </div>
            <div class="col-2"> 
                <p>
                    @if(Config::get('app.locale') == 'cn')
                        {{ __('Của Nhà Phân Phối Minh Hưng') }}
                        <span>
                        {{ __('Độc Quyền') }}! 
                        </span>    
                    @else 
                        <span>
                        {{ __('Độc Quyền') }} 
                        </span>
                        {{ __('Của Nhà Phân Phối Minh Hưng') }}!
                    @endif
                </p>
                <h1><p>{{ $exclusive['product_name']}}</p></h1>
                <small>
                    <?php echo $exclusive['product_description'] ?>
                </small>
                <br>
                <a href="{{ url('products/'.$exclusive['id']) }}" class="btn">Tìm Hiểu Thêm &#8594;</a>
            </div>
        </div>
    </div>
</div>
@endforeach
 <!------ tin tức - sự kiện ------->
<div class="stories">
    <div class="small-container">
        <h2 class="title">{{ __('Tin Tức') }}  - {{ __('Sự Kiện') }} </h2>
        <div class="row">
        @foreach($latestBlogs as $blog)
            <div class="col-3" onclick="window.location='{{ url('/') }}';">
                    <i class="fa fa-quote-left"></i>
                    <h4>{{ $blog['title'] }}</h4>
                    <p style="line-height: 25px;"><?php echo __($blog['content']) ?></p>
                    <div class="subdiv">
                        <img src="{{ url('images/front_images/logoMinhHung.png') }}" alt="tác giả bài biết">
                        <h4>{{ $blog['author'] }}</h4>
                    </div>
            </div>
        @endforeach
            <!-- <div class="col-3">
                <i class="fa fa-quote-left"></i>
                <h4>Happy Birthday chị Hoàng Thị Đông</h4>
                <p style="line-height: 25px;">Chúc mừng sinh nhật chị Hoàng Thị Đông (Nhân viên Phòng Tài Chính - Kế Toán).</p>
                <div class="subdiv">
                    <img src="{{ url('images/front_images/logoMinhHung.png') }}" alt="tác giả bài biết">
                    <h4>Người Minh Hưng</h4>
                </div>
            </div>
            <div class="col-3">
                <i class="fa fa-quote-left"></i>
                <h4>5 mẹo sửa đồ trong nhà đơn giản cho nam giới</h4>
                <p style="line-height: 25px;">Những mẹo đơn giản nhưng hữu ích dưới đây sẽ giúp các anh sửa sang lại đồ đạc trong nhà chuẩn bị cho dịp Tết Nguyên Đán sắp tới.</p>
                <div class="subdiv">
                    <img src="{{ url('images/front_images/logoMinhHung.png') }}" alt="tác giả bài biết">
                    <h4>Người Minh Hưng</h4>
                </div>
            </div> -->
        </div>
    </div>
</div> 
<!------Đối Tác------->
<div class="partners">
    <div class="small-container">
        <h2 class="title" id="affiliates-title">{{ __("Doanh Nghiệp Đối Tác") }}</h2>
        <div class="row">
            <div class="col-5">
                <a href="http://kelaibo.ck-163.com/" target="_blank"><img loading="lazy" src="{{ url('images/front_images/logoPartner1.png') }}" alt="đối tác MaxPro"></a>
            </div>
            <div class="col-5">
                <a href="http://shimge-pump.com/" target="_blank"><img loading="lazy" src="{{ url('images/front_images/logoPartner2.png') }}" alt="đối tác Shimge"></a>
            </div>
        </div>
    </div>
</div>
@endsection