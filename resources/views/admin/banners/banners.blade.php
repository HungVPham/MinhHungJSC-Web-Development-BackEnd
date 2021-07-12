@extends('layouts.admin_layout.admin_layout')
@section('content')
<style>
    .page-item.active .page-link {background-color: var(--MinhHung-Red);border-color: var(--MinhHung-Red);}
    .page-item.active .page-link:focus{box-shadow: none;} 
    .dropdown-item.active, .dropdown-item:active {background-color: var(--MinhHung-Red);}
    .page-item .page-link {color: #333}
    .page-item .page-link:focus{box-shadow: none}
    .updateBannerStatus:hover{color: #4c5158 !important}
    #admin-btn{max-width: 180px; float: right; display: inline-block; background-color: var(--MinhHung-Red); border-color: var(--MinhHung-Red); font-size: 1.0rem}
    #deleteBanner{color:var(--Delete-Red)}
    #deleteBanner:hover{color: var(--MinhHung-Red-Hover)}
    #updateBanner{color: #000000;}
    #updateBanner:hover{color:#4c5158;}
    a{color: inherit}
    .swal2-icon.swal2-warning {border-color:var(--Delete-Red);color:var(--Delete-Red);}
    .swal2-icon.swal2-info {border-color:var(--Info-Yellow);color:var(--Info-Yellow);}
    .card-title{
      font-size: 1.3rem;
    }
    b{
      font-weight: 600;
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
            <h1>Hình Thức</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}" id="admin-home">Trang Chủ</a></li>
              <li class="breadcrumb-item active">Banner</li>
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
                <h3 class="card-title">Banner</h3>
                <a href="{{ url('admin/add-edit-banner') }}" class="btn btn-block btn-success" id="admin-btn">Thêm Banner</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Ảnh Banner</th>
                    <th>Link Điểm Đến</th>
                    <th>Cấp Banner</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($banners as $banner)
                  <tr>
                    <td>{{ $banner['id'] }}</td>
                    <td style="text-align: center">
                      <img width="200px" height="100px" src="{{ asset('images/banner_images/'.$banner['image']) }}">
                    </td>
                    <td>{{ $banner['link'] }}</td>
                    <td>
                        @if ($banner['is_main']=="Yes")
                        banner chính
                        @else
                        banner phụ
                        @endif
                    </td>
                    <td style="width: 135px;">
                      @if ($banner['status']==1)
                      <a class="updateBannerStatus" id="banner-{{ $banner['id'] }}" banner_id="{{ $banner['id'] }}" href="javascript:void(0)"><i id="active"  status="Active" style="color: var(--Positive-Green); font-size: 1.05rem;" class="fas fa-toggle-on" aria-hidden="true"> đang hoạt động</i></a>   
                      @elseif ($banner['status']==0)
                      <a class="updateBannerStatus" id="banner-{{ $banner['id'] }}" banner_id="{{ $banner['id'] }}" href="javascript:void(0)"><i id="inactive" status="Inactive" style="color: var(--Delete-Red); font-size: 1.05rem;" class="fas fa-toggle-off" aria-hidden="true"> chưa hoạt động</i></a> 
                      @endif
                    </td>
                    <td style="width: 50px;">
                      <a title="sửa banner" id="updateBanner" href="{{ url('admin/add-edit-banner/'.$banner['id']) }}"><i class="fas fa-edit"></i></a>
                      &nbsp; &nbsp;<a title="xóa banner" href="javascript:void(0)" class="confirmDelete" record="banner" recordid="{{ $banner['id'] }}"  class="confirmDelete" id="deleteBanner"><i class="fas fa-trash"></i></a>
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