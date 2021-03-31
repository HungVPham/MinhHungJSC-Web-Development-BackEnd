@extends('layouts.admin_layout.admin_layout')
@section('content')

<style>
    .page-item.active .page-link {background-color: #cb1c22;border-color: #cb1c22}
    .page-item.active .page-link:focus{box-shadow: none;} 
    .dropdown-item.active, .dropdown-item:active {background-color: #cb1c22}
    .page-item .page-link {color: #333}
    .page-item .page-link:focus{box-shadow: none}
    #admin-btn{max-width: 150px; float: right; display: inline-block; background-color: #cb1c22; border-color: #cb1c22; font-size: 1.0rem}
    .updateProductStatus:hover{color: #563434 !important}
    #deleteproduct{color:#cb1c22}
    #deleteproduct:hover{color: #563434}
    #updateproduct{color: #563434; text-decoration: underline}
    #updateproduct:hover{color: #333}
    a{color: inherit;}
    .swal2-icon.swal2-warning {border-color:#cb1c22;color:#cb1c22;}
</style>
<script>
    function toggle_link(select){
    var color = select.style.color;
    select.style.color = (color == "crimson" ? "forestgreen" : "crimson");}
</script>
<script>
  function toggle_link(select){
  var color = select.style.color;
  select.style.color = (color == "forestgreen" ? "crimson" : "forestgreen");}
</script>
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
                    <th>Tên</th>
                    <th>Thể Loại Chính</th>
                    <th>Thể Loại Phụ</th>
                    <th>Danh Mục SP</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($products as $product)
                  <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->category_id }}</td>
                    <td>{{ $product->subcategory_id }}</td>
                    <td>{{ $product->section_id }}</td>
                    <td>
                        @if ($product->status==1)
                            <a onclick="javascript:toggle_link(this)" class="updateProductStatus" id="product-{{ $product->id }}" product_id="{{ $product->id }}" href="javascript:void(0)" style="color: forestgreen;">đang hoạt động</a>    
                        @else 
                            <a onclick="javascript:toggle_link(this)" class="updateProductStatus" id="product-{{ $product->id }}" product_id="{{ $product->id }}" href="javascript:void(0)" style="color: crimson;">chưa hoạt động</a> 
                        @endif
                    </td>
                    <td>
                      <a id="updateproduct" href="{{ url('admin/add-edit-product/'.$product->id) }}">Sửa</a>
                      <br>
                      <a href="javascript:void(0)" class="confirmDelete" record="product" recordid="{{ $product->id }}" id="deleteproduct">Xóa</a>
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