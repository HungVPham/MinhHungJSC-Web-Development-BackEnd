    <div class="row listing body">
        @foreach($categoryProducts as $key => $product)
        <div class="col-4">
            <a href="">
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
             <div class="product-overlay navDetail"><a>xem chi tiết</a></div>
                <div class="product-overlay addCart"><a>thêm vào giỏ</a></div>
            <div class="list-item-container">
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
            <p class="list-product-description">{{ $product['product_description']}}</p>
            <div class="list-item-container controls">
                <div id="comparision-container">
                <label for="comparison-checkbox">So Sánh</label>
                <input id="comparison-checkbox" name="comparison-checkbox" type="checkbox">
                </div>
                <p class="navList-Detail"><a href="">Xem Chi Tiết</a></p>
                <p class="addList-Cart"><a href="">Thêm Vào Giỏ</a></p>
            </div>
        </div>
        @endforeach
    </div>