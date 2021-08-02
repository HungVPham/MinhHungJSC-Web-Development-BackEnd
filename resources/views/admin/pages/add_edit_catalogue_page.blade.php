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
    #downloadFile{color: var(--Positive-Green);}
    #downloadFile:hover{color: var(--Positive-Green-Hover);}
    #dltFile{color: var(--Delete-Red);}
    #dltFile:hover{color: var(--Delete-Red-Hover);}
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
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}" id="admin-home">Chủ</a></li>
              <li class="breadcrumb-item active"><a href="{{ url('admin/catalogue-pages') }}" id="admin-prev">Booklet Catalogue</a></li>
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
        <form name="catalogueForm" id="catalogueForm" 
          @if(empty($cataloguepage['id'])) 
            action="{{ url('admin/add-edit-catalogue-page') }}" 
          @else
            action="{{ url('admin/add-edit-catalogue-page/'.$cataloguepage['id']) }}" 
          @endif
            method="post" enctype="multipart/form-data">@csrf
          <div class="card card-default" style="margin-bottom: 0 !important;">
            <div class="card-header">
              <h3 class="card-title">{{ $title }}</h3>
            </div>
            <div class="card-body">
              @if(empty($cataloguepage['id']))
              <p aria-hidden="true" id="required-description">
                <label><span aria-hidden="true" class="required">&nbsp;*</span></label> &nbsp;trường nhập bắt buộc
              </p>
              @endif
              <div class="row">
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                      <label for="title">&nbsp;Tựa Đề Booklet Catalogue @if(empty($cataloguepage['id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                      <input type="text" class="form-control" name="title" id="title" placeholder="nhập tựa đề booklet catalogue..."
                      @if (!empty($cataloguepage['title'])) value="{{ $cataloguepage['title'] }}"
                      @else value="{{ old("title") }}"
                      @endif>
                  </div>
                  <div class="form-group">
                    <label for="image">&nbsp;File PDF cho Booklet Catalogue @if(empty($cataloguepage['id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="file_path" @if(empty($cataloguepage['file_path'])) required @endif placeholder="Choose file" id="file_path">
                        <label class="custom-file-label" for="image">chọn file pdf...</label>
                      </div>
                    </div>
                    @if(!empty($cataloguepage['file_path']))<p>&nbsp;(Người dùng nên xóa file cũ trước khi thêm file mới để tối ưu hóa dung lượng.)<p><p style="margin-top: -15px"><span>&nbsp;File Hiện Tại:</span><a title="tải file pdf" id="downloadFile" href="{{ url('files/catalogues/'.$cataloguepage['file_path']) }}"> {{ $cataloguepage['file_path'] }}</a>&nbsp;&nbsp; | &nbsp;&nbsp;<a class="confirmDelete" href="javascript:void(0)" class="confirmDelete" title="xóa file pdf" record="catalogue-file" recordid="{{ $cataloguepage['id'] }}" id="dltFile"><i class="fas fa-trash"></i></a></p>@endif
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="url">&nbsp;URL Booklet Catalogue (booklet-tựa-đề-nhóm-sản-phẩm)@if(empty($cataloguepage['id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <input type="text" class="form-control" name="url" id="url" placeholder="nhập URL..."
                    @if (!empty($cataloguepage['url'])) value="{{ $cataloguepage['url'] }}"
                    @else value="{{ old("url") }}"
                    @endif>
                  </div>
                  <div class="form-group" style="width: 100%">
                    <label for="description">&nbsp;Miêu Tả Ngắn</label>
                    <input type="text" class="form-control" name="description" id="description" placeholder="nhập nội dung..."
                    @if (!empty($cataloguepage['description'])) value="{{ $cataloguepage['description'] }}"
                    @else value="{{ old("description") }}"
                    @endif>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <label for="meta_description">&nbsp;Metadata Description [SEO]</label>
                      <textarea name="meta_description" id="meta_description" class="form-control" rows="3" placeholder="nhập meta description cho SEO...">@if (!empty($cataloguepage['meta_description'])) {{ $cataloguepage['meta_description'] }}@else {{ old("meta_description") }}@endif
                    </textarea>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="meta_keywords">&nbsp;Metadata Keywords [SEO]</label>
                    <textarea name="meta_keywords" id="meta_keywords" class="form-control" rows="3" placeholder="nhập meta keywords cho SEO...">@if (!empty($cataloguepage['meta_keywords'])) {{ $cataloguepage['meta_keywords'] }}@else {{ old("meta_keywords") }}@endif
                  </textarea>
                </div>
              </div>
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label for="meta_title">&nbsp;Metadata Title [SEO]</label>
                  <textarea name="meta_title" id="meta_title" class="form-control" rows="3" placeholder="nhập meta title cho SEO...">@if (!empty($cataloguepage['meta_title'])) {{ $cataloguepage['meta_title'] }}@else {{ old("meta_title") }}@endif
                </textarea>
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