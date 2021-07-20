@extends('layouts.front_layout.front_layout')
@section('content')
<div class="small-container single-product">
    <div class="row listing head first detail" style="margin-bottom: 0; margin-top: 80px; text-align: center">
        <h5><a href="{{ url('/') }}">Trang Chủ</a> / <a>Sản Phẩm</a> / <a href="{{ url('/'.$productDetails['category']['url']) }}">{{ $productDetails['category']['category_name'] }}</a> / <a>{{ $productDetails['product_name'] }}</a></h5>
    </div>
    <div class="row single-product">
        <div class="col-2 single-product">
                @if(isset($productDetails['main_image']))
                    <?php $product_image_path = 'images/product_images/main_image/large/'.$productDetails['main_image']; ?>
                @else
                    <?php $product_image_path = '' ?>
                @endif
                @if(!empty($productDetails['main_image'])&&file_exists($product_image_path))
                    <img src="{{ asset($product_image_path) }}" width="100%" id="ProductImg" alt="sản phẩm mới">
                @else
                    <img src="{{ url('images/product_images/main_image/large/no-img.jpg') }}" alt="không có hình ảnh sản phẩm">
                @endif
            <div class="small-img-row">
                <div class="small-img-col">
                @if(isset($productDetails['main_image']))
                    <?php $product_image_path = 'images/product_images/main_image/large/'.$productDetails['main_image']; ?>
                @else
                    <?php $product_image_path = '' ?>
                @endif
                @if(!empty($productDetails['main_image'])&&file_exists($product_image_path))
                    <img src="{{ asset($product_image_path) }}" width="100%" class="small-img" alt="sản phẩm mới">
                @else
                    <img src="{{ url('images/product_images/main_image/large/no-img.jpg') }}" alt="không có hình ảnh sản phẩm">
                @endif
                </div>
                @foreach($productDetails['images'] as $image)
                <div class="small-img-col">
                    <img src="{{ asset('images/product_images/main_image/large/'.$image['image']) }}" class="small-img" width="100%" alt="hình ảnh sản phẩm 2">
                </div>
                @endforeach
            </div>
        </div>
       
        <div class="col-2 single-product"> 
            <small class="brand-title detail"> 
                <span>
                    <?php echo
                    $productDetails['brand']['name']
                    ?>
                </span>
            </small>
            <h1 style="margin-top: 5px">{{ $productDetails['product_name'] }}</h1>
            
            {{-- price --}}
            @if($total_tools_stock > 0)
            <h4 class="getMaxproAttrPrice">
                <?php 
                $num = $productDetails['product_price'];
                $format = number_format($num,0,",",".");
                echo $format;
                ?> ₫
            </h4>
            @endif
            @if($total_hhose_stock > 0)
               <h4 class="getHhoseAttrPrice"> 
                    @if($productDetails['section_id']!=1)từ@endif <?php 
                    $num = $productDetails['product_price'];
                    $format = number_format($num,0,",",".");
                    echo $format;
                    ?> ₫
                </h4>
            @endif
            @if($total_pump_stock > 0)
                <h4 class="getShimgeAttrPrice">
                    @if($productDetails['section_id']!=1)từ@endif <?php 
                    $num = $productDetails['product_price'];
                    $format = number_format($num,0,",",".");
                    echo $format;
                    ?> ₫
                </h4>
            @endif
            @if($total_stock == 0)
            <i>(hết hàng)</i>
            @endif
            </h4>

            {{-- purchasing quantity --}}
            <p>Số Lượng Mua: <input type="number" value="1"></p>
            
            {{-- select sku dropdown --}}
            <p>Mã Sản Phẩm: 
            @if(!empty($productDetails['maxpro_attributes']))
            <select name="sku" id="getMaxproPrice" product-id="{{ $productDetails['id'] }}" class="select2">
                <option>chọn mã sản phẩm...</option>
                @foreach($productDetails['maxpro_attributes'] as $toolAttr)
                <option value="{{ $toolAttr['sku'] }}">{{ $toolAttr['sku'] }}</option>
                @endforeach
            </select>
            @endif
            @if(!empty($productDetails['hhose_attributes']))
            <select name="sku" id="getHhosePrice" product-id="{{ $productDetails['id'] }}" class="select2">
                <option>chọn mã sản phẩm...</option>
                @foreach($productDetails['hhose_attributes'] as $toolAttr)
                <option value="{{ $toolAttr['sku'] }}">{{ $toolAttr['sku'] }}</option>
                @endforeach
            </select>
            @endif
            @if(!empty($productDetails['shimge_attributes']))
            <select name="sku" id="getShimgePrice" product-id="{{ $productDetails['id'] }}" class="select2">
                <option>chọn mã sản phẩm...</option>
                @foreach($productDetails['shimge_attributes'] as $toolAttr)
                <option value="{{ $toolAttr['sku'] }}">{{ $toolAttr['sku'] }}</option>
                @endforeach
            </select>
            @endif

            {{-- add to cart or notify when restock btn --}}
            </p>
            @if($total_tools_stock > 0)
            <p><a style="margin-top: 5px" href="" class="btn">Thêm Vào Giỏ</a></p>
            @endif
            @if($total_hhose_stock > 0)
            <p><a style="margin-top: 5px" href="" class="btn">Thêm Vào Giỏ</a></p>
            @endif
            @if($total_pump_stock > 0)
            <p><a style="margin-top: 5px" href="" class="btn">Thêm Vào Giỏ</a></p>
            @endif
            @if($total_stock == 0)
            <p><a style="margin-top: 5px" href="" class="btn">Nhận thông báo khi có hàng!</a></p>
            @endif
        </div>
    </div>
</div>
<!------Title------->
<div class="small-container listing">
    <div class="row row-2">
        <div></div>
        <div class="flexleft-container">
            @if(!empty($productDetails['product_video']))
            <i title="hiện thị video" class="viewbtn fab fa-youtube" onclick="Btn(0); playVideo()"></i>
            <i title="hiện thị thông tin" class="viewbtn fas fa-info-circle Active" onclick="Btn(1); pauseVideo()"></i>
            @endif
        </div>
    </div>
</div>
<div class="small-container" style="margin-top: 20px">
    @if(!empty($productDetails['product_video']))
    <div class="viewsw row video">
        
        <iframe id="existing-iframe-example"
        height="560"
        src="https://www.youtube.com/embed/{{ $productDetails['product_video'] }}?enablejsapi=1"
        frameborder="0"
        ></iframe>
    </div>
    @endif
    <div class="viewsw row info Active">
        <div>
            <label for="product_description"><strong>Giới Thiệu Sản Phẩm:</strong></label>
            <br>
            <br>
            @if(!empty($productDetails['product_description']))
            <p name="product_description">
                <?php echo $productDetails['product_description'] ?>
            </p>
            @else
            <h5><i>chưa có thông tin.</i></h5>
            @endif
        </div>
        <div> 
            <label for="spec_feature"><strong>Tính Năng Nổi Bật:</strong></label>
            <br>
            <br>
            @if(!empty($productDetails['product_info']))
            <?php echo $productDetails['product_info'] ?>
            @else
            <h5><i>chưa có thông tin.</i></h5>
            @endif
        </div>
    </div> 
</div>
<!------Products------->
<div class="small-container listing">
    <div class="row">
        <div class="row row-2">
            <h2 style="margin-top: 50px; margin-bottom: -40px">Sản Phẩm Tương Tự</h2> 
            <div class="flexleft-container">
                <i title="hiện thị danh sách" class="mybtn fas fa-th-list" onclick="Button(0); listToggleListOff();listToggleBtnOff()"></i>
                <i title="hiện thị lưới" class="mybtn fas fa-th-large Active" onclick="Button(1); listToggleListOn();listToggleBtnOn()"></i>   
            </div>
        </div>
        <div class="flexleft-container" style="margin-top: 20px"><p id="products-nav"><a href="">Xem Thêm</a></p></div>
        <div class="col-4">
             <a id="singlePro-nav" href=""><img src="{{ asset('images/product/MaxPro/máy-khoan-điện/mayKhoandienVUF_maxpro_thumbnail.jpg') }}" alt="sản phẩm tương tự 1"></a>
             <a id="singlePro-nav" href=""><h4>Máy Khoan Điện MPED320VUF</h4></a>
            <div class="rating">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>
            </div>
            <p>Giá Liên Hệ</p>
        </div>
        <div class="col-4">
             <a id="singlePro-nav" href=""><img src="{{ asset('images/product/MaxPro/máy-khoan-động-lực/mayKhoandongLuc_maxpro.png') }}" alt="sản phẩm tương tự 2"></a>
             <a id="singlePro-nav" href=""><h4>Máy Khoan Động Lực MPID1050VD</h4></a>
            <div class="rating">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-alt"></i>
                <i class="fa fa-star-o"></i>
            </div>
            <p>Giá Liên Hệ</p>
        </div></a>
        <div class="col-4">
             <a id="singlePro-nav" href=""><img src="{{ asset('images/product/MaxPro/máy-khoan-búa/mayKhoanbua_maxpro_thumbnail.jpg') }}" alt="sản phẩm tương tự 3"></a>
             <a id="singlePro-nav" href=""><h4>Máy Khoan Búa MPRH1500</h4></a>
            <div class="rating">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-alt"></i>
            </div>
            <p>Giá Liên Hệ</p>
        </div>
        <div class="col-4">
             <a id="singlePro-nav" href=""><img src="{{ asset('images/product/MaxPro/máy-khoan-điện/mayKhoandien_maxpro_thumbnail.jpg') }}" alt="sản phẩm tương tự 4"></a>
             <a id="singlePro-nav" href=""><h4>Máy Khoan Điện MPED321V</h4></a>
            <div class="rating">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>
            </div>
            <p>Giá Liên Hệ</p>
        </div>
    </div>
</div>
@endsection