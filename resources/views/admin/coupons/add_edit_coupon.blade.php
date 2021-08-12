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
  </style>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Catalogue</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}" id="admin-home">Trang Chủ</a></li>
              <li class="breadcrumb-item active"><a href="{{ url('admin/coupons') }}" id="admin-prev">Coupon Khuyến Mãi</a></li>
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
        <form name="couponForm" id="CouponForm" 
          @if(empty($coupon['id'])) 
            action="{{ url('admin/add-edit-coupon') }}" 
          @else
            action="{{ url('admin/add-edit-coupon/'.$coupon['id']) }}" 
          @endif
            method="post" enctype="multipart/form-data">@csrf
          <div class="card card-default" style="margin-bottom: 0 !important;">
            <div class="card-header">
              <h3 class="card-title">{{ $title }}</h3>
            </div>
            <div class="card-body">
              @if(empty($coupon['id']))
              <p aria-hidden="true" id="required-description">
                <label><span aria-hidden="true" class="required">&nbsp;*</span></label> &nbsp;trường nhập bắt buộc
              </p>
              @endif
              <div class="row">
                <div class="col-12 col-sm-6">
                  @if(empty($coupon['coupon_code']))
                  <div class="form-group">
                    <label for="coupon_option">&nbsp;Code Coupon Tự Động/Thủ Công @if(empty($coupon['id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <br>
                    <span><input checked id="AutomaticCoupon" type="radio" name="coupon_option" value="Automatic"> &nbsp;Tự Động (Automatic)</span>
                    &nbsp;&nbsp;<span><input id="ManualCoupon" type="radio" name="coupon_option" value="Manual"> &nbsp;Thủ Công (Manual)</span>
                  </div>
                  <div class="form-group" style="display: none" id="couponField">
                    <label for="coupon_code">&nbsp;Code Coupon Thủ Công @if(empty($coupon['id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="nhập thủ công code coupon khuyến mãi..."
                    @if (!empty($coupon['coupon_code'])) value="{{ $coupon['coupon_code'] }}"
                    @else value="{{ old("coupon_code") }}"
                    @endif>
                  </div>
                  @else
                  <input type="hidden" name="coupon_code" value="{{ $coupon['coupon_code'] }}">
                  <input type="hidden" name="coupon_option" value="{{ $coupon['coupon_option'] }}">
                  <div class="form-group">
                    <label for="coupon_code">&nbsp;Code Coupon: </label>
                    <span>{{ $coupon['coupon_code'] }}</span>
                  </div>
                  @endif
                  <div class="form-group">
                    <label for="coupon_type">&nbsp;Thể lệ Coupon @if(empty($coupon['id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <br>
                    <span><input @if(isset($coupon['coupon_type'])&&$coupon['coupon_type']=="Single") checked @elseif(!isset($coupon['coupon_type'])) checked @endif type="radio" name="coupon_type" value="Single"> &nbsp;Dùng Một Lần (Single-Use)</span>
                    &nbsp;&nbsp;<span><input @if(isset($coupon['coupon_type'])&&$coupon['coupon_type']=="Multiple") checked @endif type="radio" name="coupon_type" value="Multiple"> &nbsp;Dùng Nhiều Lần (Multiple-Uses)</span>
                  </div>
                  <div class="form-group">
                    <label for="amount_type">&nbsp;Loại Coupon @if(empty($coupon['id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <br>
                    <span><input type="radio" @if(isset($coupon['amount_type'])&&$coupon['amount_type']=="Percentage") checked @elseif(!isset($coupon['amount_type'])) checked @endif name="amount_type" value="Percentage"> &nbsp;Phần Trăm (Percentage)[00.0%]</span>
                    &nbsp;&nbsp;<span><input type="radio" @if(isset($coupon['amount_type'])&&$coupon['amount_type']=="Fixed") checked @endif name="amount_type" value="Fixed"> &nbsp;Cố Định (Fixed)[0.000₫]</span>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="categories">&nbsp;Thể Loại Sản Phẩm Áp Dụng</label>
                    <select name="categories[]" class="form-control select2" multiple="" style="width: 100%;">
                      @foreach($categories as $section)
                        <optgroup label="{{ $section['name'] }}"></optgroup>
                        @foreach($section['categories'] as $category)
                          <option  value="{{ $category['id'] }}" @if(in_array($category['id'], $selCats)) selected @endif> {{ $category['category_name'] }}</option>
                          @foreach($category['subcategories'] as $subcategory)
                            <option  value="{{ $subcategory['id'] }}" @if(in_array($subcategory['id'], $selCats)) selected @endif>&nbsp;&nbsp;---&nbsp;&nbsp;{{ $subcategory['category_name'] }}</option>
                          @endforeach
                        @endforeach
                      @endforeach
                    </select>
                    <p>&nbsp;(Để trống đồng nghĩa với việc coupon sẽ áp dụng cho tất cả thể loại sản phẩm.)<p>
                  </div>
                  <div class="form-group">
                    <label for="users">&nbsp;Khách Hàng Áp Dụng</label>
                    <select name="users[]"  class="form-control select2" multiple="" style="width: 100%;">
                      @foreach($users as $user)
                        <option @if(in_array($user['email'], $selUsers)) selected @endif value="{{ $user['email'] }}">{{ $user['email'] }}</option>
                      @endforeach
                    </select>
                    <p>&nbsp;(Để trống đồng nghĩa với việc coupon sẽ áp dụng cho tất cả khách hàng.)<p>
                  </div>
                  <div class="form-group">
                    <label for="expiry_date">&nbsp;Hạn Sử Dụng @if(empty($coupon['id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control" name="expiry_date" id="expiry_date" placeholder="nhập hạn sử dụng..."
                      @if (!empty($coupon['expiry_date'])) value="{{ $coupon['expiry_date'] }}"
                      @else value="{{ old("expiry_date") }}"
                      @endif data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy/mm/dd" data-mask>
                    </div>  
                  </div>
                  <div class="form-group">
                    <label for="amount">&nbsp;Giá Trị Giảm Giá @if(empty($coupon['id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <input type="number" class="form-control" name="amount" min="1" @if(isset($coupon['amount_type'])&&$coupon['amount_type']=="Percentage") max="100" @endif id="amount"
                    @if (!empty($coupon['amount'])) value="{{ $coupon['amount'] }}"
                    @else value="{{ old("amount") }}"
                    @endif placeholder="nhập giá trị giảm giá...">
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