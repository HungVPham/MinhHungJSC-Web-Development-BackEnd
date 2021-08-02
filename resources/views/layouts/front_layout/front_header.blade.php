<?php
use App\Section;
use App\Cart;
use App\AboutPage;
use App\CataloguePage;
$AboutDetails = AboutPage::aboutPageDetails();
$CatalogueDetails = CataloguePage::cataloguePageDetails();
$sections = Section::sections();
$countCartItems = Cart::countCartItems();
?>
<div class="header">
	<div class="navbar-wrapper">
		<div class="navbar-logo"><a href="{{ url('/') }}"><img src="{{ url('images/front_images/logoMinhHung.png') }}"></a></div>
		<input type="radio" name="slide" id="menu-btn">
		<input type="radio" name="slide" id="cancel-btn">
		<ul class="nav-links">
			<label id="close-nav" for="cancel-btn"><i class="fas fa-times"></i></label>
			<li id="prime-navlinks">
				<a class="desktop-item" href="{{ url('/') }}" style="display: flex; align-items: center;">Trang Chủ</a>
				<label class="mobile-item"><a href="{{ url('/') }}">Trang Chủ</a></label>
			</li>
			<li id="prime-navlinks">
				<div class="drop-nav"><a class="desktop-item" style="cursor: default;">Giới Thiệu</a><span id="expand-indicator">&nbsp;&#9660;</span></div>
				<input type="checkbox" id="showDrop">
				<label for="showDrop" class="mobile-item">Giới Thiệu<span id="expand-indicator-mobile">&nbsp;&#9660;</span></label>
				<ul class="drop-menu">
					@foreach($AboutDetails as $NavLinks)
					<li><a href="{{ url('gioi-thieu/'.$NavLinks['url'])}}">{{ $NavLinks['title'] }}</a></li>
					@endforeach
				</ul>
			</li>
			<li id="prime-navlinks">
				<div class="drop-nav"><a style="cursor: default;" class="desktop-item">Sản Phẩm</a><span id="expand-indicator">&nbsp;&#9660;</span></div>
				<input type="checkbox" id="showMega">
				<label for="showMega" class="mobile-item">Sản Phẩm<span id="expand-indicator-mobile">&nbsp;&#9660;</span></label>
				<div class="mega-box">
					<div class="megabox-content">
						@foreach($sections as $section)
						@if(count($section['categories'])>0)
						<div class="megabox-row">
							<header><a href="/{{ $section['url'] }}">{{ $section['name'] }}</a></header>
							<ul class="mega-links">
								@foreach($section['categories'] as $key => $category)
								<li id="megadrop-container">
									<div style="display: flex; align-items: center;"><a @if(count($category['subcategories'])>0) class="desktop-item" id="first-row" @else @endif href="/{{ $category['url'] }}">{{ $category['category_name'] }}</a>@if(count($category['subcategories'])>0)<span id="expand-indicator">&nbsp;&#9660;</span>@else @endif</div>
									<input type="checkbox" id="showMegaDrop-{{ $key+1 }}">
									@if(count($category['subcategories'])>0) <div style="display: flex; align-items: center;"><label for="showMegaDrop-{{ $key+1 }}" class="mobile-item megadrop">{{ $category['category_name'] }}</label><span id="expand-indicator-megadrop">&nbsp;&#9660;</span></div> @endif
									<ul class="drop-menu-megabox">
										@foreach($category['subcategories'] as $subcategory)
										<li><a style="color: #000000" href="/{{ $subcategory['url'] }}">{{ $subcategory['category_name'] }}</a></li>
										@endforeach
									</ul>
								</li>
								@endforeach
							</ul>
						</div>
						@endif
						@endforeach
						<div class="megabox-row">
							<header><a>Catalogue Sản Phẩm</a></header>
							<ul class="mega-links" id="catalogue-col">
								@foreach($CatalogueDetails as $catalogue)
								<li><a href="{{ url('catalogue-san-pham/'.$catalogue['url']) }}">{{ $catalogue['title'] }}</a></li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</li>
			{{-- <li id="prime-navlinks">
				<div class="drop-nav"><a class="desktop-item" href="#">Tin Tức - Sự Kiện</a><span id="expand-indicator">&nbsp;&#9660;</span></div>
				<input type="checkbox" id="showDrop2">
				<label for="showDrop2" class="mobile-item">Tin Tức - Sự Kiện<span id="expand-indicator-mobile">&nbsp;&#9660;</span></label>
				<ul class="drop-menu">
					<li><a href="">Tin Nội Bộ</a></li>
					<li><a href="">Tin Thị Trường</a></li>
					<li><a href="">Tin Khuyến Mãi</a></li>
				</ul>
			</li>
			<li id="prime-navlinks">
				<a class="desktop-item" style="display: flex; align-items: center;" href="#">Tuyển Dụng</a>
				<label for="showDrop2" class="mobile-item">Tuyển Dụng</label>
			</li> --}}
			<li id="prime-navlinks">
				<a class="desktop-item" style="display: flex; align-items: center;" href="#">Liện Hệ</a>
				<label for="showDrop2" class="mobile-item">Liện Hệ</label>
			</li>
		</ul>
		<div class="user-cart-container">
			<div class="navbar-cart" cartCount="{{ $countCartItems }}">
				<a href="{{ url('/gio-hang')}}"><img src="{{ url('images/front_images/cart.png') }}"></a>
			</div>
			<div class="action">
				<div class="profile" onclick="menuToggle();">
				<img src="{{ url('images/front_images/account.png') }}">
				</div>
				<div class="menu">
					{{-- <h3>Phạm Việt Hưng<br><span>Thành Viên</span></h3> --}}
					<h3>Đăng Nhập<br><span>Tài Khoản</span></h3>
					<ul>
						<li>
							<div class="search">
								<div class="icon"></div>
								<div class="input">
									<input type="text" placeholder="tìm kiếm..." id="mySearch">
								</div>
								<span class="clear" onclick="document.getElementById('mySearch').value = ''"></span>
							</div>
						</li>
						{{-- <li><img src="{{ url('images/front_images/account_setting.png') }}" alt=""><a href="">Cài Đặt Tài Khoản</a></li>
						<li><img src="{{ url('images/front_images/help.png') }}" alt=""><a href="">Trợ Giúp</a></li>
						<li><img src="{{ url('images/front_images/logout.png') }}" alt=""><a href="">Đăng Xuất</a></li> --}}
						<li><img src="{{ url('images/front_images/login.png') }}" alt=""><a href="">Đăng Nhập</a></li>
					</ul>
				</div>
			</div>
			<label id="open-nav" for="menu-btn"><i class="fas fa-bars"></i></label>
		</div>
	</div>
</div> 
@if(isset($page_name) && $page_name=="index")
	<div class="container mobile">
		<div class="row">
			<div class="col-2 index">
				<h3 id="company-subtitle">Công Ty Cổ Phần Đầu Tư Và Phát Triển</h3>
				<h1 id="company-title">Minh Hưng</h1>
				@foreach($bannerResponsive as $key => $main)
				<div>
				@if(empty($main['bRed_3']))
				<style>
					.col-2.index div p{
						font-size: 30px;
						font-family: 'Style Script', cursive;
					}
					.overlay-btn{
						margin-top: -20px;
					}
					
				</style>
				@elseif(!empty($main['bRed_3']))
				<style>
					.col-2.index div p{
						font-size: 25px;
						font-family: 'Style Script', cursive;
					}
					.overlay-btn{
						margin-top: 0px;
					}
				</style>
				@endif
				<p><span style="color: #cb1c22; font-weight: bolder;">{{ $main['bRed_1']}}</span> {{ $main['nBlack_1']}} <span style="color: #cb1c22; font-weight: bolder;">{{ $main['bRed_2']}}</span>
				<br>
				<span style="color: #cb1c22; font-weight: bolder;">{{ $main['bRed_3']}}</span> {{ $main['nBlack_2']}} <span style="color: #cb1c22; font-weight: bolder;">{{ $main['bRed_4']}}</span></p>  
				</div>
				@if(!empty($main['link']))
				<div>
				<a href="https://www.{{ $main['link'] }}" class="btn">{{ $main['title'] }} &#8594;</a>
				</div>
				@endif
				@endforeach
			</div>
		</div>
	</div>
	@endif
<?php 
use App\Banner;
$getBanners = Banner::getBanners();
$getMainBanner = Banner::getMainBanner();
$getSubBanners = Banner::getSubBanners();
?> 
@if(isset($page_name) && $page_name=="index")
	<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" style="display: flex; border-top: black 2px solid">
		<div class="carousel-indicators">
			@foreach($getBanners as $key => $count)
			<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $key }}" @if($key==0) class="active" aria-current="true" @endif aria-label="Slide {{ $key }}"></button>
			@endforeach
		</div>
		<div class="carousel-inner">
			@foreach($getMainBanner as $key => $main)
			<div class="carousel-item @if($key==0) active @endif" data-bs-interval="15000">
				<div class="overlay-image""><img src="{{ asset('images/banner_images/'.$main['image']) }}" alt="{{ $main['alt'] }}"></div>
				<div class="index-carousel-container">
					<div class="overlay-credo">
					@if(empty($main['bRed_3']))
					<style>
						.overlay-credo p{
							font-size: 3.2rem;
						}
						.overlay-btn{
							margin-top: -20px;
						}
						.typewriter p {
							border-right: .10em solid var(--MinhHung-Red); /* The typwriter cursor */
						}

						@media only screen and (max-width: 1435px) {
							.overlay-credo p{
								font-size: unset;
							}
						}
					</style>
					@elseif(!empty($main['bRed_3']))
					<style>
						.overlay-credo p{
							font-size: 3.2rem;
						}
						.overlay-btn{
							margin-top: 0px;
						}
						@media only screen and (max-width: 1435px) {
							.overlay-credo p{
								font-size: unset;
							}
						}
					</style>
					@endif
					<div class="typewriter">
						<p><span style="color: #cb1c22; font-weight: bolder;">{{ $main['bRed_1']}}</span> {{ $main['nBlack_1']}} <span style="color: #cb1c22; font-weight: bolder;">{{ $main['bRed_2']}}</span>
							<br>
						<span style="color: #cb1c22; font-weight: bolder;">{{ $main['bRed_3']}}</span> {{ $main['nBlack_2']}} <span style="color: #cb1c22; font-weight: bolder;">{{ $main['bRed_4']}}</span></p>
					</div>
					</div>
					@if(!empty($main['link']))
					<div class="overlay-btn">
					<a href="https://www.{{ $main['link'] }}" class="btn">{{ $main['title'] }} &#8594;</a>
					</div>
					@endif
				</div>
			</div>
			@endforeach
			@foreach($getSubBanners as $key => $sub)
			<div class="carousel-item">
				<div class="overlay-image""><a title="{{ $sub['title'] }}" @if(!empty($sub['link'])) href="https://www.{{ $sub['link'] }}" @endif><img src="{{ asset('images/banner_images/'.$sub['image']) }}" alt="{{ $sub['alt'] }}"></a></div>
			</div>
			@endforeach
		</div>
		<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Previous</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Next</span>
		</button>
	</div>
@endif