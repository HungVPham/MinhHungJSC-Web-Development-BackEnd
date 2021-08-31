@extends('layouts.front_layout.front_layout')
@section('content')
<style>
    #name-error, #mobile-error, #address-error, #city-error, #country-error{
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
    #deliver-addresses-container a{
        padding: 0px;
        text-decoration: underline;
        margin-right: 5px;
        float: right
    }
    #deliver-addresses-container a:hover{
        color: var(--MinhHung-Red);
    }
    input{
        margin-bottom: 10px;
    }

    .select2{
        margin-bottom: 10px;
    }
    #is-default-container input[type="checkbox"]{
      appearance: none;
      -webkit-appearance: none;
      height: 18px;
      width: 18px;
      background-color: #d5d5d5;
      outline: none;
      cursor: pointer;
      border: 1px solid #333;
      align-items: center;
      justify-content: center;
      display: flex;
      float: right;
      margin-top: 7px;
    }
    #is-default-container input[type="checkbox"]:after{
      font-family: "Font Awesome 5 Free";
      font-weight: 900;
      content: "\f00c";
      font-size: 13px;
      color: #ffffff;
      display: none;

    }
    #is-default-container input[type="checkbox"]:hover{
      background-color: #a5a5a5;
    }
    #is-default-container input[type="checkbox"]:checked{
      appearance: none;
      -webkit-appearance: none;
      background-color: var(--Positive-Green);
      height: 18px;
      width: 18px;
      align-items: center;
      justify-content: center;
      display: flex;
    }
    #is-default-container input[type="checkbox"]:checked::after{
      display: block;
    }

</style>
<div class="myAccount-page">
    <div class="small-container">
        <div class="row">
            <div class="myAccount-page-col-1">
                <div class="tab">
                    <a style="cursor: default;">{{ Auth::user()->last_name }} {{ Auth::user()->name }}</a>
                    <a href="{{ url('/my-account') }}"><i class="fas fa-user"></i>&nbsp;&nbsp;Hồ Sơ Của Tôi</a>
                    <a href="{{ url('/add-edit-delivery-address') }}"><i style="color: var(--MinhHung-Red)" class="fas fa-map-pin"></i>&nbsp;&nbsp;Địa Chỉ Nhận Hàng</a>
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
                        <h2>Địa Chỉ Nhận Hàng</h2>
                        <hr>
                    </div>
                <div class="form-container-newPwd">
                    <form id="deliveryAddressForm" 
                    @if(empty($address['id']))
                    action="{{ url('/add-edit-delivery-address') }}" 
                    @else
                    action="{{ url('add-edit-delivery-address/'.Crypt::encrypt($address['id'])) }}" 
                    @endif
                    method="post">@csrf
                        <h4 style="font-weight: 600;">{{ $title }}</h4>  
                            <input type="hidden" name="id" value="{{ Crypt::encrypt($address['id']) }}">
                            <label for="name">Người Nhận Hàng:</label>
                            <input type="name" id="name" name="name" @if(isset($address['name'])) value="{{ $address['name'] }}" @else value="{{ old('name') }}" @endif placeholder="họ và tên">
                            <label for="province">Tỉnh/Thành phố:</label>
                            <select id="province" name="province" style="width: 100%;" class="select2">
                                <option value="">chọn tỉnh/thành phố</option>
                                @foreach($provinces as $province)
                                <option @if(isset($address['province']) && $address['province']==$province['_prefix'].' '.$province['_name']) selected="" @endif value="{{ $province['id'] }}">{{ $province['_prefix'] }} {{ $province['_name'] }}</option>
                                @endforeach
                            </select>
                            <div id="appendDistrictsLevel">
                                @include('front.users.append_districts_level')
                            </div>
                            <div id="appendWardsLevel">
                                @include('front.users.append_wards_level')
                            </div>
                            <label for="address">Thôn/Xóm/Số Nhà:</label>
                            <input type="address" id="address" name="address" @if(isset($address['address'])) value="{{ $address['address'] }}" @else value="{{ old('address') }}" @endif placeholder="địa chỉ nhận hàng cụ thể">
                            <label for="mobile">Số Điện Thoại:</label>
                            <input type="mobile" id="mobile" name="mobile" @if(isset($address['mobile'])) value="{{ $address['mobile'] }}" @else value="{{ old('mobile') }}" @endif placeholder="số điện thoại người nhận hàng">
                            @if($addressCount>0)
                            <div id="is-default-container">
                                <label for="is-default-checkbox">Mặc định:</label>
                                <input id="is-default-checkbox" name="is_default" @if(isset($address['is_default']) && $address['is_default']=='Yes') checked @endif type="checkbox" value="Yes">
                            </div>
                            @elseif($addressCount==1)
                                <input name="is_default" type="hidden" value="Yes">
                            @endif
                        <button type="submit" class="btn">{{ $title }}</button>
                    </form>
                    <form id="deliver-addresses-container">
                        <h4 style="font-weight: 600;">Địa Chỉ Của Tôi</h4> 
                        @if(!empty($deliveryAddresses))
                        @foreach($deliveryAddresses as $addresses)
                            <span style="color: rgba(85,85,85,.8)">Họ và Tên:</span> {{ $addresses['name'] }}
                            <br>
                            <span style="color: rgba(85,85,85,.8)">Số Điện Thoại:</span> {{ $addresses['mobile'] }}
                            <br>
                            <span style="color: rgba(85,85,85,.8)">Địa Chỉ:</span> {{ $addresses['address'] }}, 
                            {{ $addresses['ward'] }}, 
                            {{ $addresses['district'] }}, 
                            {{ $addresses['province'] }}, 
                            @if(!empty($addresses['state']))
                            {{ $addresses['state'] }}, 
                            @endif
                            {{ $addresses['country'] }}.
                            <br>
                            @if($addresses['id']!=$address['id'])
                            @if($addresses['is_default']=="Yes") <span style="color: #888">(Mặc Định)</span>@endif
                            @if($addresses['is_default']=="No")
                                <a title="xóa địa chỉ nhận hàng" class="addressDelete" record="delivery-address" recordid="{{ Crypt::encrypt($addresses['id']) }}" href="javascript:void(0)">xóa</a>
                            @endif
                                <a title="sửa địa chỉ nhận hàng" href="{{ url('add-edit-delivery-address/'.Crypt::encrypt($addresses['id'])) }}">sửa</a>
                            @else
                                @if($addresses['is_default']=="Yes") <span style="color: #888">(Mặc Định)</span>@endif
                                <a style="color: #228B22; text-decoration: none;"><span style="font-size: 2rem;">●</span>đang sửa</a>
                            @endif
                            <br>
                            <hr>               
                        @endforeach
                        @else
                            <p>Quý khách hiện chưa có địa chỉ nhận hàng.</p>
                        @endif
                    </form>
                </div>
                </div>  
            </div>
        </div>
    </div>
</div>
@endsection