@extends('layouts.admin_layout.admin_layout')
@section('content')
<style>
    .page-item.active .page-link {background-color: var(--MinhHung-Red);border-color: var(--MinhHung-Red);}
    .page-item.active .page-link:focus{box-shadow: none;} 
    .dropdown-item.active, .dropdown-item:active {background-color: var(--MinhHung-Red);}
    .page-item .page-link {color: #333}
    .page-item .page-link:focus{box-shadow: none}
    .updateSectionStatus:hover{color: #4c5158 !important}
    #admin-btn{max-width: 180px; float: right; display: inline-block; background-color: var(--MinhHung-Red); border-color: var(--MinhHung-Red); font-size: 1.0rem}
    #deleteSection{color:var(--Delete-Red)}
    #deleteSection:hover{color: var(--MinhHung-Red-Hover)}
    #updateSection{color: #000000;}
    #updateSection:hover{color:#4c5158;}
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
            <h1>Catalogue</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}" id="admin-home">Trang Chủ</a></li>
              <li class="breadcrumb-item active">Danh Mục SP</li>
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
                <h3 class="card-title">Danh Mục Sản Phẩm</h3>
                <a href="{{ url('admin/add-edit-section') }}" class="btn btn-block btn-success" id="admin-btn" disabled="">Thêm Danh Mục SP</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Danh Mục</th>
                    <th>Hình Ảnh</th>
                    <th>URL</th>
                    <th>Trạng Thái</th>
                    <th>Điều Khiển</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($sections as $section)
                  <tr>
                    <td>{{ $section->id }}</td>
                    <td>{{ $section->name }}</td>
                    <td style="text-align: center;">
                      <?php $section_image_path = "images/section_images/".$section->section_image; ?>
                      @if(!empty($section->section_image) && file_exists($section_image_path))
                      <img style="width: 150px;" src="{{ asset('images/section_images/'.$section->section_image) }}">
                       @else
                      <img style="width: 150px;" src="{{ asset('images/section_images/no-img.jpg') }}">
                      @endif
                    </td>
                    <td>{{ $section->url }}</td>
                    <td style="width: 135px;">
                      @if ($section->status==1)
                      <a class="updateSectionStatus" id="section-{{ $section->id }}" section_id="{{ $section->id }}" href="javascript:void(0)" style="color: var(--Positive-Green);"><i id="active" style="color: var(--Positive-Green); font-size: 1.05rem;" class="fas fa-toggle-on" aria-hidden="true"> đang hoạt động</i></a>   
                      @elseif ($section->status==0)
                      <a class="updateSectionStatus" id="section-{{ $section->id }}" section_id="{{ $section->id }}" href="javascript:void(0)" style="color: var(--Delete-Red);"><i id="inactive" style="color: var(--Delete-Red); font-size: 1.05rem;" class="far fa-toggle-off" aria-hidden="true"> chưa hoạt động</i></a> 
                      @endif
                    </td>
                    <td style="width: 50px;">
                      <a title="sửa danh mục" id="updateSection" href="{{ url('admin/add-edit-section/'.$section->id) }}"><i class="fas fa-edit"></i></a>
                      &nbsp; &nbsp;<a title="xóa danh mục" href="javascript:void(0)" class="confirmDelete" record="section" recordid="{{ $section->id }}"  class="confirmDelete" id="deleteSection"><i class="fas fa-trash"></i></a>
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