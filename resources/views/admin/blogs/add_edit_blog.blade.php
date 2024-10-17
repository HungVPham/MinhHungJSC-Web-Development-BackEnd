@extends('layouts.admin_layout.admin_layout')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <style>
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
    #dlt-blog-img{color: var(--Delete-Red);}
    #dlt-blog-img:hover{color: var(--Delete-Red-Hover);}
    /* #dlt-blog-vid{color: var(--Delete-Red);}
    #dlt-blog-vid:hover{color: var(--Delete-Red-Hover);} */
    .swal2-icon.swal2-warning {border-color:var(--Delete-Red);color:var(--Delete-Red);}
    /* #download-video-btn{color: var(--Positive-Green);}
    #download-video-btn:hover{color: var(--Positive-Green-Hover);} */
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
              <li class="breadcrumb-item active"><a href="{{ url('admin/blogs') }}" id="admin-prev">Bài Viết</a></li>
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
            <div class="alert alert-danger" style="color: var(--MinhHung-Red); background-color: #ffffff; border: 1px solid var(--MinhHung-Red)">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
        @endif
        @if (Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="color: var(--Positive-Green); background-color: #ffffff; border: 1px solid var(--Positive-Green)">
              {{ Session::get('success_message') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        @endif
        <form name="blogForm" id="BlogBlogForm" 
          @if(empty($blogData['id'])) 
            action="{{ url('admin/add-edit-blog') }}" 
          @else
            action="{{ url('admin/add-edit-blog/'.$blogData['id']) }}" 
          @endif
          method="post" enctype="multipart/form-data">@csrf
          <div class="card card-default" style="margin-bottom: 0 !important">
            <div class="card-header">
              <h3 class="card-title">{{ $title }}</h3>
            </div>
            <div class="card-body">
              <div class="row">
                @if(empty($blogData['section_id']))
                <p aria-hidden="true" id="required-description" style="width: 100%;">
                  <label><span aria-hidden="true" class="required">&nbsp;*</span></label> &nbsp;trường nhập bắt buộc
                </p>
                @endif
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="category_id">&nbsp;Thể Loại @if(empty($blogData['category_id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <select name="category_id" id="category_id" class="form-control select2" style="width: 100%;">
                      <option value="">chọn thể loại...</option>
                        @foreach($categories as $category)
                          @if($category['parent_id']==0)
                          <option  value="{{ $category['id'] }}" @if(!empty(@old('category_id')) && $category['id'] ==@old('category_id')) selected=""@elseif(!empty($blogData['category_id']) && $blogData['category_id']==$category['id']) selected="" @endif> {{ $category['category_name'] }}</option>
                          @endif
                          @foreach($category['subcategories'] as $subcategory)
                            <option  value="{{ $subcategory['id'] }}" @if(!empty(@old('category_id')) && $subcategory['id'] ==@old('category_id')) selected=""@elseif(!empty($blogData['category_id']) && $blogData['category_id']==$subcategory['id']) selected="" @endif>&nbsp;&nbsp;---&nbsp;&nbsp;{{ $subcategory['category_name'] }}</option>
                          @endforeach
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="title">&nbsp;Tiêu Đề Bài Viết @if(empty($blogData['title']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="nhập tiêu đề..."
                    @if (!empty($blogData['title'])) value="{{ $blogData['title'] }}"
                    @else value="{{ old("title") }}"
                    @endif>
                  </div>
           
                 
                  {{-- <div class="form-group">
                    <label for="main_image">&nbsp;Hình Ảnh (Cấp 0)</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="main_image" id="main_image" accept="image/*">
                        <label class="custom-file-label" for="main_image">chọn hình ảnh...</label>
                      </div>
                    </div>
                    @if(!empty($blogData['section_id']))
                      @if(!empty($blogData['main_image']))
                      <div style="padding-top: 10px;"><p>&nbsp;(Người dùng nên xóa ảnh cũ trước khi thêm ảnh mới để tối ưu hóa dung lượng.)<p><img style="width: 80px" src="{{ asset('images/product_images/main_image/small/'.$blogData['main_image']) }}">
                        &nbsp;&nbsp;<a title="xóa ảnh" class="confirmDelete" href="javascript:void(0)" class="confirmDelete" record="blog-image" recordid="{{ $blogData['id'] }}" id="dlt-blog-img"><i class="fas fa-trash"></i></a>
                      </div>
                      @endif
                    @else<div style="color: grey">&nbsp;&nbsp;độ phân giải đề xuất (750x650) [px]</div>
                    @endif
                  </div> --}}

                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="author">&nbsp;Tác Giả @if(empty($blogData['author']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <input type="text" class="form-control" name="author" id="author" placeholder="nhập tên người viết..."
                    @if (!empty($blogData['author'])) value="{{ $blogData['author'] }}"
                    @else value="{{ old("author") }}"
                    @endif>
                  </div>
                  <div class="form-group">
                    <label for="posted_on">&nbsp;Ngày Đăng @if(empty($blogData['posted_on']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control" name="posted_on" id="posted_on" placeholder="nhập ngày đăng..."
                      @if (!empty($blogData['posted_on'])) value="{{ $blogData['posted_on'] }}"
                      @else value="{{ old("posted_on") }}"
                      @endif data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy/mm/dd" data-mask>
                    </div>  
                  </div>
                  {{-- <div class="form-group">
                    <label for="exampleInputFile">&nbsp;Video Demo Bài Viết</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="product_video" id="product_video" accept="video/mp4,video/x-m4v,video/*">
                        <label class="custom-file-label" for="product_video">chọn video...</label>
                      </div>
                    </div>
                    @if(!empty($blogData['product_video']))
                      <div style="color: grey;">&nbsp;&nbsp;tải hoặc xóa video hiện tại:&nbsp;&nbsp;<a title="tải video" id="download-video-btn" href="{{ url('videos/product_videos/'.$blogData['product_video']) }}" download><i class="fas fa-file-video"></i></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a class="confirmDelete" href="javascript:void(0)" class="confirmDelete" title="xóa video" record="blog-video" recordid="{{ $blogData['id'] }}" id="dlt-blog-vid"><i class="fas fa-trash"></i></a></div>
                    @endif
                  </div> --}}
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="content">&nbsp;Nội Dung @if(empty($blogData['content']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <textarea name="content" id="content" class="form-control mce" rows="3" placeholder=" nhập nội dung...">@if (!empty($blogData['content'])) {{ $blogData['content'] }}@else {{ old("content") }}@endif
                    </textarea>
                  </div>
                </div>
                <div class="col-md-6" style="display: flex; flex-direction: column;">

                  <div class="form-group">
                    <label for="main_image">&nbsp;Hình Ảnh Bìa (Cấp 0)</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="main_image" id="main_image" accept="image/*">
                        <label class="custom-file-label" for="main_image">chọn hình ảnh...</label>
                      </div>
                    </div>
                      @if(!empty($blogData['main_image']))
                      <div style="padding-top: 10px;"><p>&nbsp;(Người dùng nên xóa ảnh cũ trước khi thêm ảnh mới để tối ưu hóa dung lượng.)<p><img style="width: 180px" src="{{ asset('images/blogs_images/main_image/small/'.$blogData['main_image']) }}">
                        &nbsp;&nbsp;<a title="xóa ảnh" class="confirmDelete" href="javascript:void(0)" class="confirmDelete" record="blog-image" recordid="{{ $blogData['id'] }}" id="dlt-blog-img"><i class="fas fa-trash"></i></a>
                      </div>
                      @else<div style="color: grey">&nbsp;&nbsp;độ phân giải đề xuất (1280x720) [px]</div>
                      @endif
                   
                  </div>

                

                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">

                  <div class="form-group">
                    <label for="meta_description">&nbsp;Metadata Description [SEO]</label>
                    <textarea name="meta_description" id="meta_description" class="form-control" rows="3" placeholder="nhập meta description cho SEO...">@if (!empty($blogData['meta_description'])) {{ $blogData['meta_description'] }}@else {{ old("meta_description") }}@endif
                    </textarea>
                  </div>

                  <div class="form-group">
                    <label for="meta_keywords">&nbsp;Metadata Keywords [SEO]</label>
                    <textarea name="meta_keywords" id="meta_keywords" class="form-control" rows="3" placeholder="nhập meta keywords cho SEO...">@if (!empty($blogData['meta_keywords'])) {{ $blogData['meta_keywords'] }}@else {{ old("meta_keywords") }}@endif
                  </textarea>
                </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="meta-title">&nbsp;Metadata Title [SEO]</label>
                    <textarea name="meta_title" id="meta_title" class="form-control" rows="3" placeholder="nhập meta title cho SEO...">@if (!empty($blogData['meta_title'])) {{ $blogData['meta_title'] }}@else {{ old("meta_title") }}@endif
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