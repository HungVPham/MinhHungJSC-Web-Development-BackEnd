@extends('layouts.front_layout.front_layout')
@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<style>
.account-page{
    background-image: url('/images/banner_images/15670_banner3.jpg');
}
#name-error,#last_name-error, #mobile-error, #email-error, #password-error, #id-error{
    font-size: 16px;
    font-weight: 700;
    width: 100%;
    text-align: left;
    color: var(--MinhHung-Red);
    margin-left: 5px;
}
.form-container span {
    width: 100%;
    font-size: 1.5rem;
    padding: 20px;
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
                        <span>Quên Mật Khẩu?</span>                   
                    </div>
                    <form id="ForgotPwdForm" action="{{ url('/forgot-pwd') }}" method="post">@csrf
                        <div class="login-logo-container">
                        </div>
                            <label for="last_name">Email*:</label>
                            <input  id="id" name="id" placeholder="Vui lòng nhập số email của quý khách">
                        <button type="submit" class="btn">Đăng Nhập</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection