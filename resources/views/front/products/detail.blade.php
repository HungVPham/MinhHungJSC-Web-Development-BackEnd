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
    form .btn{
        width: inherit;
    }
</style>
<div class="small-container single-product">
    <div class="row listing head first detail">
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
        @if(Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="color: #228B22; background-color: #ffffff; border: 1px solid #228B22">
            {{ Session::get('success_message') }}
            </div>
        @endif
        @if(Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="color: #cb1c22; background-color: #ffffff; border: 1px solid #cb1c22">
            {{ Session::get('error_message') }}
            </div>
        @endif
            <small class="brand-title detail"> 
                <span>
                    <?php echo
                    $productDetails['brand']['name']
                    ?>
                </span>
            </small>
            <h1 style="margin-top: 5px">{{ $productDetails['product_name'] }}</h1>
            <form action="
            @if($productDetails['section_id']==1)
            {{ url('add-to-cart-maxpro') }}
            @endif
            @if($productDetails['section_id']==2)
            {{ url('add-to-cart-hhose') }}
            @endif
            @if($productDetails['section_id']==3)
            {{ url('add-to-cart-shimge') }}
            @endif
            " method="post" enctype="multipart/form-data">@csrf
                <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}">
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
                <h4 style="color: #888"><i>hết hàng</i></h4>
                @endif
                {{-- purchasing quantity --}}
                @if($total_stock > 0)
                <p>
                    @if($productDetails['section_id']==1)
                    Số Lượng:&nbsp;&nbsp;<input autocomplete="off" class="getMaxMaxpro" name="quantity" required="" min="1" type="number" value="1">
                    @endif
                    @if($productDetails['section_id']==2)
                    Số Lượng:&nbsp;&nbsp;<input autocomplete="off" class="getMaxHhose" name="quantity" required="" min="1" type="number" value="1">
                    @endif
                    @if($productDetails['section_id']==3)
                    Số Lượng:&nbsp;&nbsp;<input autocomplete="off" class="getMaxShimge" name="quantity" required="" min="1" type="number" value="1">
                    @endif
                    <small style="color: var(--Solid-Black)">&nbsp;&nbsp;có
                        @if($productDetails['section_id']==1)
                         <span class="getMaxproStock" style="color: var(--MinhHung-Red); font-size: 1.2rem; font-weight: 700">{{ $total_tools_stock }}</span> sản phẩm có sẵn
                        @endif
                        @if($productDetails['section_id']==2)
                         <span class="getHhoseStock" style="color: var(--MinhHung-Red); font-size: 1.2rem; font-weight: 700">{{ $total_hhose_stock }}</span> sản phẩm có sẵn
                        @endif
                        @if($productDetails['section_id']==3)
                         <span class="getShimgeStock" style="color: var(--MinhHung-Red); font-size: 1.2rem; font-weight: 700">{{ $total_pump_stock }}</span> sản phẩm có sẵn
                        @endif
                    </small>
                </p>
                @endif
                {{-- select sku dropdown --}}
                <p>Mã Sản Phẩm:&nbsp;&nbsp; 
                @if(!empty($productDetails['maxpro_attributes']))
                <select autocomplete="off" name="sku" id="getMaxproPrice" required="" product-id="{{ $productDetails['id'] }}" class="select2">
                    <option value="">chọn mã sản phẩm...</option>
                    @foreach($productDetails['maxpro_attributes'] as $toolAttr)
                    <option value="{{ $toolAttr['sku'] }}">{{ $toolAttr['sku'] }}</option>
                    @endforeach
                </select>
                @endif
                @if(!empty($productDetails['hhose_attributes']))
                <select autocomplete="off" name="sku" id="getHhosePrice" required="" product-id="{{ $productDetails['id'] }}" class="select2">
                    <option value="">chọn mã sản phẩm...</option>
                    @foreach($productDetails['hhose_attributes'] as $toolAttr)
                    <option value="{{ $toolAttr['sku'] }}">{{ $toolAttr['sku'] }}</option>
                    @endforeach
                </select>
                @endif
                @if(!empty($productDetails['shimge_attributes']))
                <select autocomplete="off" name="sku" id="getShimgePrice" required="" product-id="{{ $productDetails['id'] }}" class="select2">
                    <option value="">chọn mã sản phẩm...</option>
                    @foreach($productDetails['shimge_attributes'] as $toolAttr)
                    <option value="{{ $toolAttr['sku'] }}">{{ $toolAttr['sku'] }}</option>
                    @endforeach
                </select>
                @endif
                </p>
                @if($total_tools_stock > 0)
                <p><button style="margin-top: 20px" type="submit" class="btn">Thêm Vào Giỏ</button></p>
                @endif
                @if($total_hhose_stock > 0)
                <p><button style="margin-top: 20px" type="submit" class="btn">Thêm Vào Giỏ</button></p>
                @endif
                @if($total_pump_stock > 0)
                <p><button style="margin-top: 20px" type="submit" class="btn">Thêm Vào Giỏ</button></p>
                @endif
            </form>
                {{-- add to cart or notify when restock btn --}}
                @if($total_stock == 0)
                <p><button disabled style="margin-top: 20px" class="btn">Nhận thông báo khi có hàng!</button></p>
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
            @if(empty($productDetails['product_video']))
            <i title="hiện thị thông tin" class="viewbtn fas fa-info-circle Active"></i>
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
    <div class="viewsw row info Active" style="border: 3px solid black">
        <div>
            <label for="product_description"><strong>Giới Thiệu Sản Phẩm:</strong></label>
            @if(!empty($productDetails['product_description']))
            <p name="product_description">
                <?php echo $productDetails['product_description'] ?>
            </p>
            @else
            <h5><i>chưa có thông tin.</i></h5>
            @endif
        </div>
        <div class="info-containter">
            <div>
                <label for="spec_feature"><strong>Tính Năng:</strong></label>
                @if(!empty($productDetails['product_info']))
                <?php echo $productDetails['product_info'] ?>
                @else
                <h5><i>chưa có thông tin.</i></h5>
                @endif
            </div> 
            @if($productDetails['section_id']==1)    
            <table>
                <tr>
                  <th><strong style="font-size: 1.5rem">Thông Số Kỹ Thuật</strong></th>
                  <th></th>
                </tr>
                <tr>
                  <td>Nguồn Điện:</td>
                  <td><span class="getMaxproVoltage"></span> <strong>[V]</strong></td>
                </tr>
                <tr>
                  <td>Công Suất:</td>
                  <td><span class="getMaxproPower"></span> <strong>[W]</strong></td>
                </tr>
              </table>
            @endif 
            @if($productDetails['section_id']==2)    
            <table>
                <tr>
                  <th><strong style="font-size: 1.5rem">Thông Số Kỹ Thuật</strong></th>
                  <th></th>
                </tr>
                <tr>
                  <td>Đường Kính:</td>
                  <td><span class="getHhoseDiameter"></span> <strong>[in.]</strong></td>
                </tr>
                <tr>
                  <td>Độ dài/1 Cuộn:</td>
                  <td><span class="getHhoseLength"></span> <strong>[m]</strong></td>
                </tr>
                <tr>
                  <td>In Nổi:</td>
                  <td><span class="getHhoseEmbossed">không / có</span></td>
                </tr>
                <tr>
                   <td>Da trơn:</td>
                   <td><span class="getHhoseSmooth">không / có</span></td>
                </tr>
              </table>
            @endif
            @if($productDetails['section_id']==3)    
            <table>
                <tr>
                  <th><strong style="font-size: 1.5rem">Thông Số Kỹ Thuật</strong></th>
                  <th></th>
                </tr>
                <tr>
                  <td>Nguồn Điện:</td>
                  <td><span class="getShimgeVoltage"></span> <strong>[V]</strong></td>
                </tr>
                <tr>
                  <td>Công Suất:</td>
                  <td><span class="getShimgePower"></span> <strong>[W]</strong></td>
                </tr>
                <tr>
                  <td>Lưu Lượng:</td>
                  <td><span class="getShimgeMaxflow"></span> <strong>[m³/h]</strong></td>
                </tr>
                <tr>
                  <td>Đẩy Cao:</td>
                  <td><span class="getShimgeVertical"></span> <strong>[m]</strong></td>
                </tr>
                <tr>
                  <td>Họng Hút:</td>
                  <td><span class="getShimgeIndiameter"></span> <strong>[mm]</strong></td>
                </tr>
                <tr>
                  <td>Họng Xả:</td>
                  <td><span class="getShimgeOutdiameter"></span> <strong>[mm]</strong></td>
                </tr>
              </table>
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
        <div class="flexleft-container" style="margin-top: 20px"><p id="products-nav"><a href="{{ url('/'.$productDetails['category']['url']) }}">Xem Thêm</a></p></div>
        <div class="row listing body">
            @foreach($relatedProducts as $key => $product)
            <div class="col-4">
                <a href="{{ url('sản-phẩm/'.$product['id']) }}">
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
                 <div class="product-overlay navDetail"><a  href="{{ url('sản-phẩm/'.$product['id']) }}">xem chi tiết</a></div>
                    <div class="product-overlay addCart"><a>thêm vào giỏ</a></div>
                <div class="list-item-container">
                <small class="brand-title"> 
                    <span>
                        <?php echo
                        $product['brand']['name']
                        ?>
                    </span>
                </small>
                 <a href="{{ url('sản-phẩm/'.$product['id']) }}"><h4 title="{{ $product['product_name'] }}">{{ $product['product_name']}}</h4></a>
                 <div class="rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                </div>
                <p class="price">
                    @if(!empty($product['product_price']))
                        @if($product['section_id']!=1)từ@endif <?php 
                        $num = $product['product_price'];
                        $format = number_format($num,0,",",".");
                        echo $format;
                        ?> ₫
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
                    <p class="navList-Detail"><a href="{{ url('sản-phẩm/'.$product['id']) }}">Xem Chi Tiết</a></p>
                    <p class="addList-Cart"><a>Thêm Vào Giỏ</a></p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="page-btn">
        <a href="" class="btn compare">So Sánh Đã Chọn [0]</a>
    </div>
</div>
@endsection