@extends('layouts.admin_layout.admin_layout')
@section('content')
<style>
    #admin-btn{
        font-size: 1.0rem;
    }
    .card-header{
      background-color: var(--MinhHung-Red) !important;
    }
</style>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Cài Đặt</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}" id="admin-home">Trang Chủ</a></li>
              <li class="breadcrumb-item active">Cài Đặt Tài Khoản</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

 <!-- Main content -->
 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Cập Nhật Thông Tin</h3>
              </div>
              <!-- /.card-header -->
                @if(Session::has('error_message'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                  {{ Session::get('error_message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @endif
                @if(Session::has('success_message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="color: var(--Positive-Green); background-color: #ffffff; border: 1px solid var(--Positive-Green); margin-top: 10px;">
                  {{ Session::get('success_message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger" style="color: var(--MinhHung-Red); background-color: #ffffff; border: 1px solid var(--Delete-Red)">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    </div>
                @endif
              <!-- form start -->
              <form role="form" method="post" action="{{ url('/admin/update-admin-details') }}" name="updateAdminDetails" id="updateAdminDetails" style="border: 1px solid var(--MinhHung-Red)" enctype="multipart/form-data">@csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">&nbsp;Email Quản Lý</label>
                    <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">&nbsp;Loại Quản Lý</label>
                    <input class="form-control" value="{{ Auth::guard('admin')->user()->type }}" readonly="">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">&nbsp;Tên Quản Lý</label>
                    <input type="text" class="form-control" name="admin_name" id="admin_name" placeholder="Nhập tên quản lý" value="{{ Auth::guard('admin')->user()->name }}" required="" oninvalid="this.setCustomValidity('Xin vui lòng điền vào ô trống.')"  oninput="setCustomValidity('')">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">&nbsp;Số Điện Thoại</label>
                    <input type="text" class="form-control" name="admin_mobile" id="admin_mobile" placeholder="Nhập số điện thoại" value="{{ Auth::guard('admin')->user()->mobile }}" required="" oninvalid="this.setCustomValidity('Xin vui lòng điền vào ô trống.')"  oninput="setCustomValidity('')">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">&nbsp;Hình Ảnh Đại Diện</label>
                    <div class="custom-file">
                    <input class="custom-file-input" type="file" name="admin_image" id="admin_image" accept="image/*">
                    <label class="custom-file-label" for="main_image">chọn hình ảnh...</label>
                    </div>
                    @if(!empty(Auth::guard('admin')->user()->image))
                      <a id="AdminPhotoNav" target="_blank" href=" {{ url('images/admin_images/admin_photos/'.Auth::guard('admin')->user()->image) }}">&nbsp;Xem ảnh</a>
                      <input type="hidden" name="current_admin_image" value="{{ Auth::guard('admin')->user()->image }}">
                    @endif
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" id="admin-btn">Cập Nhật</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @endsection