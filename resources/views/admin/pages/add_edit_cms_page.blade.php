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
            <h1>Nội Dung</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}" id="admin-home">Trang Chủ</a></li>
              <li class="breadcrumb-item active"><a href="{{ url('admin/cms-pages') }}" id="admin-prev">Các Trang Thông Tin</a></li>
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
        <form name="cmsForm" id="cmsForm" 
          @if(empty($cmspage['id'])) 
            action="{{ url('admin/add-edit-cms-page') }}" 
          @else
            action="{{ url('admin/add-edit-cms-page/'.$cmspage['id']) }}" 
          @endif
            method="post" enctype="multipart/form-data">@csrf
          <div class="card card-default" style="margin-bottom: 0 !important; width: 50%">
            <div class="card-header">
              <h3 class="card-title">{{ $title }}</h3>
            </div>
            <div class="card-body">
              @if(empty($cmspage['id']))
              <p aria-hidden="true" id="required-description" style="width: 100%;">
                <label><span aria-hidden="true" class="required">&nbsp;*</span></label> &nbsp;trường nhập bắt buộc
              </p>
              @endif
              <div class="row">
                  <div class="form-group" style="width: 100%;">
                      <label for="title">&nbsp;Tựa Đề Trang Thông Tin @if(empty($cmspage['id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                      <input type="text" class="form-control" name="title" id="title" placeholder="nhập tên trang thông tin..."
                      @if (!empty($cmspage['title'])) value="{{ $cmspage['title'] }}"
                      @else value="{{ old("title") }}"
                      @endif>
                  </div>
                  <div class="form-group" style="width: 100%;">
                    <label for="description">&nbsp;Mô Tả Nội Dung @if(empty($cmspage['id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <input type="text" class="form-control mce" name="description" id="description" placeholder="nhập mô tả nội dung..."
                    @if (!empty($cmspage['description'])) value="{{ $cmspage['description'] }}"
                    @else value="{{ old("description") }}"
                    @endif>
                </div>
                <div class="form-group" style="width: 100%;">
                    <label for="url">&nbsp;URL Trang Thông Tin (tựa-đề-trang-thông-tin)@if(empty($cmspage['id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <input type="text" class="form-control" name="url" id="url" placeholder="nhập URL..."
                    @if (!empty($cmspage['url'])) value="{{ $cmspage['url'] }}"
                    @else value="{{ old("url") }}"
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