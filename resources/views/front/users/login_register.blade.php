@extends('layouts.front_layout.front_layout')
@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<style>
    .account-page {
    position: relative;
    background-image: url('images/banner_images/15670_banner3.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    background-width: 100%:
}
.close, .mailbox-attachment-close{
    line-height: inherit;
}

.alert .close, .alert .mailbox-attachment-close {
    color: #ffffff;
    opacity: 0.3;
}
.alert{
    margin: 0;
    border-radius: 0;
}
.col-2{
        flex-basis: inherit;
        min-width: 400px;
    }
</style>
<div class="account-page">               
    <div class="container">
        <div class="row">
            <div class="col-2"> 
                @if(Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="color: #228B22; background-color: #ffffff; border: 1px solid #228B22">
                    {{ Session::get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                @endif
                @if(Session::has('error_message'))
                    <div class="alert alert-danger" role="alert" style="color: #ffffff ; background-color: #cb1c22; border: 1px solid #cb1c22; width: 400px; margin-top: 15vh; margin-bottom: -15vh; text-align: center; margin-left: 23px;">
                    {{ Session::get('error_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                @endif    
                <div class="form-container"> 
                    <div class="form-btn">
                        <span onclick="register()">Đăng Ký</span>
                        <span onclick="login()">Đăng Nhập</span>                   
                        <hr id="Indicator">
                    </div>
                    <form id="RegForm" action="{{ url('/register') }}" method="post">@csrf
                        <div style="display: flex"><input id="last_name" name="last_name" placeholder="Họ">&nbsp;<input id="name" name="name" placeholder="Tên"></div>
                        <input id="email" name="email" placeholder="Email">
                        <input id="mobile" name="mobile" placeholder="Số Điện Thoại">
                        <input id="password" name="password" placeholder="Mật Khẩu">
                        <button class="btn">Đăng Ký Tài Khoản</button>
                    </form>
                    <form id="LoginForm" action="{{ url('/login') }}" method="post">
                        <img src="{{ asset('/images/front_images/logoMinhHung.png')}}" width="200px" style="padding: 10px 0">
                        <input placeholder="Email">
                        <input placeholder="Mật Khẩu">
                        <button type="submit" class="btn">Đăng Nhập</button>
                        <a href="">Quên Mật Khẩu?</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection