@extends('layouts.front_layout.front_layout')
@section('content')
<div class="small-container single-product">
    <div class="row">
        <div class="col-2 single-product">
            <img src="{{ asset('images/product/MaxPro/máy-khoan-pin/mayKhoanpin_maxpro_thumbnail.jpg') }}" id="ProductImg" width="100%" alt="hình ảnh sản phẩm">
            <div class="small-img-row">
                <div class="small-img-col">
                    <img src="{{ asset('images/product/MaxPro/máy-khoan-pin/mayKhoanpin_maxpro_thumbnail.jpg') }}" class="small-img" width="100%" alt="hình ảnh sản phẩm 1">
                </div>
                <div class="small-img-col">
                    <img src="{{ asset('images/product/MaxPro/máy-khoan-pin/mayKhoanpin_maxpro(2).jpg') }}" class="small-img" width="100%" alt="hình ảnh sản phẩm 2">
                </div>
                <div class="small-img-col"> 
                    <img src="{{ asset('images/product/MaxPro/máy-khoan-pin/mayKhoanpin_maxpro(3).jpg') }}" class="small-img" width="100%" alt="hình ảnh sản phẩm 3">
                </div>
                <div class="small-img-col">
                    <img src="{{ asset('images/product/MaxPro/máy-khoan-pin/mayKhoanpin_maxpro(4).jpg') }}" class="small-img" width="100%" alt="hình ảnh sản phẩm 4">
                </div>
            </div>
        </div>
        <div class="col-2 single-product"> 
            <p>Sản Phẩm / Dụng Cụ Điện MaxPro / Máy Khoan Pin</p>
            <h1>Máy khoan pin 18V 2 cấp độ + Chế độ khoan búa (MPCD18HLI/2E)</h1>
            <h4>Giá Liên Hệ</h4>
            <p>Số Lượng Mua: <input type="number" value="1"></p>
            <p>Mẫu Sản Phẩm: <select class="select2"></select></p>
            <p><a href="" class="btn">Thêm Vào Giỏ</a></p>
        </div>
    </div>
</div>
<!------Title------->
<div class="small-container listing">
    <div class="row row-2">
        <div></div>
        <div class="flexleft-container">
            <i title="hiện thị video" class="viewbtn fab fa-youtube" onclick="Btn(0)"></i>
            <i title="hiện thị thông tin" class="viewbtn fas fa-info-circle Active" onclick="Btn(1)"></i>
        </div>
    </div>
</div>
<div class="small-container" style="margin-top: 20px">
    <div class="viewsw row video">
        <iframe height="560px" src="https://www.youtube.com/embed/vlmiWc6zPAs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <div class="viewsw row info Active">
        <div>
            <label for="product_description"><strong>Giới Thiệu Sản Phẩm:</strong></label>
            <br>
            <br>
            <p name="product_description">
            Máy khoan pin 18V có chức năng búa là thành viên mới nhất trong gia đình máy khoan chạy pin của thương hiệu MaxPro. Lần đầu được công ty Minh Hưng phân phối vào năm 2019, máy khoan pin búa 18V MaxPro đã nhận được nhiều lời khen từ các khách hàng về chất lượng cũng như độ hoàn thiện của máy. Sử dụng viên pin 18V, 1.5Ah cùng với lực mô-men xoắn cực đại lên đến 45N.m, giúp máy bắt vít lên gỗ hay thép một cách nhanh chóng, đường khoan chuẩn xác. Máy khoan pin 18V có chức năng búa có thiết kế gọn nhẹ (chỉ 1.6kgs), tay cầm chắc chắn. Chức năng búa của máy có lực đập lên đến 6400bpm ở chế độ mạnh nhất giúp người dùng có thể khoan tường 1 cách hiệu quả.</p>
        </div>
        <div> 
            <label for="spec_feature"><strong>Tính Năng Nổi Bật:</strong></label>
            <br>
            <br>
            <ul name="spec_feature" style="list-style-type: square;">
                <li>M&ocirc;men xoắn lớn 45N.m gi&uacute;p m&aacute;y bắt v&iacute;t dễ
                    d&agrave;ng hơn l&ecirc;n chất liệu cứng như gỗ v&agrave; th&eacute;p</li>
                <li>Thiết kế chắc chắn,đẹp v&agrave; bắt mắt</li>
                <li>Tay cầm &ecirc;m &aacute;i, chống rung</li>
                <li>C&oacute; chức năng b&uacute;a</li>
            </ul> 
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