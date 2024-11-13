@extends('layouts.front_layout.front_layout')
@section('content')
<style>
    .slick-list {
        overflow: visible;
    }
</style>
<div class="page-wrapper">
    <!--post slider-->
    <div class="post-slider">
        <h1 class="slider-title">Tin Tức - Sự Kiện</h1>
        <div class="slider-nav-container" style=" width: 1500px; margin: 0 auto; position: relative;">
        <i class="fas fa-chevron-left prev"></i>
        <i class="fas fa-chevron-right next"></i>
        <div class="post-wrapper">
            <div class="post slider">
                <a href="single.html" class="sliderpost-nav"><div class="postcard-background">
                <img src="images/companyGroup1(CNY2021)_thumbnail.jpg" alt="post image slider 1" class="slider-image">  
                <div class="post-info">
                    <h4><a href="single.html">Mừng Năm Mới Tân Sửu 2021</a></h4>
                    <div class="user-date-container">
                    <a href=""><i id="slider-user-nav" class="fas fa-user"> Người Minh Hưng</i></a>
                    &nbsp;
                    <i class="fas fa-calendar"> 19 Tháng 02, 2021</i>
                    </div>       
                </div>
                </div></a>
            </div>
            <div class="post slider">
                <a href="" class="sliderpost-nav"><div class="postcard-background">
                <img src="images/companyGroup1(SAPA2021)_thumbnail.jpg" alt="post image slider 2" class="slider-image">  
                <div class="post-info">
                    <h4><a href="">Hành Trình Về Phía Bắc Tổ Quốc</a></h4>
                    <div class="user-date-container">
                    <a href=""><i id="slider-user-nav" class="fas fa-user">Người Minh Hưng</i></a>
                    &nbsp;
                    <i class="fas fa-calendar"> 19 Tháng 01, 2021</i> 
                    </div>      
                </div>
                </div></a>
            </div>
            <div class="post slider">
                <a href="" class="sliderpost-nav"><div class="postcard-background">
                <img src="images/birthday-stock/1_thumbnail.jpg" alt="post image slider 3" class="slider-image">  
                <div class="post-info">
                    <h4><a href="">[Happy Birthday] chị Hoàng Thị Đông</a></h4>
                    <div class="user-date-container">
                    <a href=""><i id="slider-user-nav" class="fas fa-user"> Người Minh Hưng</i></a>
                    &nbsp;
                    <i class="fas fa-calendar"> 25 Tháng 09, 2020</i>
                    </div>       
                </div>
                </div></a>
            </div>
            <div class="post slider">
                <a href="" class="sliderpost-nav"><div class="postcard-background">
                <img src="images/birthday-stock/2_thumbnail.jpg" alt="post image slider 4" class="slider-image">  
                <div class="post-info">
                    <h4><a href="">[Happy Birthday] chị Hoàng Thị Khánh Thảo</a></h4>
                    <div class="user-date-container">
                     <a href=""><i id="slider-user-nav" class="fas fa-user"> Người Minh Hưng</i></a>
                    &nbsp;
                    <i class="fas fa-calendar"> 13 Tháng 08, 2020</i>
                    </div>       
                </div>
                </div></a>
            </div>
            <div class="post slider">
                <a href="" class="sliderpost-nav"><div class="postcard-background">
                <img src="images/birthday-stock/3_thumbnail.jpg" alt="post image slider 5" class="slider-image">  
                <div class="post-info">
                    <h4><a href="">[Happy Birthday] anh Nguyễn Minh Tần</a></h4>
                    <div class="user-date-container">
                     <a href=""><i id="slider-user-nav" class="fas fa-user"> Người Minh Hưng</i></a>
                    &nbsp;
                    <i class="fas fa-calendar"> 13 Tháng 08, 2020</i>   
                    </div>    
                </div>
                </div></a>
            </div>
        </div>
        </div>
    </div>
<!--Content-->
<div class="content clearfix">
    <div class="main-content">
        <h1 class="recent-post-title">Bài Viết Mới</h1>
        <div class="post clearfix">
            <img src="images/companyGroup1(CNY2021)_thumbnail.jpg" class="post-image" alt="post image 1">
            <div class="post-preview">  
                <h2><a href="single.html">Mừng Năm Mới Tân Sửu 2021</a></h2>
                 <a href=""><i id="content-user-nav" class="fas fa-user"> Người Minh Hưng</i></a>
                &nbsp;
                <i class="fas fa-calendar"> 19 Tháng 02, 2021</i>
                <p class="preview-text">Mừng ngày đầu tiên trở lại làm việc sau tuần nghỉ Tết Nguyên Đán (17.02.2021).</p>
                <a href="single.html" class="btn read-more">Chi Tiết</a>
            </div>
        </div>
        <div class="post clearfix">
            <img src="images/companyGroup1(SAPA2021)_thumbnail.jpg" class="post-image" alt="post image 2">
            <div class="post-preview">  
                <h2><a href="" >Hành Trình Về Phía Bắc Tổ Quốc</a></h2>
                <a href=""><i id="content-user-nav" class="fas fa-user"> Người Minh Hưng</i></a>
                &nbsp;
                <i class="fas fa-calendar"> 19 Tháng 01, 2021</i>
                <p class="preview-text">Người Minh Hưng chúng tôi đã có 1 chuyến đi với rất nhiều kỉ niệm, sự trải nghiệm, nhìn nhận sự việc ở thế giới bên ngoài, xung quanh ta với nhiều tình yêu thương bằng ánh mắt trìu mến...</p>
                <a href="" class="btn read-more">Chi Tiết</a>
            </div>
        </div>
        <div class="post clearfix">
            <img src="images/birthday-stock/1_thumbnail.jpg" class="post-image" alt="post image 3">
            <div class="post-preview">  
                <h2><a href="">[Happy Birthday] chị Hoàng Thị Đông</a></h2>
                 <a href=""><i id="content-user-nav" class="fas fa-user"> Người Minh Hưng</i></a>
                &nbsp;
                <i class="fas fa-calendar"> 25 Tháng 09, 2020</i>
                <p class="preview-text">Gia đình Minh Hưng JSC xin chúc chị Hoàng Thị Đông (Nhân viên Phòng Tài Chính - Kế Toán) ngày sinh nhật thật hạnh phúc!</p>
                <a href="" class="btn read-more">Chi Tiết</a>
            </div>
        </div>
        <div class="post clearfix">
            <img src="images/birthday-stock/2_thumbnail.jpg" class="post-image" alt="post image 4">
            <div class="post-preview">  
                <h2><a href="">[Happy Birthday] chị Hoàng Thị Khánh Thảo</a></h2>
                 <a href=""><i id="content-user-nav" class="fas fa-user"> Người Minh Hưng</i></a>
                &nbsp;
                <i class="fas fa-calendar"> 13 Tháng 08, 2020</i>
                <p class="preview-text">Gia đình Minh Hưng JSC xin chúc chị Hoàng Thị Khánh Thảo (Nhân viên kinh doanh) ngày sinh nhật thật hạnh phúc!</p>
                <a href="" class="btn read-more">Chi Tiết</a>
            </div>
        </div>
    </div>
    <div class="sidebar">
        <div class="section search" style="height: auto; width: auto">
            <h2 class="section-title-search">Tìm Kiếm</h2>
            <form action="news-events.html" method="post">
                <input type="text" name="search-term" class="search-input" placeholder="tìm kiếm...">
            </form>
        </div>
        <div class="section topics">
            <h2 class="section-title-topics">Chủ đề</h2>
            <ul>
                <li><a href=""><b>Tất Cả</b></a></li>
                <li><a href="">Tin Nội Bộ</a></li>
                <li><a href="">Tin Thị Trường</a></li>
                <li><a href="">Tin Khuyến Mãi</a></li>
                <li><a href="">Video Clip</a></li>  
            </ul>
        </div>
    </div>
    <div class="page-btn">
            
    </div>
</div>
<script>
    var MenuItems = document.getElementById("MenuItems");

    MenuItems.style.maxHeight = "0px";

    function menutoggle(){
        if(MenuItems.style.maxHeight == "0px")
            {
                MenuItems.style.maxHeight = "250px";
            }
        else
            {
                MenuItems.style.maxHeight = "0px";
            }
    }
</script>
<!--JQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<!--Slick Carousel-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<!--Custom Script-->
<script src="js/script.js"></script>
<script src="{{ url('js/front_js/vanilla-tilt.js') }}"></script>
<script type="text/javascript">
	VanillaTilt.init(document.querySelectorAll(".post.slider"), {
		max: 15,
		speed: 100,
        scale: "0.98",
	});
</script>
<script type="text/javascript">
	VanillaTilt.init(document.querySelectorAll(".post"), {
		max: 15,
		speed: 100,
        axis: "y"
	});
</script>
@endsection