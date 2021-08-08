<?php
    use App\CmsPage;
    $CmsDetails = CmsPage::CmsPageDetails();
?>
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="footer-col-1">
                <h3>Công Ty Đầu Tư và Phát Triển Minh Hưng</h3>
                <p><span>Mã Số Thuế:</span> 0312501361</p>
                <p><span>Giấy Chứng Nhận Đăng Ký Doanh Nghiệp</span> cấp ngày 11.10.2013</p>
                <p><span>Cơ Quan Cấp:</span> Phòng đăng ký kinh doanh sở kế hoạch và đầu tư TP.HCM</p>
                <img width="150px" src="{{ ('/images/front_images/tb_cong_thuong.png') }}" alt="dấu xác nhận đã thông báo bộ công thương">
            </div>
            <div class="footer-col-2">
                <div class="footerLogo">    
                    <a href="{{ url('') }}"><img src="{{ ('/images/front_images/logoMinhHung.png') }}" alt="logo công ty"></a>
                </div>
                <p><span>Địa Chỉ:</span> 56 Trương Phước Phan, P.Bình Trị Đông, Q.Bình Tân, TP.HCM</p>
                <p><span>Tel:</span><a href="tel: 028 62 666 333">(028) 62 666 333</a> -&nbsp;&nbsp;&nbsp;Fax:&nbsp;&nbsp;&nbsp;(028) 62 666 555</p>
                <p><span>Email:</span><a href="mailto:salesminhhung@gmail.com?subject= Hỏi/Đáp: Minh Hưng JSC">salesminhhung@gmail.com</a> </p>
            </div>
            <div class="footer-col-3">
                <h3>Chính Sách Công Ty</h3>
                <ul>
                    @foreach($CmsDetails as $CmsPage)
                    <a id="footer-nav" href="{{ url('docs/'.$CmsPage['url']) }}"><li>{{ $CmsPage['title'] }}</li></a>
                    @endforeach
                </ul>
            </div>
            <div class="footer-col-4">
                <h3>Theo Dõi Chúng Tôi</h3>
                <ul>
                    <a id="footer-nav" href="https://www.facebook.com/pages/C%C3%B4ng%20ty%20CP%20%C4%90%E1%BA%A7u%20T%C6%B0%20v%C3%A0%20Ph%C3%A1t%20Tri%E1%BB%83n%20Minh%20H%C6%B0ng/1966408697008473/" target="_blank"><li>Facebook</li></a>
                    <a id="footer-nav" href="https://www.youtube.com/channel/UCG5dwZKUAWetHU3BAkSl8Og" target="_blank"><li>Youtube</li></a>
                    <a id="footer-nav" href="https://nemgalaxy.vn/galaxy/" target="_blank"><li>Nệm Galaxy</li></a>
                </ul>
            </div>
        </div>
        <hr>
            <div class="copyright">
            <strong>COPYRIGHT &copy; 11/2013 -
                <script>
                  var today = new Date();
                  var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                  var yyyy = today.getFullYear();
            
                  today = mm  + '/' + yyyy;
                document.write(today)
                </script><a href="">MINH HUNG JSC</a>.ALL RIGHTS RESERVED
            </strong>
            </div>
    </div>
</div>