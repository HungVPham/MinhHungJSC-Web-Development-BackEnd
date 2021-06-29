@extends('layouts.admin_layout.admin_layout')
@section('content')

<style>
    .page-item.active .page-link {background-color: var(--MinhHung-Red);border-color: var(--MinhHung-Red)}
    .page-item.active .page-link:focus{box-shadow: none;} 
    .dropdown-item.active, .dropdown-item:active {background-color: var(--MinhHung-Red)}
    .page-item .page-link {color: #333}
    .page-item .page-link:focus{box-shadow: none}
    #admin-btn{max-width: 150px; float: right; display: inline-block; background-color: var(--MinhHung-Red); border-color: var(--MinhHung-Red); font-size: 1.0rem}
    .updateProductStatus:hover{color: #4c5158 !important}
    #deleteproduct{color:var(--Delete-Red)}
    #deleteproduct:hover{color: var(--MinhHung-Red-Hover)}
    #updateproduct{color: #000000;}
    #updateproduct:hover{color: #4c5158;}
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
              <li class="breadcrumb-item active">Sản Phẩm</li>
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
                <h3 class="card-title">Sản Phẩm</h3>
                <a href="{{ url('admin/add-edit-product') }}" class="btn btn-block btn-success"  id="admin-btn">Thêm Sản Phẩm</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Mã SP</th>
                    <th>Thương Hiệu</th>
                    <th>Tên SP</th>
                    <th>Hình Ảnh</th>
                    <th>Thể Loại SP</th>
                    <th>Danh Mục SP</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($products as $product)
                  <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_code }}</td>
                    <td>{{ $product->brand->name }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td style="text-align: center;">
                      <?php $product_image_path = "images/product_images/main_image/small/".$product->main_image; ?>
                      @if(!empty($product->main_image) && file_exists($product_image_path))
                      <img style="width: 100px;" src="{{ asset('images/product_images/main_image/small/'.$product->main_image) }}">
                       @else
                      <img style="width: 100px;" src="{{ asset('images/product_images/main_image/small/no-img.jpg') }}">
                      @endif
                    </td>
                    <td>{{ $product->category->category_name }}</td>
                    <td>{{ $product->section->name }}</td>
                    <td style="width: 135px;">
                        @if ($product->status==1)
                        <a class="updateProductStatus" id="product-{{ $product->id }}" product_id="{{ $product->id }}" href="javascript:void(0)" style="color: var(--Positive-Green);"><i id="active" style="color: var(--Positive-Green); font-size: 1.05rem;"  class="fas fa-toggle-on" aria-hidden="true"> đang hoạt động</i></a>   
                        @elseif ($product->status==0)
                        <a class="updateProductStatus" id="product-{{ $product->id }}" product_id="{{ $product->id }}" href="javascript:void(0)" style="color: var(--Delete-Red);"><i id="inactive" style="color: var(--Delete-Red); font-size: 1.05rem;" class="fas fa-toggle-off" aria-hidden="true"> chưa hoạt động</i></a> 
                        @endif
                    </td>
                    <td style="width: 95px;">
                      <a title="thêm sản phẩm cấp (1)" id="updateproduct" 
                      @if($product->section_id==1)
                      href="{{ url('admin/add-maxpro-attributes/'.$product->id) }}">
                      @else 
                      @endif
                      @if($product->section_id==2)
                      href="{{ url('admin/add-hhose-attributes/'.$product->id) }}">
                      @else 
                      @endif
                      @if($product->section_id==3)
                      href="{{ url('admin/add-shimge-attributes/'.$product->id) }}">
                      @else 
                      @endif
                      <i class="fas fa-plus"></i></a>
                      &nbsp;&nbsp;<a title="thêm hình ảnh (cấp 1) cho sản phẩm " id="updateproduct" href="{{ url('admin/add-images/'.$product->id) }}"><i class="fas fa-images"></i></a>
                      &nbsp;&nbsp;<a title="sửa sản phẩm" id="updateproduct" href="{{ url('admin/add-edit-product/'.$product->id) }}"><i class="fas fa-edit"></i></a>
                      &nbsp;&nbsp;<a title="xóa sản phẩm" href="javascript:void(0)" class="confirmDelete" record="product" recordid="{{ $product->id }}" id="deleteproduct"><i class="fas fa-trash"></i></a>
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