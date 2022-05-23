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
    margin-top: -10px
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

    input{
        margin-bottom: 10px;
    }

    .select2{
        margin-bottom: 10px;
    }
</style>
<div class="myAccount-page">
    <div class="small-container">
        <div class="row">
            <div class="myAccount-page-col-1">
                <div class="tab">
                    <a style="cursor: default;">{{ Auth::user()->last_name }} {{ Auth::user()->name }}</a>
                    <a href="{{ url('/my-account') }}"><i style="color: var(--MinhHung-Red)" class="fas fa-user"></i>&nbsp;&nbsp;Hồ Sơ Của Tôi</a>
                    <a href="{{ url('/add-edit-delivery-address') }}"><i class="fas fa-map-pin"></i>&nbsp;&nbsp;Địa Chỉ Nhận Hàng</a>
                    <a href="{{ url('/orders') }}"><i class="fas fa-shopping-bag"></i>&nbsp;&nbsp;Đơn Mua</a>
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
                                <input id="last_name" value="{{ $userDetails['last_name'] }}" name="last_name">
                            </div>
                            <div>
                                <label for="last_name">Tên:</label>
                                <input id="name" value="{{ $userDetails['name'] }}" name="name">
                            </div>
                        </div>
                            <label for="province">Tỉnh/Thành phố:</label>
                            <select id="province" name="province" style="width: 100%;" class="select2">
                                <option value="">chọn tỉnh/thành phố</option>
                                @foreach($provinces as $province)
                                <option @if(isset($userDetails['province']) && $userDetails['province']==$province['_prefix'].' '.$province['_name']) selected="" @endif value="{{ $province['id'] }}">{{ $province['_prefix'] }} {{ $province['_name'] }}</option>
                                @endforeach
                            </select>
                            <div id="appendDistrictsLevel">
                                @include('front.users.append_districts_level')
                            </div>
                            <div id="appendWardsLevel">
                                @include('front.users.append_wards_level')
                            </div>
                            <label for="address">Thôn/Xóm/Số Nhà:</label>
                            <input type="address" id="address" name="address" @if(isset($userDetails['address'])) value="{{ $userDetails['address'] }}" @else value="{{ old('address') }}" @endif>
                            <label for="mobile">Số Điện Thoại:</label>
                            <input type="mobile" id="mobile" name="mobile" @if(isset($userDetails['mobile'])) value="{{ $userDetails['mobile'] }}" @else value="{{ old('mobile') }}" @endif>
                            <label for="email">Email:</label>
                            <input type="email" id="email" readonly="" disabled name="email" value="{{ $userDetails['email'] }}">
                            @if(!empty($userDetails['company_name']))
                            <h4 style="font-weight: 600; margin-top: 20px">Thông Tin Doanh Nghiệp</h4>  
                            <label for="company_name">Tên Doanh Nghiệp:</label>
                            <input id="company_name" readonly="" name="company_name" @if(isset($userDetails['company_name'])) value="{{ $userDetails['company_name'] }}" @else value="{{ old('company_name') }}" @endif>
                            <label for="company_email">Email Doanh Nghiệp:</label>
                            <input type="email" id="company_email" readonly="" disabled name="company_email" value="{{ $userDetails['company_email'] }}">
                            @endif
                        <button type="submit" class="btn">Cập Nhật</button>
                    </form>
                    <form id="NewPwdForm" action="{{ url('/update-user-pwd') }}" method="post">@csrf 
                        <h4 style="font-weight: 600;">Đổi Mật Khẩu</h4>
                        <label for="current_pwd">Mật khẩu hiện tại*:</label>
                        <div style="position: relative;">
                            <input type="password"  autocomplete="off" id="current_pwd" name="current_pwd">
                            <span id="eyeSlash2" class="pwd-toggle" onclick="visibility2()"><i class="far fa-eye-slash"></i></span>
                            <span id="eyeShow2" class="pwd-toggle on" onclick="visibility2()"><i class="far fa-eye"></i></span>
                        </div>
                        <span id="chkPwd"></span>
                        <label for="new_pwd">Mật khẩu mới*:</label>
                        <div style="position: relative;">
                            <input type="password"  autocomplete="off" id="new_pwd" name="new_pwd" placeholder="≥6 ký tự có chữ thường, hoa, và số.">
                            <span id="eyeSlash3" class="pwd-toggle" onclick="visibility3()"><i class="far fa-eye-slash"></i></span>
                            <span id="eyeShow3" class="pwd-toggle on" onclick="visibility3()"><i class="far fa-eye"></i></span>
                        </div>
                        <label for="confirm_pwd">Xác nhận mật khẩu mới*:</label>
                        <div style="position: relative;">
                            <input type="password"  autocomplete="off" id="confirm_pwd" name="confirm_pwd">
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