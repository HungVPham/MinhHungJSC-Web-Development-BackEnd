    <?php use App\Product; ?>
    <div class="row listing body">
        @foreach($categoryProducts as $key => $product)
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
                <p class="navList-Detail"><a href="{{ url('sản-phẩm/'.$product['id']) }}">Xem Chi Tiết</a></p>
                <p class="addList-Cart"><a>Thêm Vào Giỏ</a></p>
            </div>
        </div>
        @endforeach
    </div>