@extends('layouts.admin_layout.admin_layout')
@section('content')
  <style>
    #dlt-section-img{color: var(--Delete-Red);}
    #dlt-section-img:hover{color: var(--Delete-Red-Hover);}
    .swal2-icon.swal2-warning {border-color:var(--Delete-Red);color:var(--Delete-Red);}
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
              <li class="breadcrumb-item active"><a href="{{ url('admin/sections') }}" id="admin-prev">Danh Mục</a></li>
              <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

     <section class="content">
      <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger" style="color: var(--MinhHung-Red); background-color: #ffffff; border: 1px solid var(--MinhHung-Red)">
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
        <form name="sectionForm" id="SectionForm" 
          @if(empty($sectiondata['id'])) 
            action="{{ url('admin/add-edit-section') }}" 
          @else
            action="{{ url('admin/add-edit-section/'.$sectiondata['id']) }}" 
          @endif
            method="post" enctype="multipart/form-data">@csrf
          <div class="card card-default" style="margin-bottom: 0 !important">
            <div class="card-header">
              <h3 class="card-title">{{ $title }}</h3>
            </div>
            <div class="card-body">
              <div class="row">
                @if(empty($sectiondata['id']))
                <p aria-hidden="true" id="required-description" style="width: 100%;">
                  <label><span aria-hidden="true" class="required">&nbsp;*</span></label> &nbsp;trường nhập bắt buộc
                </p>
                @endif
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="name">&nbsp;Tên Danh Mục Sản Phẩm @if(empty($sectiondata['id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                      <input type="text" class="form-control" name="name" id="name" placeholder="nhập tên..."
                      @if (!empty($sectiondata['name'])) value="{{ $sectiondata['name'] }}"
                      @else value="{{ old("name") }}"
                      @endif>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="section_discount">&nbsp;Giảm Giá toàn Danh Mục @if(empty($sectiondata['id']))(00.0) [%]@endif</label>
                    <input type="number" min="0" step="0.1" max="100" name="section_discount" id="section_discount" class="form-control" id="section_name" placeholder="nhập khoản giảm giá..."
                    @if (!empty($sectiondata['section_discount'])) value="{{ $sectiondata['section_discount'] }}"
                    @else value="{{ old("section_discount") }}"
                    @endif>
                    @if(!empty($sectiondata['section_discount']))
                    <div style="color: grey">&nbsp;&nbsp;giảm giá hiện tại =  {{ $sectiondata['section_discount'] }} [%]</div>
                    @elseif(!empty($sectiondata['id']))
                    <div style="color: grey">&nbsp;&nbsp;giảm giá hiện tại =  0 [%]</div>
                    @endif
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputFile">&nbsp;Hình Ảnh Danh Mục @if(empty($sectiondata['id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="section_image" id="section_image" accept="image/*">
                        <label class="custom-file-label" for="section_image">chọn hình ảnh...</label>
                      </div>
                    </div>
                </div>
                @if(!empty($sectiondata['section_image']))
                  <div style="padding-bottom: 10px"><img style="width: 80px" src="{{ asset('images/section_images/'.$sectiondata['section_image']) }}">
                    &nbsp;&nbsp;<a title="xóa ảnh" class="confirmDelete" href="javascript:void(0)" class="confirmDelete" record="section-image" recordid="{{ $sectiondata['id'] }}" id="dlt-section-img"><i class="fas fa-trash"></i></a>
                  </div>
                @else<div style="color: grey; margin-top: -15px; margin-bottom: 20px">&nbsp;&nbsp;độ phân giải đề xuất (550x605) [px]</div>
                @endif
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="url">URL Danh Mục (tên-danh-mục) @if(empty($sectiondata['id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <input name="url" id="url" type="text" class="form-control" id="category_name" placeholder="nhập URL..."
                    @if (!empty($sectiondata['url'])) value="{{ $sectiondata['url'] }}"
                    @else value="{{ old("url") }}"
                    @endif>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                      <label for="section_description">&nbsp;Mô Tả Danh Mục</label>
                      <textarea name="section_description" id="section_description" class="form-control" rows="3" placeholder="nhập mô tả...">@if (!empty($sectiondata['section_description'])) {{ $sectiondata['section_description'] }}@else {{ old("section_description") }}@endif
                      </textarea>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                      <label for="meta_title">&nbsp;Metadata Title [SEO]</label>
                      <textarea name="meta_title" id="meta_title" class="form-control" rows="3" placeholder="nhập meta title cho SEO...">@if (!empty($sectiondata['meta_title'])) {{ $sectiondata['meta_title'] }}@else {{ old("meta_title") }}@endif
                    </textarea>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                      <label for="meta_keywords">&nbsp;Metadata Keywords [SEO]</label>
                      <textarea name="meta_keywords" id="meta_keywords" class="form-control" rows="3" placeholder="nhập meta keywords cho SEO...">@if (!empty($sectiondata['meta_keywords'])) {{ $sectiondata['meta_keywords'] }}@else {{ old("meta_keywords") }}@endif
                    </textarea>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                      <label for="meta_description">&nbsp;Metadata Description [SEO]</label>
                      <textarea name="meta_description" id="meta_description" class="form-control" rows="3" placeholder="nhập meta description cho SEO...">@if (!empty($sectiondata['meta_description'])) {{ $sectiondata['meta_description'] }}@else {{ old("meta_description") }}@endif
                    </textarea>
                  </div>
                </div>
              </div>
          </div>
        </form>
            <div class="card-footer">
              <button disabled type="submit" class="btn btn-primary" id="admin-btn" style="font-size: 1.0rem;">{{ $title }}</button>
            </div>
            </div>
        
          </div><div style="color: #f4f6f9; font-size: 0.5rem; margin: none; padding: none;">dummy text margin</div>
        </div>
    
      </div>
  
    </section>
  </div>
@endsection