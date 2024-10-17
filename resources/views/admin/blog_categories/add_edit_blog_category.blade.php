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
      color: #333;
    }
    .fa-plus{
      color: #ffffff;
    }
    .fa-plus:hover{
      color: #333;
    }
  </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Blog</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}" id="admin-home">Trang Chủ</a></li>
              <li class="breadcrumb-item active"><a href="{{ url('admin/blog-categories') }}" id="admin-prev">Thể Loại Tin Tức</a></li>
              <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          @if ($errors->any())
            <div class="alert alert-danger" style="color: var(--Delete-Red); background-color: #ffffff; border: 1px solid var(--Delete-Red)">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
        <form name="categoryForm" id="CategoryForm" 
          @if(empty($categorydata['id'])) 
            action="{{ url('admin/add-edit-blog-category') }}" 
          @else
            action="{{ url('admin/add-edit-blog-category/'.$categorydata['id']) }}" 
          @endif
          method="post" enctype="multipart/form-data">@csrf
          <div class="card card-default" style="margin-bottom: 0 !important">
            <div class="card-header">
              <h3 class="card-title">{{ $title }}</h3>
            </div>
            
            <div class="card-body">
              <div class="row"> 
                @if(empty($categorydata['id']))
                <p aria-hidden="true" id="required-description" style="width: 100%;">
                  <label><span aria-hidden="true" class="required">&nbsp;*</span></label> &nbsp;trường nhập bắt buộc
                </p>
                @endif
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="category_name">&nbsp;Tên Thể Loại Tin Tức @if(empty($categorydata['id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                      <input type="text" class="form-control" name="category_name" id="category_name" placeholder="nhập tên..."
                      @if (!empty($categorydata['category_name'])) value="{{ $categorydata['category_name'] }}"
                      @else value="{{ old("category_name") }}"
                      @endif>
                  </div>
                  <div id="appendBlogCategoriesLevel">
                    @include('admin.blog_categories.append_blog_categories_level')
                  </div>
                </div>                        
              </div>
              
              <div class="row">
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                      <label for="url">&nbsp;URL Thể Loại (tên-thể-loại) @if(empty($categorydata['id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                      <input name="url" id="url" type="text" class="form-control" placeholder="nhập URL..."
                      @if (!empty($categorydata['url'])) value="{{ $categorydata['url'] }}"
                      @else value="{{ old("url") }}"
                      @endif>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="category_description">&nbsp;Mô Tả Thể Loại</label>
                    <textarea name="category_description" id="category_description" class="form-control mce" rows="3" placeholder=" nhập mô tả...">@if (!empty($categorydata['category_description'])) {{ $categorydata['category_description'] }}@else {{ old("category_description") }}@endif
                    </textarea>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="meta-title">&nbsp;Metadata Title [SEO]</label>
                    <textarea name="meta_title" id="meta_title" class="form-control" rows="3" placeholder="nhập meta title cho SEO...">@if (!empty($categorydata['meta_title'])) {{ $categorydata['meta_title'] }}@else {{ old("meta_title") }}@endif
                  </textarea>
                </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="meta_keywords">&nbsp;Metadata Keywords [SEO]</label>
                    <textarea name="meta_keywords" id="meta_keywords" class="form-control" rows="3" placeholder="nhập meta keywords cho SEO...">@if (!empty($categorydata['meta_keywords'])) {{ $categorydata['meta_keywords'] }}@else {{ old("meta_keywords") }}@endif
                  </textarea>
                </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="meta_description">&nbsp;Metadata Description [SEO]</label>
                    <textarea name="meta_description" id="meta_description" class="form-control" rows="3" placeholder="nhập meta description cho SEO...">@if (!empty($categorydata['meta_description'])) {{ $categorydata['meta_description'] }}@else {{ old("meta_description") }}@endif
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