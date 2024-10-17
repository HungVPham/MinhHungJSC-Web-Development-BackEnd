@extends('layouts.admin_layout.admin_layout')
@section('content')

<style>
    .page-item.active .page-link {background-color: var(--MinhHung-Red);border-color: var(--MinhHung-Red)}
    .page-item.active .page-link:focus{box-shadow: none;} 
    .dropdown-item.active, .dropdown-item:active {background-color: var(--MinhHung-Red)}
    .page-item .page-link {color: #333}
    .page-item .page-link:focus{box-shadow: none}
    #admin-btn{max-width: 150px; float: right; display: inline-block; background-color: var(--MinhHung-Red); border-color: var(--MinhHung-Red); font-size: 1.0rem}
    .updateBlogStatus:hover{color: #4c5158 !important}
    #deleteBlog{color:var(--Delete-Red)}
    #deleteBlog:hover{color: var(--MinhHung-Red-Hover)}
    #updateBlog{color: #000000;}
    #updateBlog:hover{color: #4c5158;}
    a{color: inherit;}
    .swal2-icon.swal2-warning {border-color:var(--Delete-Red);color:var(--Delete-Red);}
    .swal2-icon.swal2-info {border-color:var(--Info-Yellow);color:var(--Info-Yellow);}
    .card-title{
      font-size: 1.3rem;
    }
    #active:hover{
      color: #4c5158 !important;
    }
    #inactive:hover{
      color: #4c5158 !important;
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
              <li class="breadcrumb-item active">Blog</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- /.card -->
            @if(Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert" style="color: #228B22; background-color: #ffffff; border: 1px solid #228B22">
                {{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Blog</h3>
                <a href="{{ url('admin/add-edit-blog') }}" class="btn btn-block btn-success"  id="admin-btn">Thêm Blog</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Tiêu Đề</th>
                    <th>Ảnh Bìa (cấp 0)</th>
                    <th>Tác Giả</th>
                    <th>Thể Loại</th>
                    <th>Ngày Đăng</th>
                    <th>Trạng Thái</th>
                    <th>Điều Khiển</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($blogs as $blog)
                  <tr>
                    <td>{{ $blog->id }}</td>
                    <td>{{ $blog->title }}</td>
                    <td style="text-align: center;">
                      <?php $blog_image_path = "images/blogs_images/main_image/small/".$blog->main_image; ?>
                      @if(!empty($blog->main_image) && file_exists($blog_image_path))
                      <img style="width: 180px;" src="{{ asset('images/blogs_images/main_image/small/'.$blog->main_image) }}">
                       @else
                      <img style="width: 180px;" src="{{ asset('images/blogs_images/main_image/small/no-img.jpg') }}">
                      @endif
                    </td>
                    <td>{{ $blog->author }}</td>
                    <td>{{ $blog->category->category_name }}</td>
                    <td>{{ date('d-m-Y', strtotime($blog->posted_on)) }}</td>
                    <td style="width: 135px;">
                        @if ($blog->status==1)
                        <a class="updateBlogStatus" id="blog-{{ $blog->id }}" blog_id="{{ $blog->id }}" href="javascript:void(0)" style="color: var(--Positive-Green);"><i id="active" style="color: var(--Positive-Green); font-size: 1.05rem;"  class="fas fa-toggle-on" aria-hidden="true"> đang hoạt động</i></a>   
                        @elseif ($blog->status==0)
                        <a class="updateBlogStatus" id="blog-{{ $blog->id }}" blog_id="{{ $blog->id }}" href="javascript:void(0)" style="color: var(--Delete-Red);"><i id="inactive" style="color: var(--Delete-Red); font-size: 1.05rem;" class="fas fa-toggle-off" aria-hidden="true"> chưa hoạt động</i></a> 
                        @endif
                    </td>
                    <td style="width: 95px;">
                      &nbsp;&nbsp;<a title="thêm hình ảnh (cấp 1) cho bài viết" id="updateBlog" href="{{ url('admin/blogs/add-images/'.$blog->id) }}"><i class="fas fa-images"></i></a> 
                      &nbsp;&nbsp;<a title="sửa bài viết" id="updateBlog" href="{{ url('admin/add-edit-blog/'.$blog->id) }}"><i class="fas fa-edit"></i></a>
                      &nbsp;&nbsp;<a title="xóa bài viết" href="javascript:void(0)" class="confirmDelete" record="blog" recordid="{{ $blog->id }}" id="deleteBlog"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection