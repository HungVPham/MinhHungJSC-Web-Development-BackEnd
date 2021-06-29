@extends('layouts.front_layout.front_layout')
@section('content')
<?php
use App\Section;
$sections = Section::sections();
?>
<div class="categories">    
    <div id="section-container" class="small-container">
        <div class="row">
            @foreach($sections as $section)
            {{-- @if(count($section['categories'])>0) --}}
            <div id="section" class="col-3">
                <?php $section_image_path = "images/section_images/".$section['section_image']; ?>
                @if(!empty($section['section_image']) && file_exists($section_image_path))
                <img src="{{ asset('images/section_images/'.$section['section_image']) }}" alt="thể loại sản phẩm">
                @endif
                <a id="category-nav" @if(count($section['categories'])>0) href="products.html" @endif><div class="image_overlay image_overlay-blur">
                    <div class="image_title" style="text-align: center;">{{ $section['name'] }}</div>
                </div></a>
            </div>
            {{-- @endif --}}
            @endforeach
        </div>
    </div>
</div>
<!------sản phẩm nổi bật------->
<div class="small-container"> 
    <h2 class="title">Sản Phẩm Nổi Bật</h2>
    <div class="slider-nav-container" style="width: 100%; margin: 0 auto !important; position: relative;">
        <i class="fas fa-chevron-left prev"></i>
        <i class="fas fa-chevron-right next"></i>
        <p style="float: right;"><span style="color: var(--MinhHung-Red); font-weight: bolder;">{{ $featuredItemsCount  }}+</span> sản phẩm nổi bật !</p>
        <div class="row" id="featuredCarousel">
            @foreach($featuredItemsChunk as $key => $featuredItem)
                @foreach($featuredItem as $item)
                <div class="col-4">
                    <a href="#">
                        <?php $product_image_path = 'images/product_images/main_image/medium/'.$item['main_image']; ?>
                        @if(!empty($item['main_image'])&&file_exists($product_image_path))
                        <img src="{{ asset($product_image_path) }}" alt="sản phẩm nổi bật">
                        @else
                        <img src="{{ url('images/product_images/main_image/medium/no-img.jpg') }}" alt="không có hình ảnh sản phẩm">
                        @endif
                    </a>
                    <div class="product-overlay navDetail"><a>xem chi tiết</a></div>
                    <div class="product-overlay addCart"><a>thêm vào giỏ</a></div>
                    <a href="#"><h4>{{ $item['product_name'] }}</h4></a>
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        {{-- <i class="fa fa-star-o"></i> --}}
                    </div>
                    <p>
                        @if(!empty($item['product_price']))
                        ₫ <?php 
                        $num = $item['product_price'];
                        $format = number_format($num);
                        echo $format;
                        ?>
                        @else 
                        <i>giá liên hệ</i>
                        @endif   
                    </p>
                </div>
                @endforeach
            {{-- <div class="col-4">
                <a href=""><img src="{{ url('images/front_images/product/Shimge/máy-bơm-wsd/wsd55-70_shimge(indexPage)_thumbnail.jpg') }}" alt="sản phẩm nổi bật 2"></a>
                <div class="product-overlay navDetail"><a>xem chi tiết</a></div>
                <div class="product-overlay addCart"><a>thêm vào giỏ</a></div>
                <a href=""><h4>Máy Bơm WSD 55/70</h4></a>
                <div class="rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-half-alt"></i>
                    <i class="fa fa-star-o"></i>
                </div>
                <p>Giá Liên Hệ</p>
            </div>
            <div class="col-4">
                <a href=""><img src="{{ url('images/front_images/product/Shimge/máy-bơm-wsd/wsd55-50_shimge(indexPage)_thumbnail.jpg') }}" alt="sản phẩm nổi bật 3"></a>
                <div class="product-overlay navDetail"><a>xem chi tiết</a></div>
                <div class="product-overlay addCart"><a>thêm vào giỏ</a></div>
                <a href=""><h4>Máy Bơm WSD 55/50</h4></a>
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
                <a href=""><img src="{{ url('images/front_images/product/Shimge/máy-bơm-pwf/pw-f_shimge(indexPage)_thumbnail.jpg') }}" alt="sản phẩm nổi bật 4"></a>
                <div class="product-overlay navDetail"><a>xem chi tiết</a></div>
                <div class="product-overlay addCart"><a>thêm vào giỏ</a></div>
                <a href=""><h4>Máy Bơm Tăng Áp PW-F</h4></a>
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
                <a href="#"><img src="{{ url('images/front_images/product/MaxPro/máy-khoan-pin/mayKhoanpin_maxpro_thumbnail.jpg') }}" alt="sản phẩm nổi bật 1"></a>
                <div class="product-overlay navDetail"><a>xem chi tiết</a></div>
                <div class="product-overlay addCart"><a>thêm vào giỏ</a></div>
                <a href="#"><h4>Máy Khoan Pin 18V</h4></a>
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
                <a href=""><img src="{{ url('images/front_images/product/Shimge/máy-bơm-wsd/wsd55-70_shimge(indexPage)_thumbnail.jpg') }}" alt="sản phẩm nổi bật 2"></a>
                <div class="product-overlay navDetail"><a>xem chi tiết</a></div>
                <div class="product-overlay addCart"><a>thêm vào giỏ</a></div>
                <a href=""><h4>Máy Bơm WSD 55/70</h4></a>
                <div class="rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-half-alt"></i>
                    <i class="fa fa-star-o"></i>
                </div>
                <p>Giá Liên Hệ</p>
            </div>
            <div class="col-4">
                <a href=""><img src="{{ url('images/front_images/product/Shimge/máy-bơm-wsd/wsd55-50_shimge(indexPage)_thumbnail.jpg') }}" alt="sản phẩm nổi bật 3"></a>
                <div class="product-overlay navDetail"><a>xem chi tiết</a></div>
                <div class="product-overlay addCart"><a>thêm vào giỏ</a></div>
                <a href=""><h4>Máy Bơm WSD 55/50</h4></a>
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
                <a href=""><img src="{{ url('images/front_images/product/Shimge/máy-bơm-pwf/pw-f_shimge(indexPage)_thumbnail.jpg') }}" alt="sản phẩm nổi bật 4"></a>
                <div class="product-overlay navDetail"><a>xem chi tiết</a></div>
                <div class="product-overlay addCart"><a>thêm vào giỏ</a></div>
                <a href=""><h4>Máy Bơm Tăng Áp PW-F</h4></a>
                <div class="rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-o"></i>
                </div>
                <p>Giá Liên Hệ</p>
            </div> --}}
            @endforeach
        </div>
    </div>
    <!------sản phẩm mới nhất------->
    <h2 class="title">Sản Phẩm Mới Nhất</h2>
    <div class="row">
        <div class="col-4">
            <a href=""><img src="{{ url('images/front_images/product/Shimge/máy-bơm-pwf/pw-f_shimge(indexPage)_thumbnail.jpg') }}" alt="sản phẩm nổi bật 4"></a>
             <div class="product-overlay navDetail"><a>xem chi tiết</a></div>
                <div class="product-overlay addCart"><a>thêm vào giỏ</a></div>
             <a href=""><h4>Ống Thủy Lực SP Flex</h4></a>
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
            <a href=""><img src="{{ url('images/front_images/product/Shimge/máy-bơm-pwf/pw-f_shimge(indexPage)_thumbnail.jpg') }}" alt="sản phẩm nổi bật 4"></a>
             <div class="product-overlay navDetail"><a>xem chi tiết</a></div>
                <div class="product-overlay addCart"><a>thêm vào giỏ</a></div>
             <a href=""><h4>Máy Bào MPPL900/3DR1</h4></a>
            <div class="rating">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-alt"></i>
                <i class="fa fa-star-o"></i>
            </div>
            <p>Giá Liên Hệ</p>
        </div>
        <div class="col-4">
            <a href=""><img src="{{ url('images/front_images/product/Shimge/máy-bơm-pwf/pw-f_shimge(indexPage)_thumbnail.jpg') }}" alt="sản phẩm nổi bật 4"></a>
             <div class="product-overlay navDetail"><a>xem chi tiết</a></div>
                <div class="product-overlay addCart"><a>thêm vào giỏ</a></div>
             <a href=""><h4>Máy Cưa Bàn MPBTS254L</h4></a>
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
            <a href=""><img src="{{ url('images/front_images/product/Shimge/máy-bơm-pwf/pw-f_shimge(indexPage)_thumbnail.jpg') }}" alt="sản phẩm nổi bật 4"></a>
             <div class="product-overlay navDetail"><a>xem chi tiết</a></div>
                <div class="product-overlay addCart"><a>thêm vào giỏ</a></div>
             <a href=""><h4>Máy Đục Bê Tông MPDH1500</h4></a>
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
    <div class="row">
        <div class="col-4">
            <a href=""><img src="{{ url('images/front_images/product/Shimge/máy-bơm-pwf/pw-f_shimge(indexPage)_thumbnail.jpg') }}" alt="sản phẩm nổi bật 4"></a>
                <div class="product-overlay navDetail"><a>xem chi tiết</a></div>
                <div class="product-overlay addCart"><a>thêm vào giỏ</a></div>
                <a href=""><h4>Máy Khoan Búa MPRH1500/32V</h4></a>
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
            <a href=""><img src="{{ url('images/front_images/product/Shimge/máy-bơm-pwf/pw-f_shimge(indexPage)_thumbnail.jpg') }}" alt="sản phẩm nổi bật 4"></a>
                <div class="product-overlay navDetail"><a>xem chi tiết</a></div>
                <div class="product-overlay addCart"><a>thêm vào giỏ</a></div>
                <a href=""><h4>Máy Mài Góc Thân Dài MPAG951/125L</h4></a>
            <div class="rating">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-alt"></i>
                <i class="fa fa-star-o"></i>
            </div>
            <p>Giá Liên Hệ</p>
        </div>
        <div class="col-4">
            <a href=""><img src="{{ url('images/front_images/product/Shimge/máy-bơm-pwf/pw-f_shimge(indexPage)_thumbnail.jpg') }}" alt="sản phẩm nổi bật 4"></a>
                <div class="product-overlay navDetail"><a>xem chi tiết</a></div>
                <div class="product-overlay addCart"><a>thêm vào giỏ</a></div>
                <a href=""><h4>Máy Nén Khí MPEAC800/24</h4></a>
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
            <a href=""><img src="{{ url('images/front_images/product/Shimge/máy-bơm-pwf/pw-f_shimge(indexPage)_thumbnail.jpg') }}" alt="sản phẩm nổi bật 4"></a>
                <div class="product-overlay navDetail"><a>xem chi tiết</a></div>
                <div class="product-overlay addCart"><a>thêm vào giỏ</a></div>
                <a href=""><h4>Máy Phun Sơn  MPSG400/800V</h4></a>
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
<!------sản phẩm độc quyền------->
<div class="offer">
    <div class="small-container">
        <div class="row">
            <div class="col-2">
                <img src="{{ url('images/front_images/product/MaxPro/máy-khoan-động-lực/mayKhoandongLuc_maxpro.png') }}" class="offer-img" alt="sản phẩm độc quyền">
            </div>
            <div class="col-2"> 
                <p><span>Độc Quyền </span>Của Nhà Phân Phối Minh Hưng!</p>
                <h1>Máy Khoan Động Lực MPID1050VD</h1>
                <small>Máy khoan động lực MPID1050VD là dòng khoan động lực khoẻ nhất của MaxPro với công suất 1050W, độ rung thấp. Báng cầm vừa vặn và được thiết kế chống trượt, vừa không gây mỏi tay khi cầm lâu vừa giúp thao tác điều khiển dễ dàng, linh hoạt và an toàn hơn.</small>
                <br>
                <a href="" class="btn">Tìm Hiểu Thêm &#8594;</a>
            </div>
        </div>
    </div>
</div>
<!------ tin tức - sự kiện ------->
<div class="stories">
    <div class="small-container">
        <h2 class="title">Tin Tức - Sự Kiện</h2>
        <div class="row">
            <div class="col-3">
                <i class="fa fa-quote-left"></i>
                <h4>Hành Trình Về Phía Bắc Tổ Quốc!</h4>
                <p style="line-height: 25px; overflow-y: hidden;">Người Minh Hưng chúng tôi đã có 1 chuyến đi với rất nhiều kỉ niệm, sự trải nghiệm, nhìn nhận sự việc ở thế giới bên ngoài, xung quanh ta với nhiều tình yêu thương bằng ánh mắt trìu mến...</p>
                <div class="subdiv">
                    <img src="{{ url('images/front_images/logoMinhHung.png') }}" alt="tác giả bài biết">
                    <h4>Người Minh Hưng</h4>
                </div>
            </div>
            <div class="col-3">
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
            </div>
        </div>
    </div>
</div>
<!------Đối Tác------->
<div class="partners">
    <div class="small-container">
        <h2 class="title" id="affiliates-title">Doanh Nghiệp Đối Tác</h2>
        <div class="row">
            <div class="col-5">
                <a href="http://www.krebs-tools.com/?fbclid=IwAR1U8FZK8dU29apTKYhsYsIDSa2_cl83iOLouj6RsPj2TPFRorMMh0k2bEo" target="_blank"><img src="{{ url('images/front_images/logoPartner1.png') }}" alt="đối tác MaxPro"></a>
            </div>
            <div class="col-5">
                <a href="http://shimge-pump.com/" target="_blank"><img src="{{ url('images/front_images/logoPartner2.png') }}" alt="đối tác Shimge"></a>
            </div>
            <div class="col-5">
                <a href="http://anhdungplastic.com.vn/" target="_blank"><img src="{{ url('images/front_images/logoPartner3.png') }}" alt="đối tác Anh Dũng Plastic"></a>
            </div>
            <div class="col-5">
                <a href="https://hanviethai.vn/vi/" target="_blank"><img src="{{ url('images/front_images/logoPartner4.png') }}" alt="đối tác Hàn Việt Hải"></a>
            </div>
        </div>
    </div>
</div>
@endsection