@extends('layouts.admin_layout.admin_layout')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <style>    
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
  </style>
  @if($productdata['section_id']==1)
  <style>
    .card-header{background-color: var(--MaxPro-Orange) !important;}
    #admin-btn{background-color: var(--MaxPro-Orange);}
    #admin-btn:hover{background-color: var(--MaxPro-Orange-Hover) !important;}
    .dropdown-item.active, .dropdown-item:active {background-color: var(--MaxPro-Orange)}
    .page-item.active .page-link {background-color: var(--MaxPro-Orange);border-color: var(--MaxPro-Orange)}
    #main_image{width: 155px; border: 3px dashed var(--MaxPro-Orange); padding: 5px;}
  </style>
  @endif
  @if($productdata['section_id']==2)
  <style>
    .card-header{background-color: var(--Hhose-Yellow) !important;}
    #admin-btn{background-color: var(--Hhose-Yellow); color: #000000;}
    #admin-btn:hover{background-color: var(--Hhose-Yellow-Hover) !important;}
    .dropdown-item.active, .dropdown-item:active {background-color: var(--Hhose-Yellow)}
    .page-item.active .page-link {background-color: var(--Hhose-Yellow);border-color: var(--Hhose-Yellow)}
    #main_image{width: 155px; border: 3px dashed var(--Hhose-Yellow); padding: 5px;}
    .card-title{color: #000000;}
  </style>
  @endif
  @if($productdata['section_id']==3)
  <style>
    .card-header{background-color: var(--Shimge-Blue) !important;}
    #admin-btn{background-color: var(--Shimge-Blue);}
    #admin-btn:hover{background-color: var(--Shimge-Blue-Hover) !important;}
    .dropdown-item.active, .dropdown-item:active {background-color: var(--Shimge-Blue)}
    .page-item.active .page-link {background-color: var(--Shimge-Blue);border-color: var(--Shimge-Blue)}
    #main_image{width: 155px; border: 3px dashed var(--Shimge-Blue); padding: 5px;}
  </style>
  @endif
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
              <li class="breadcrumb-item active"><a href="{{ url('admin/products') }}" id="admin-prev">Sản Phẩm</a></li>
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
        <form name="addMaxproAttributeForm" id="addMaxproAttributeForm" 
          method="post" action="{{ url('admin/add-images/'.$productdata['id']) }}">@csrf
          <div class="card card-default" style="width: 50%;">
            <div class="card-header">
              <h3 class="card-title">{{ $title }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product_name">&nbsp;Tên Sản Phẩm (Cấp 0): <p style="display: inline; font-weight: lighter;">&nbsp;{{ $productdata['product_name'] }}</p></label>
                        </div>
                        <div class="form-group">
                            <label for="product_code">&nbsp;Mã SP: <p style="display: inline; font-weight: lighter;">&nbsp;{{ $productdata['product_code'] }}</p></label>
                        </div>
                        <div class="form-group">
                            <label for="product_code">&nbsp;Trọng Lượng: <p style="display: inline; font-weight: lighter;">&nbsp;{{ $productdata['product_weight'] }} Kg</p></label>
                        </div>
                        <div class="form-group">
                            <div class="field_wrapper1">
                              <div class="custom-file">
                                <input class="custom-file-input" id="image" multiple="" name="image[]" type="file" name="image[]" value="" placeholder="thêm hình ảnh..." accept="image/*"/>
                                <label class="custom-file-label" for="main_image">chọn hình ảnh...</label>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: center;" class="col-md-6">
                        <div class="form-group">
                            @if(!empty($productdata['main_image']))
                            <img name="main_image" id="main_image" src="{{ asset('images/product_images/main_image/small/'.$productdata['main_image']) }}">
                            @else
                            <img name="main_image" id="main_image" src="{{ asset('images/product_images/main_image/small/no-img.jpg') }}">
                            @endif
                            <label style="display: block; padding-left: 20px; padding-top: 5px;" for="main_image">Hình Ảnh Cấp (0)</label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
              <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" id="admin-btn" style="font-size: 1.0rem;">Thêm Hình Ảnh (Cấp 1)</button>
            </div>
            </div>

            {{-- <form name="editImageForm" id="editImageForm" method="post" action="{{ url('admin/edit-images/'.$productdata['id']) }}" enctype="multipart/form-data">@csrf --}}
              <div class="card" style="width: 50%;">
                <div class="card-header">
                  <h3 class="card-title">Hình Ảnh Cấp (1)</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Hình Ảnh</th>
                      <th style="width: 150px;">Trạng Thái</th>
                      <th style="width: 50px;">Hành Động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($productdata['images'] as $Image)
                    <input style="display: none;" type="text" name="attrId[]" value="{{ $Image['id'] }}">
                    <tr>
                      <td>{{ $Image['id'] }}</td>
                      <td style="text-align: center;">
                        <img style="width: 150px;" src="{{ asset('images/product_images/main_image/small/'.$productdata['main_image']) }}">
                      </td>
                      <td style="width: 150px;">
                          @if ($Image['status']==1)
                          <a class="updateImageStatus" id="Image-{{ $Image['id'] }}" Image_id="{{ $Image['id'] }}" href="javascript:void(0)" style="color: var(--Positive-Green);"><i id="active" style="color: var(--Positive-Green); font-size: 1.05rem;"  class="far fa-check-circle"> đang hoạt động</i></a>   
                          @elseif ($Image['status']==0)
                          <a class="updateImageStatus" id="Image-{{ $Image['id'] }}" Image_id="{{ $Image['id'] }}" href="javascript:void(0)" style="color: var(--Delete-Red);"><i id="inactive" style="color: var(--Delete-Red); font-size: 1.05rem;" class="far fa-circle"> chưa hoạt động</i></a> 
                          @endif
                      </td>
                      <td style="width: 50px;">
                          <a title="xóa hình ảnh cấp (1)" href="javascript:void(0)" class="confirmDelete" record="Image" recordid="{{ $Image['id'] }}" id="deleteImage"><i class="fas fa-trash"></i></a>
                      </td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                {{-- <div class="card-footer">
                  <button type="submit" class="btn btn-primary" id="admin-btn" style="font-size: 1.0rem;">Cập Nhật SP (Cấp 1)</button>
                </div> --}}


              </div>
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