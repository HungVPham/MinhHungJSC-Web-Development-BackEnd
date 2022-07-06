@extends('layouts.admin_layout.admin_layout')
@section('content')
  <style>
    .card-title{
      color: #ffffff;
      font-size: 1.2rem;
    }
    .card-header{
      background-color: var(--MinhHung-Red) !important;
    }
    .fa-minus{
      color: #ffffff;
    }
    .fa-minus:hover{
      color: #a09f9f;
    }
    .fa-plus{
      color: #ffffff;
    }
    .fa-plus:hover{
      color: #a09f9f;
    }
    input[type="checkbox"]{
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
    input[type="checkbox"]:after{
      font-family: "Font Awesome 5 Free";
      font-weight: 900;
      content: "\f00c";
      font-size: 13px;
      color: #ffffff;
      display: none;

    }
    input[type="checkbox"]:hover{
      background-color: #a5a5a5;
    }
    input[type="checkbox"]:checked{
      appearance: none;
      -webkit-appearance: none;
      background-color: var(--Positive-Green);
      height: 18px;
      width: 18px;
      align-items: center;
      justify-content: center;
      display: flex;
    }
    input[type="checkbox"]:checked::after{
      display: block;
    }
  </style>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Thương Mại</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}" id="admin-home">Trang Chủ</a></li>
              <li class="breadcrumb-item active"><a href="{{ url('admin/shipping-charges') }}" id="admin-prev">Phí Giao Hàng</a></li>
              <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger" style="color: var(--MinhHung-Red); background-color: #ffffff; border: 1px solid var(--MinhHung-Red);">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
        @endif
        @if (Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="color: #228B22; background-color: #ffffff; border: 1px solid #228B22">
              {{ Session::get('success_message') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        @endif
        <form name="popupForm" id="PopupForm" 
          @if(empty($shipping['id'])) 
            action="{{ url('admin/add-edit-shipping-charges') }}" 
          @else
            action="{{ url('admin/add-edit-shipping-charges/'.$shipping['id']) }}" 
          @endif
            method="post" enctype="multipart/form-data">@csrf
          <div class="card card-default" style="margin-bottom: 0 !important;">
            <div class="card-header">
              <h3 class="card-title">{{ $title }}</h3>
            </div>
            <div class="card-body">
              @if(empty($shipping['id']))
              <p aria-hidden="true" id="required-description">
                <label><span aria-hidden="true" class="required">&nbsp;*</span></label> &nbsp;trường nhập bắt buộc
              </p>
              @endif
              <div class="row">
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="shipping_charges">&nbsp;Phí Giao Hàng @if(empty($shipping['shipping_charges']))(10000 &#8594; 10,000) [VND]@endif</label>
                    <input type="number" min="0" class="form-control" name="shipping_charges" id="shipping_charges" placeholder="nhập phí giao hàng..."
                    @if (!empty($shipping['shipping_charges'])) 
                      value="{{ $shipping['shipping_charges'] }}"
                    @elseif($shipping['shipping_charges'] == 0)
                    value="0"
                    @else 
                      value="{{ old("shipping_charges") }}"
                    @endif>
                    @if(!empty($shipping['shipping_charges']))
                    <div style="color: grey">&nbsp;&nbsp;phí giao hàng hiện tại = <?php 
                          $num = $shipping['shipping_charges'];
                          $format = number_format($num,0,",",".");
                          echo $format;
                        ?> ₫
                    </div>
                    @elseif($shipping['shipping_charges'] == 0)
                    <div style="color: grey">&nbsp;&nbsp;phí giao hàng hiện tại = 0 ₫</div>
                    @endif
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="country">&nbsp;Quốc Gia</label>
                    <input type="text" readonly="true" class="form-control" name="country" id="country" 
                    @if (!empty($shipping['country'])) value="{{ $shipping['country'] }}"
                    @else value="{{ old("country") }}"
                    @endif>
                  </div>
                  <div class="form-group">
                    <label for="province">Tỉnh/Thành phố:</label>
                    <select autocomplete="off" id="province" name="province" style="width: 100%;" class="select2">
                        <option value="">chọn tỉnh/thành phố</option>
                        @foreach($provinces as $province)
                        <option @if(isset($shipping['province']) && $shipping['province']==$province['_prefix'].' '.$province['_name']) selected="" @endif value="{{ $province['id'] }}">{{ $province['_prefix'] }} {{ $province['_name'] }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div id="appendDistrictsLevel" class="form-group">
                    @include('front.users.append_districts_level')
                  </div>
                  <div id="appendWardsLevel" class="form-group">
                    @include('front.users.append_wards_level')
                  </div>
                </div>
              </div>
          </div>
        </form>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" id="admin-btn" style="font-size: 1.0rem;">{{ $title }}</button>
            </div>
          </div>
        </div><div style="color: #f4f6f9; font-size: 0.5rem; margin: none; padding: none;">dummy text margin</div>
      </div>
    </div>
  </section>
</div>
@endsection