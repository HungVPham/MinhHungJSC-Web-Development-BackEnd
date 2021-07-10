<?php
use App\Section;
$sections = Section::sections();
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
				<label class="mobile-item"><a href="#">Trang Chủ</a></label>
			</li>
			<li id="prime-navlinks">
				<div style="display: flex; align-items: center;"><a class="desktop-item" href="#">Giới Thiệu</a><span id="expand-indicator">&nbsp;&#9660;</span></div>
				<input type="checkbox" id="showDrop">
				<label for="showDrop" class="mobile-item">Giới Thiệu<span id="expand-indicator-mobile">&nbsp;&#9660;</span></label>
				<ul class="drop-menu">
					<li><a href="">Lịch Sử Hình Thành</a></li>
					<li><a href="">Tầm Nhìn - Sứ Mệnh</a></li>
					<li><a href="">Chiến Lược Phát Triển</a></li>
				</ul>
			</li>
			<li id="prime-navlinks">
				<div style="display: flex; align-items: center;"><a class="desktop-item" href="#">Sản Phẩm</a><span id="expand-indicator">&nbsp;&#9660;</span></div>
				<input type="checkbox" id="showMega">
				<label for="showMega" class="mobile-item">Sản Phẩm<span id="expand-indicator-mobile">&nbsp;&#9660;</span></label>
				<div class="mega-box">
					<div class="megabox-content">
						@foreach($sections as $section)
						@if(count($section['categories'])>0)
						<div class="megabox-row">
							<header><a href="">{{ $section['name'] }}</a></header>
							<ul class="mega-links">
								@foreach($section['categories'] as $key => $category)
								<li id="megadrop-container">
									<div style="display: flex; align-items: center;"><a @if(count($category['subcategories'])>0) class="desktop-item" id="first-row" @else @endif href="#">{{ $category['category_name'] }}</a>@if(count($category['subcategories'])>0)<span id="expand-indicator">&nbsp;&#9660;</span>@else @endif</div>
									<input type="checkbox" id="showMegaDrop-{{ $key+1 }}">
									@if(count($category['subcategories'])>0) <div style="display: flex; align-items: center;"><label for="showMegaDrop-{{ $key+1 }}" class="mobile-item megadrop">{{ $category['category_name'] }}</label><span id="expand-indicator-megadrop">&nbsp;&#9660;</span></div> @endif
									<ul class="drop-menu-megabox">
										@foreach($category['subcategories'] as $subcategory)
										<li><a style="color: #000000" href="">{{ $subcategory['category_name'] }}</a></li>
										@endforeach
									</ul>
								</li>
								@endforeach
							</ul>
						</div>
						@endif
						@endforeach
						<div class="megabox-row">
							<header><a href>Catalouge Sản Phẩm</a></header>
							<ul class="mega-links" id="catalouge-col">
								<li><a href="">Dụng Cụ Điện MaxPro</a></li>
								<li><a href="">Máy Bơm Thủy Lực Shimge</a></li>
							</ul>
						</div>
					</div>
				</div>
			</li>
			<li id="prime-navlinks">
				<div style="display: flex; align-items: center;"><a class="desktop-item" href="#">Tin Tức - Sự Kiện</a><span id="expand-indicator">&nbsp;&#9660;</span></div>
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
			</li>
			<li id="prime-navlinks">
				<a class="desktop-item" style="display: flex; align-items: center;" href="#">Liện Hệ</a>
				<label for="showDrop2" class="mobile-item">Liện Hệ</label>
			</li>
		</ul>
		<div style="display: flex">
			<div class="navbar-cart" cartCount="0">
				<a href="#"><img src="{{ url('images/front_images/cart.png') }}"></a>
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
							<script>
								const icon = document.querySelector('.icon');
								const search = document.querySelector('.search');
								icon.onclick = function(){
									search.classList.toggle('active')
								}
							</script>
						</li>
						{{-- <li><img src="{{ url('images/front_images/account_setting.png') }}" alt=""><a href="">Cài Đặt Tài Khoản</a></li>
						<li><img src="{{ url('images/front_images/help.png') }}" alt=""><a href="">Trợ Giúp</a></li>
						<li><img src="{{ url('images/front_images/logout.png') }}" alt=""><a href="">Đăng Xuất</a></li> --}}
						<li><img src="{{ url('images/front_images/login.png') }}" alt=""><a href="">Đăng Nhập</a></li>
					</ul>
				</div>
			</div>
			<script>
				function menuToggle(){
					const toggleMenu = document.querySelector('.menu');
					toggleMenu.classList.toggle('active')
				}
			</script>
			<label id="open-nav" for="menu-btn"><i class="fas fa-bars"></i></label>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-2 index">
				<h3 id="company-subtitle">Công Ty Cổ Phần Đầu Tư Và Phát Triển</h3>
				<h1 id="company-title">Minh Hưng</h1>
				<p id="company-mantra"><span style="color: #cb1c22; font-weight: bolder;">Sức mạnh</span> đến từ sự <span style="color: #cb1c22; font-weight: bolder;">đoàn kết</span>,<br><span style="color: #cb1c22; font-weight: bolder;">Giá trị</span> đến từ <span style="color: #cb1c22; font-weight: bolder;">con người!</span></p>
				<a href="about.html" class="btn" id="homebtn">Đăng Ký Ngay! &#8594;</a>
			</div>
		</div>
	</div>
</div>  
@if(isset($page_name) && $page_name=="index")
	<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" style="display: flex; border-top: black 2px solid">
		<div class="carousel-indicators">
			<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
			<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
			<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
			<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
		</div>
		<div class="carousel-inner">
			<div class="carousel-item active" data-bs-interval="15000">
				<div class="overlay-image""><img src="{{ url('images/front_images/carousel/company-banner1.jpg') }}" alt=""></div>
				<div class="index-carousel-container">
					<div class="overlay-credo">
					<p><span style="color: #cb1c22; font-weight: bolder;">Sức mạnh</span> đến từ sự <span style="color: #cb1c22; font-weight: bolder;">đoàn kết</span>,
					<br>
					<span style="color: #cb1c22; font-weight: bolder;">Giá trị</span> đến từ <span style="color: #cb1c22; font-weight: bolder;">con người!</span></p>
					</div>
					<div class="overlay-btn">
					<a href="" class="btn">Đăng Ký Ngay &#8594;</a>
					</div>
				</div>
			</div>
			<div class="carousel-item">
				<div class="overlay-image""><img src="{{ url('images/front_images/carousel/7.jpg') }}" alt=""></div>
			</div>
			<div class="carousel-item">
				<div class="overlay-image""><img src="{{ url('images/front_images/carousel/8.jpg') }}" alt=""></div>
			</div>
			<div class="carousel-item">
				<div class="overlay-image""><img src="{{ url('images/front_images/carousel/9.jpg') }}" alt=""></div>
			</div>
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