@extends('layouts.front_layout.front_layout')
@section('content')
<style>
    #name-error,#last_name-error, #mobile-error, #chkPwd, #current_pwd-error, #new_pwd-error, #confirm_pwd-error{
    display: block;
    font-size: 16px;
    font-weight: 700;
    width: 100%;
    text-align: left;
    color: var(--MinhHung-Red);
    margin-left: 5px;
    }
    a:not([href]):not([class]), a:not([href]):not([class]):hover {
        color: var(--Solid-White);
        text-decoration: none;
    }
    .pwd-toggle{
    width: 50px !important;
    position: absolute;
    right: -10px;
    top: 0;
    margin-top: 5px;
    color: rgba(0, 0,0, 0.3) !important;
    cursor: pointer;
    }
    .pwd-toggle.on{
        display: none;
    }
</style>
<div class="myAccount-page">
    <div class="small-container">
        <div class="row">
            <div class="myAccount-page-col-1">
                <div class="tab">
                    <a style="cursor: default;">{{ Auth::user()->last_name }} {{ Auth::user()->name }}</a>
                    <a href="{{ url('/my-account') }}"><i class="far fa-user-circle"></i>&nbsp;&nbsp;Hồ Sơ Của Tôi</a>
                </div>
            </div>
            <div class="myAccount-page-col-2">
                <div class="tabcontent">
                    @if(Session::has('success_message'))
                    <div class="alert alert-danger" role="alert" style="color: #228B22; background-color: #ffffff; border: 1px solid #228B22;">
                        {{ Session::get('success_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    @endif
                    @if(Session::has('pending_message'))
                    <div class="alert alert-danger" role="alert" style="color: var(--Solid-Gold); background-color: #ffffff; border: 1px solid var(--Solid-Gold);">
                        {{ Session::get('pending_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    @endif
                    @if(Session::has('error_message'))
                        <div class="alert alert-danger" role="alert" style="color:  var(--Delete-Red) ; background-color: #ffffff; border: 1px solid var(--Delete-Red);">
                        {{ Session::get('error_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    @endif    
                    @if ($errors->any())
                    <div class="alert alert-danger" style="color: var(--Delete-Red); background-color: #ffffff; border: 1px solid var(--Delete-Red)">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li style="margin-left: 20px">{{ $error }}</li>
                        @endforeach
                    </ul>
                    </div>
                    @endif
                    <div class="tabcontent-title">
                    <h2>Hồ sơ của tôi</h2>
                    <h5>Quản lý thông tin hồ sơ để bảo mật tài khoản</h5>
                    <hr>
                    </div>
                    <div class="form-container-newPwd">
                    <form id="InformationForm" action="{{ url('/my-account') }}" method="post">@csrf
                        <h4 style="font-weight: 600;">Thông Tin Tài Khoản</h4>  
                        <div id="reg-int-container" style="display: flex">
                            <div>
                                <label for="last_name">Họ:</label>
                                <input id="last_name" value="{{ $userDetails['last_name'] }}" name="last_name" pattern="[A-Za-z]{3}" placeholder="">
                            </div>
                            <div>
                                <label for="last_name">Tên:</label>
                                <input id="name" value="{{ $userDetails['name'] }}" name="name" pattern="[A-Za-z]+" placeholder="">
                            </div>
                        </div>
                            <label for="address">Địa chỉ:</label>
                            <input type="address" id="address" name="address" value="{{ $userDetails['address'] }}" placeholder="">
                            <label for="city">Thành Phố:</label>
                            <input type="city" id="city" name="city" value="{{ $userDetails['city'] }}" placeholder="">
                            <label for="state">Tỉnh Thành:</label>
                            <input type="state" id="state" name="state" value="{{ $userDetails['state'] }}" placeholder="">
                            <label for="country">Quốc Tịch:</label>
                            <select id="country" name="country" style="width: 100%;" class="select2">
                                <option value="">chọn quốc tịch...</option>
                                @foreach($countries as $country)
                                <option value="{{ $country['country_code'] }}" @if($country['country_code']==$userDetails['country']) selected @endif>{{ $country['country_name'] }}</option>
                                @endforeach
                            </select>
                            <label for="mobile">Số Điện Thoại:</label>
                            <input type="mobile" id="mobile" name="mobile" value="{{ $userDetails['mobile'] }}" placeholder="">
                            <label for="email">Email:</label>
                            <input type="email" id="email" readonly="" disabled name="email" value="{{ $userDetails['email'] }}" placeholder="">
                        <button type="submit" class="btn">Cập Nhật</button>
                    </form>
                    <form id="NewPwdForm" action="{{ url('/update-user-pwd') }}" method="post">@csrf 
                        <h4 style="font-weight: 600;">Đổi Mật Khẩu</h4>
                        <label for="current_pwd">Mật khẩu hiện tại*:</label>
                        <div style="position: relative;">
                            <input type="password"  autocomplete="off" id="current_pwd" name="current_pwd" placeholder="">
                            <span id="eyeSlash2" class="pwd-toggle" onclick="visibility2()"><i class="far fa-eye-slash"></i></span>
                            <span id="eyeShow2" class="pwd-toggle on" onclick="visibility2()"><i class="far fa-eye"></i></span>
                        </div>
                        <span id="chkPwd"></span>
                        <label for="new_pwd">Mật khẩu mới*:</label>
                        <div style="position: relative;">
                            <input type="password"  autocomplete="off" id="new_pwd" name="new_pwd" placeholder="">
                            <span id="eyeSlash3" class="pwd-toggle" onclick="visibility3()"><i class="far fa-eye-slash"></i></span>
                            <span id="eyeShow3" class="pwd-toggle on" onclick="visibility3()"><i class="far fa-eye"></i></span>
                        </div>
                        <label for="confirm_pwd">Xác nhận mật khẩu mới*:</label>
                        <div style="position: relative;">
                            <input type="password"  autocomplete="off" id="confirm_pwd" name="confirm_pwd" placeholder="">
                            <span id="eyeSlash4" class="pwd-toggle" onclick="visibility4()"><i class="far fa-eye-slash"></i></span>
                            <span id="eyeShow4" class="pwd-toggle on" onclick="visibility4()"><i class="far fa-eye"></i></span>
                        </div>
                    <button type="submit" class="btn">Đổi Mật Khẩu</button>
                </form>
                </div>
                </div>  
            </div>
        </div>
    </div>
</div>
@endsection