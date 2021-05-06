@extends('layouts.admin_layout.admin_layout')
@section('content')

<style>
    .page-item.active .page-link {background-color: var(--MinhHung-Red);border-color: var(--MinhHung-Red)}
    .page-item.active .page-link:focus{box-shadow: none;} 
    .dropdown-item.active, .dropdown-item:active {background-color: var(--MinhHung-Red)}
    .page-item .page-link {color: #333}
    .page-item .page-link:focus{box-shadow: none}
    #admin-btn{max-width: 150px; float: right; display: inline-block; background-color: var(--MinhHung-Red); border-color: var(--MinhHung-Red); font-size: 1.0rem}
    .updateCategoryStatus:hover{color: #4c5158 !important}
    #deleteCategory{color:var(--Delete-Red)}
    #deleteCategory:hover{color: var(--MinhHung-Red-Hover)}
    #updateCategory{color: #000000; text-decoration: none}
    #updateCategory:hover{color:#4c5158; text-decoration: underline}
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
            <h1>Catalogue</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}" id="admin-home">Trang Chủ</a></li>
              <li class="breadcrumb-item active">Thể Loại SP</li>
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
                <h3 class="card-title">Thể Loại Sản Phẩm</h3>
                <a href="{{ url('admin/add-edit-category') }}" class="btn btn-block btn-success"  id="admin-btn">Thêm Thể Loại SP</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Thể Loại</th>
                    <th>Phân Cấp Thể Loại</i></th>
                    <th>Danh Mục</th>
                    <th>URL</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($categories as $category)
                  @if(!isset($category->parentcategory->category_name))
                    <?php $parent_category = "cấp gốc (0)"; ?>
                    @else
                    <?php $parent_category = $category->parentcategory->category_name; ?>
                  @endif
                  <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->category_name }}</td>
                    <td>{{ $parent_category }}</td>
                    <td>{{ $category->section->name }}</td>
                    <td>{{ $category->url }}</td>
                    <td style="width: 125px;">
                        @if ($category->status==1)
                        <a class="updateCategoryStatus" id="category-{{ $category->id }}" category_id="{{ $category->id }}" href="javascript:void(0)" style="color: var(--Positive-Green);"><i id="active" style="color: var(--Positive-Green); font-size: 1.05rem;"  class="far fa-check-circle"> đang hoạt động</i></a>   
                        @elseif ($category->status==0)
                        <a class="updateCategoryStatus" id="category-{{ $category->id }}" category_id="{{ $category->id }}" href="javascript:void(0)" style="color: var(--Delete-Red);"><i id="inactive" style="color: var(--Delete-Red); font-size: 1.05rem;" class="far fa-circle"> chưa hoạt động</i></a> 
                        @endif
                    </td>
                    <td style="width: 50px;">
                      <a title="sửa thể loại" id="updateCategory" href="{{ url('admin/add-edit-category/'.$category->id) }}"><i class="fas fa-edit"></i></a>
                      &nbsp;&nbsp;<a title="sửa thể loại" href="javascript:void(0)" class="confirmDelete" record="category" recordid="{{ $category->id }}" id="deleteCategory"><i class="fas fa-trash"></i></a>
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