@extends('layouts.admin_layout.admin_layout')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <style>    
   .page-item.active .page-link {background-color: var(--MinhHung-Red);border-color: var(--MinhHung-Red)}
    .dropdown-item.active, .dropdown-item:active {background-color: var(--MinhHung-Red)}
    .page-item.active .page-link:focus{box-shadow: none;} 
    .page-item .page-link {color: #333}
    .page-item .page-link:focus{box-shadow: none}
    .swal2-icon.swal2-warning {border-color:var(--Delete-Red);color:var(--Delete-Red);}
    .swal2-icon.swal2-info {border-color:var(--Info-Yellow);color:var(--Info-Yellow);}
    .card-title{
      color: #ffffff;
      font-size: 1.2rem;
    }
    #active:hover{
      color: #4c5158 !important;
    }
    #inactive:hover{
      color: #4c5158 !important;
    }
    #deleteImage{color:var(--Delete-Red)}
    #deleteImage:hover{color: var(--MinhHung-Red-Hover)}
    .col-sm-12.col-md-6{
      display: none !important;
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
              <li class="breadcrumb-item active"><a href="{{ url('admin/blogs') }}" id="admin-prev">Blog</a></li>
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
            <div class="alert alert-danger" style="color: #cb1c22; background-color: #ffffff; border: 1px solid #cb1c22">
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
        @if (Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="color: var(--Delete-Red); background-color: #ffffff; border: 1px solid var(--Delete-Red);">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;●&nbsp;&nbsp;{{ Session::get('error_message') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span style="color: var(--Delete-Red);" aria-hidden="true">&times;</span>
              </button>
            </div>
        @endif
        <form name="addImageForm" id="addImageForm" 
          method="post" action="{{ url('admin/blogs/add-images/'.$blogdata['id']) }}" enctype="multipart/form-data">@csrf
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">{{ $title }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                    <div class="col-md-6">
                      <div style="display: flex; align-items: center; justify-content: center;">
                        <div class="form-group">
                            @if(!empty($blogdata['main_image']))
                            <img style="width: 640px" name="main_image" id="main_image" src="{{ asset('images/blogs_images/main_image/large/'.$blogdata['main_image']) }}">
                            @else
                            <img name="main_image" id="main_image" src="{{ asset('images/blogs_images/main_image/small/no-img.jpg') }}">
                            @endif
                            <div style="display: flex; align-items: center; justify-content: center; padding-top: 10px; padding-bottom: 10px;">
                            <label style="display: block;" for="main_image">Hình Ảnh Bìa (Cấp 0)</label>
                            </div>
                        </div>
                      </div>
                        <div class="form-group">
                            <label for="product_name">&nbsp;Tiêu đề:<p style="display: inline; font-weight: lighter;">&nbsp;{{ $blogdata['title'] }}</p></label>
                        </div>
                        <div class="form-group">
                            <label for="product_code">&nbsp;Người Viết: <p style="display: inline; font-weight: lighter;">&nbsp;{{ $blogdata['author'] }}</p></label>
                        </div>
                        <div class="form-group">
                            <label for="product_weight">&nbsp;Ngày Đăng: <p style="display: inline; font-weight: lighter;">&nbsp;{{ date('d-m-Y', strtotime($blogdata['posted_on'])) }}</p></label>
                        </div>
                        <div class="form-group">
                            <div class="field_wrapper1">
                              <div class="custom-file">
                                <input required class="custom-file-input" multiple="" id="images" name="images[]" type="file" accept="image/*"/>
                                <label class="custom-file-label" for="images">chọn hình ảnh...</label>
                              </div>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; justify-content: center;">
                        <button type="submit" class="btn btn-primary" id="admin-btn" style="font-size: 1.0rem;">Thêm Hình Ảnh (Cấp 1)</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                      <table id="example1"  class="table table-bordered table-striped">
                        <label>Danh sách ảnh cấp (1)</label>
                        <thead>
                        <tr>
                          {{-- <th>ID</th> --}}
                          <th style="text-align: center;">Hình Ảnh</th>
                          <th>Trạng Thái</th>
                          <th style="width: 50px;">Hành Động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($blogdata['images'] as $image)
                        <tr>
                          {{-- <td>{{ $image['id'] }}</td> --}}
                          <td style="text-align: center;">
                            <img style="width: 340px;" src="{{ asset('images/blogs_images/main_image/small/'.$image['image']) }}">
                          </td>
                          <td style="width: 135px;">
                              @if ($image['status']==1)
                              <a class="updateBlogImageStatus" id="Image-{{ $image['id'] }}" Image_id="{{ $image['id'] }}" href="javascript:void(0)" style="color: var(--Positive-Green);"><i id="active" style="color: var(--Positive-Green); font-size: 1.05rem;"  class="fas fa-toggle-on" aria-hidden="true"> đang hoạt động</i></a>   
                              @elseif ($image['status']==0)
                              <a class="updateBlogImageStatus" id="Image-{{ $image['id'] }}" Image_id="{{ $image['id'] }}" href="javascript:void(0)" style="color: var(--Delete-Red);"><i id="inactive" style="color: var(--Delete-Red); font-size: 1.05rem;" class="fas fa-toggle-off" aria-hidden="true"> chưa hoạt động</i></a> 
                              @endif
                          </td>
                          <td style="width: 50px;">
                              <a title="xóa hình ảnh cấp (1)" href="javascript:void(0)" class="confirmDelete" record="blog-sec-image" recordid="{{ $image['id'] }}" id="deleteImage"><i class="fas fa-trash"></i></a>
                          </td>
                        </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>
                </div>
            </div>
        </form>
              <!-- /.card-body -->
          
            </div>

            {{-- <form name="editImageForm" id="editImageForm" method="post" action="{{ url('admin/edit-images/'.$blogdata['id']) }}" enctype="multipart/form-data">@csrf --}}
                <!-- /.card-header -->
                <!-- /.card-body -->
                {{-- <div class="card-footer">
                  <button type="submit" class="btn btn-primary" id="admin-btn" style="font-size: 1.0rem;">Cập Nhật SP (Cấp 1)</button>
                </div> --}}


              </div><div style="color: #f4f6f9; font-size: 0.5rem; margin: none; padding: none;">dummy text margin</div>
            {{-- </form> --}}
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection