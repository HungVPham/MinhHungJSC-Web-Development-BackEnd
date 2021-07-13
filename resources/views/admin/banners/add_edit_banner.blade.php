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
            <h1>Catalogue</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}" id="admin-home">Trang Chủ</a></li>
              <li class="breadcrumb-item active"><a href="{{ url('admin/banners') }}" id="admin-prev">Banner</a></li>
              <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger" style="color: var(--MinhHung-Red); background-color: #ffffff; border: 1px solid var(--MinhHung-Red); width: 50%;">
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
        <form name="bannerForm" id="BannerForm" 
          @if(empty($banner['id'])) 
            action="{{ url('admin/add-edit-banner') }}" 
          @else
            action="{{ url('admin/add-edit-banner/'.$banner['id']) }}" 
          @endif
            method="post" enctype="multipart/form-data">@csrf
          <div class="card card-default" style="margin-bottom: 0 !important; width: 50%">
            <div class="card-header">
              <h3 class="card-title">{{ $title }}</h3>
            </div>
            <div class="card-body">
              @if(empty($banner['id']))
              <p aria-hidden="true" id="required-description" style="width: 100%;">
                <label><span aria-hidden="true" class="required">&nbsp;*</span></label> &nbsp;trường nhập bắt buộc
              </p>
              @endif
              <div class="row" style="display: block">
                <div class="form-group" style="width: 100%;">
                  <label for="is_main">&nbsp;Banner Chính: Có/Không</label>
                  <input type="checkbox" name="is_main" id="is_main" value="Yes" @if(!empty($banner['is_main']) && $banner['is_main']=="Yes") checked="" @endif>
                </textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">&nbsp;Hình Ảnh Banner @if(empty($banner['id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="image" id="image" accept="image/*" @if(empty($banner['image'])) required @endif>
                      <label class="custom-file-label" for="image">chọn hình ảnh...</label>
                    </div>
                  </div>
                  @if(!empty($banner['image']))
                  <div style="padding-top: 10px;"><img style="width: 200px; height: 100px" src="{{ asset('images/banner_images/'.$banner['image']) }}">
                  </div>
                  @else<div style="color: grey">&nbsp;&nbsp;độ phân giải đề xuất (1850x740) [px]</div>
                  @endif
                </div>
                <div class="form-group" style="width: 100%;">
                  <label for="link">&nbsp;Link Đường Dẫn</label>
                  <input type="text" class="form-control" name="link" id="link" placeholder="nhập đường dẫn..."
                  @if (!empty($banner['link'])) value="{{ $banner['link'] }}"
                  @else value="{{ old("link") }}"
                  @endif>
                </div>
                <div class="form-group" style="width: 100%;">
                  <label for="title">&nbsp;Hành Động Con Trỏ</label>
                  <input type="text" class="form-control" name="title" id="title" placeholder="nhập hành động..."
                  @if (!empty($banner['title'])) value="{{ $banner['title'] }}"
                  @else value="{{ old("title") }}"
                  @endif>
                </div>
                @if (($banner['is_main'])=='Yes')
                <label>&nbsp;Thông Điệp (Giá Trị Cốt Lõi) Của Công Ty</label>
                <div style="padding-top: 10px; padding-bottom: 10px; text-align: center;"><img style="width: 400px;" src="{{ asset('images/admin_images/example-text-assignment.jpg') }}"></div>
                  <div style="display: flex; justify-content: center;">
                    <div class="form-group" style="width: 30%;">
                      <label for="bRed_1">&nbsp;1</label>
                      <input type="text" class="form-control" name="bRed_1" id="bRed_1"
                      @if (!empty($banner['bRed_1'])) value="{{ $banner['bRed_1'] }}"
                      @else value="{{ old("bRed_1") }}"
                      @endif>
                    </div>
                    <div class="form-group" style="width: 30%; margin-left: 5px">
                      <label for="nBlack_1">&nbsp;2</label>
                      <input type="text" class="form-control" name="nBlack_1" id="nBlack_1"
                      @if (!empty($banner['nBlack_1'])) value="{{ $banner['nBlack_1'] }}"
                      @else value="{{ old("nBlack_1") }}"
                      @endif>
                    </div>
                    <div class="form-group" style="width: 30%;  margin-left: 5px">
                      <label for="bRed_2">&nbsp;3</label>
                      <input type="text" class="form-control" name="bRed_2" id="bRed_2"
                      @if (!empty($banner['bRed_2'])) value="{{ $banner['bRed_2'] }}"
                      @else value="{{ old("bRed_2") }}"
                      @endif>
                    </div>
                  </div>
                  <div style="display: flex; justify-content: center;">
                    <div class="form-group" style="width: 30%;  margin-left: 5px">
                      <label for="bRed_3">&nbsp;4</label>
                      <input type="text" class="form-control" name="bRed_3" id="bRed_3"
                      @if (!empty($banner['bRed_3'])) value="{{ $banner['bRed_3'] }}"
                      @else value="{{ old("bRed_3") }}"
                      @endif>
                    </div>
                    <div class="form-group" style="width: 30%;  margin-left: 5px">
                      <label for="nBlack_2">&nbsp;5</label>
                      <input type="text" class="form-control" name="nBlack_2" id="nBlack_2"
                      @if (!empty($banner['nBlack_2'])) value="{{ $banner['nBlack_2'] }}"
                      @else value="{{ old("nBlack_2") }}"
                      @endif>
                    </div>
                    <div class="form-group" style="width: 30%;  margin-left: 5px">
                      <label for="bRed_4">&nbsp;6</label>
                      <input type="text" class="form-control" name="bRed_4" id="bRed_4"
                      @if (!empty($banner['bRed_4'])) value="{{ $banner['bRed_4'] }}"
                      @else value="{{ old("bRed_4") }}"
                      @endif>
                    </div>
                  </div>
                @endif
                <div class="form-group" style="width: 100%;">
                  <label for="alt">&nbsp;Thẻ ALT [SEO]</label>
                  <input type="text" class="form-control" name="alt" id="alt"
                  @if (!empty($banner['alt'])) value="{{ $banner['alt'] }}"
                  @else value="{{ old("alt") }}"
                  @endif>
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