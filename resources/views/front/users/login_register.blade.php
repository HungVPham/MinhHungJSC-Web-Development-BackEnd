@extends('layouts.front_layout.front_layout')
@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<style>
.account-page{
    background-image: url('images/banner_images/15670_banner3.jpg');
}
#name-error,#last_name-error, #mobile-error, #email-error, #password-error, #id-error{
    font-size: 16px;
    font-weight: 700;
    width: 100%;
    text-align: left;
    color: var(--MinhHung-Red);
    margin-left: 5px;
}
</style>
<div class="account-page">               
    <div class="container">
        <div class="row">
            <div class="col-2"> 
                @if(Session::has('success_message'))
                <div class="alert alert-danger" role="alert" style="color: #ffffff; background-color: #228B22; border: 1px solid #228B22;">
                    {{ Session::get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                @if(Session::has('pending_message'))
                <div class="alert alert-danger" role="alert" style="color: #ffffff; background-color: var(--Solid-Gold); border: 1px solid var(--Solid-Gold);">
                    {{ Session::get('pending_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                @if(Session::has('error_message'))
                    <div class="alert alert-danger" role="alert" style="color: #ffffff ; background-color: var(--Delete-Red); border: 1px solid var(--Delete-Red);">
                    {{ Session::get('error_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                @endif    
                <div class="form-container"> 
                    <div class="form-btn">
                        <span id="RegLabel" onclick="register()">Đăng Ký</span>
                        <span id="LogForNav">Đã nhớ?→</span>
                        <span onclick="login()">Đăng Nhập</span>                   
                        <hr id="Indicator">
                    </div>
                    <form id="RegForm" action="{{ url('/register') }}" method="post">@csrf
                        <div id="reg-int-container" style="display: flex">
                            <div>
                                <label for="last_name">Họ*:</label>
                                <input id="last_name" name="last_name" placeholder="Họ">
                            </div>
                            <div>
                                <label for="last_name">Tên*:</label>
                                <input id="name" name="name" placeholder="Tên">
                            </div>
                        </div>
                        <div id="reg-int-container">
                            <label for="last_name">Email*:</label>
                            <input id="email" name="email" placeholder="Nhập email của quý khách">
                        </div>
                        <div  id="reg-int-container">
                            <label for="last_name">Số điện thoại*:</label>
                            <input id="mobile" name="mobile" placeholder="Nhập số điện thoại của quý khách">
                        </div>
                        <div  id="reg-int-container">
                            <label for="last_name">Mật khẩu*:</label>
                            <input id="password" name="password" placeholder="Tối thiểu 6 kí tự bao gồm cả chữ và số">
                        </div>
                        <button class="btn">Đăng Kí Tài Khoản</button>
                    </form>
                    <form id="LoginForm" action="{{ url('/login') }}" method="post">@csrf
                        <div class="login-logo-container">
                        <img src="{{ asset('/images/front_images/logoMinhHung.png')}}" width="200px" style="padding: 20px 0">
                        </div>
                            <label for="last_name">Số điện thoại hoặc email*:</label>
                            <input  id="id" name="id" placeholder="Vui lòng nhập số điện thoại hoặc email">
                            <label for="last_name">Mật khẩu*:</label>
                            <input  id="password" name="password" type="password" placeholder="Vui lòng nhập mật khẩu">
                        <button type="submit" class="btn">Đăng Nhập</button>
                        <a style="cursor: pointer;" onclick="forgot()">Quên Mật Khẩu?</a>
                    </form>
                    <form id="ForgotPwdForm" action="{{ url('/forgot-pwd') }}" method="post">@csrf
                        <h3 style="text-align: center; font-weight: 600;">Tìm tài khoản của bạn</h3>  
                            <label for="last_name">Email*:</label>
                            <input  id="id" name="id" placeholder="Vui lòng nhập email của quý khách">
                        <button type="submit" class="btn">Tìm tài khoản</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection