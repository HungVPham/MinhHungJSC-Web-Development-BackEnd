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
                <h3 class="card-title">Cập Nhật Mật Khẩu</h3>
              </div>
              <!-- /.card-header -->
              @if(Session::has('error_message'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="color: var(--MinhHung-Red); background-color: #ffffff; border: 1px solid var(--MinhHung-Red)">
                  {{ Session::get('error_message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              @endif
              @if(Session::has('success_message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="color: #228B22; background-color: #ffffff; border: 1px solid #228B22">
                  {{ Session::get('success_message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              @endif
              <!-- form start -->
              <form role="form" method="post" action="{{ url('/admin/update-current-pwd') }}" name="updatePasswordForm" id="updatePasswordForm" style="border: 1px solid var(--MinhHung-Red)">@csrf
                <div class="card-body">
                  <?php /*<div class="form-group">
                    <label for="exampleInputEmail1">Tên Quản Lý Viên</label>
                    <input type="text" class="form-control" value="{{ $adminDetails->name }}" placeholder="Nhập tên quản lý viên" id="admin_name" name="admin_name">
                  </div> */ ?>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email Quản Lý</label>
                    <input class="form-control" value="{{ $adminDetails->email }}" readonly="">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Loại Quản Lý</label>
                    <input class="form-control" value="{{ $adminDetails->type }}" readonly="">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Mật Khẩu Hiện Tại</label>
                    <input type="password" class="form-control" name="current_pwd" id="current_pwd" placeholder="Nhập mật khẩu hiện tại" required="" oninvalid="this.setCustomValidity('Xin vui lòng điền vào ô trống.')"  oninput="setCustomValidity('')">
                    <!-- <span id="checkCurrentPwd"></span> -->
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Mật Khẩu Mới</label>
                    <input type="password" class="form-control" name="new_pwd" id="new_pwd" placeholder="Nhập mật khẩu mới" required="" oninvalid="this.setCustomValidity('Xin vui lòng điền vào ô trống.')"  oninput="setCustomValidity('')">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Xác Nhận Mật Khẩu Mới</label>
                    <input type="password" class="form-control" name="confirm_pwd" id="confirm_pwd" placeholder="Xác nhận mật khẩu mới" required="" oninvalid="this.setCustomValidity('Xin vui lòng điền vào ô trống.')"  oninput="setCustomValidity('')">
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