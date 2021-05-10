@extends('layouts.admin_layout.admin_layout')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <style>    
    .page-item.active .page-link {background-color: var(--MaxPro-Orange);border-color: var(--MaxPro-Orange)}
    .page-item.active .page-link:focus{box-shadow: none;} 
    .dropdown-item.active, .dropdown-item:active {background-color: var(--MaxPro-Orange)}
    .page-item .page-link {color: #333}
    .page-item .page-link:focus{box-shadow: none}
    /* Add/Remove Attributes Array Btns */
    .add_button1{color: var(--Positive-Green);}
    .add_button1:hover{color: var(--MaxPro-Orange-Hover);}
    .remove_button1{color: #cb1c22;}
    .remove_button1:hover{color: var(--Delete-Red-Hover);}
    .swal2-icon.swal2-warning {border-color:var(--Delete-Red);color:var(--Delete-Red);}
    .swal2-icon.swal2-info {border-color:var(--Info-Yellow);color:var(--Info-Yellow);}
    .card-title{
      color: #ffffff;
      font-size: 1.2rem;
    }
    .card-header{
      background-color: var(--MaxPro-Orange) !important;
    }
    .fa-minus{
      color: #ffffff;
    }
    .fa-minus:hover{
      color: #333;
    }
    .fa-plus{
      color: #ffffff;
    }
    .fa-plus:hover{
      color: #333;
    }
    #admin-btn{
      background-color: var(--MaxPro-Orange);
    }
    #admin-btn:hover{
      background-color: var(--MaxPro-Orange-Hover) !important;
    }
    #add-atr-ic{
      color: var(--MaxPro-Orange);
    }
    #add-atr-ic:hover{
      color: var(--MaxPro-Orange-Hover);
    }
    #deleteMaxproAttributes{
      color: var(--Delete-Red);
    }
    #deleteMaxproAttributes:hover{
      color: var(--Delete-Red-Hover);
    }
    #active:hover{
      color: #4c5158 !important;
    }
    #inactive:hover{
      color: #4c5158 !important;
    }
  </style>
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
          method="post" action="{{ url('admin/add-maxpro-attributes/'.$productdata['id']) }}">@csrf
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">{{ $title }}</h3>

              {{-- <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>

              </div> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product_name">Tên Sản Phẩm (Cấp 0): <p style="display: inline; font-weight: lighter;">&nbsp;{{ $productdata['product_name'] }}</p></label>
                        </div>
                        <div class="form-group">
                            <label for="product_code">Mã SP: <p style="display: inline; font-weight: lighter;">&nbsp;{{ $productdata['product_code'] }}</p></label>
                        </div>
                        <div class="form-group">
                            <label for="product_code">Trọng Lượng: <p style="display: inline; font-weight: lighter;">&nbsp;{{ $productdata['product_weight'] }} Kg</p></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            @if(!empty($productdata['main_image']))
                            <img style="width: 155px; border: 3px dashed var(--MaxPro-Orange); padding: 5px;" src="{{ asset('images/product_images/main_image/small/'.$productdata['main_image']) }}">
                            @else
                            <img style="width: 155px; border: 3px dashed var(--MaxPro-Orange); padding: 5px;" src="{{ asset('images/product_images/main_image/small/no-img.jpg') }}">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="field_wrapper1">
                          <div>
                            <input id="voltage"  name="voltage[]" type="number" min="0"  name="voltage[]" value="" placeholder="nguồn điện [V]" style="width: 125px;"/>
                            <input id="power"  name="power[]" type="number" min="0"  name="power[]" value="" placeholder="công suất [W]" style="width: 125px;"/>
                            <input required id="sku"  name="sku[]" type="text" name="sku[]" value="" placeholder="mã SKU" style="width: 100px;"/>
                            <input required id="price"  name="price[]" type="number" min="0" name="price[]" value="" placeholder="giá bán" style="width: 100px;"/>
                            <input required id="stock"  name="stock[]" type="number" min="0"  name="stock[]" value="" placeholder="tồn kho" style="width: 100px;"/>
                              <a href="javascript:void(0);" class="add_button1" title="thêm dòng dữ liệu">&nbsp;<i id="add-atr-ic" class="fas fa-plus"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </form>
              <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" id="admin-btn" style="font-size: 1.0rem;">Thêm SP Cấp (1)</button>
            </div>
            </div>

            <form name="editMaxproAttributeForm" id="editMaxproAttributeForm" method="post" action="{{ url('admin/edit-maxpro-attributes/'.$productdata['id']) }}">@csrf
              <div class="card" style="margin-bottom: 0 !important">
                <div class="card-header">
                  <h3 class="card-title">Sản Phẩm Cấp (1)</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nguồn Điện</th>
                      <th>Công Suất</th>
                      <th>Mã SKU</th>
                      <th>Giá Bán</th>
                      <th>Tồn Kho</th>
                      <th>Trạng Thái</th>
                      <th>Hành Động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($productdata['maxpro_attributes'] as $MaxproAttributes)
                    <input style="display: none;" type="text" name="attrId[]" value="{{ $MaxproAttributes['id'] }}">
                    <tr>
                      <td>{{ $MaxproAttributes['id'] }}</td>
                      <td>
                        @if(!empty($MaxproAttributes['voltage']))
                        {{ $MaxproAttributes['voltage'] }}&nbsp;[V]
                        @else 
                        <i>không có dữ liệu</i>
                        @endif
                      </td>
                      <td>
                        @if(!empty($MaxproAttributes['power']))
                        {{ $MaxproAttributes['power'] }}&nbsp;[W]
                        @else 
                        <i>không có dữ liệu</i>
                        @endif 
                      </td>
                      <td>{{ $MaxproAttributes['sku'] }}</td>
                      <td>
                        <input style="width: 50%;" type="number" min="0" name="price[]" value="{{ $MaxproAttributes['price'] }}" required=""> = <?php 
                        $num = $MaxproAttributes['price'];
                        $format = number_format($num);
                        echo $format;
                        ?> [VNĐ]
                      </td>
                      <td>
                        <input style="width: 50%;" type="number" min="0" name="stock[]" value="{{ $MaxproAttributes['stock'] }}" required=""> [Cái]
                      </td>
                      <td style="width: 125px;">
                          @if ($MaxproAttributes['status']==1)
                          <a class="updateMaxproAttributesStatus" id="MaxproAttributes-{{ $MaxproAttributes['id'] }}" MaxproAttributes_id="{{ $MaxproAttributes['id'] }}" href="javascript:void(0)" style="color: var(--Positive-Green);"><i id="active" style="color: var(--Positive-Green); font-size: 1.05rem;"  class="far fa-check-circle"> đang hoạt động</i></a>   
                          @elseif ($MaxproAttributes['status']==0)
                          <a class="updateMaxproAttributesStatus" id="MaxproAttributes-{{ $MaxproAttributes['id'] }}" MaxproAttributes_id="{{ $MaxproAttributes['id'] }}" href="javascript:void(0)" style="color: var(--Delete-Red);"><i id="inactive" style="color: var(--Delete-Red); font-size: 1.05rem;" class="far fa-circle"> chưa hoạt động</i></a> 
                          @endif
                      </td>
                      <td style="width: 50px;">
                          <a title="xóa sản phẩm cấp (1)" href="javascript:void(0)" class="confirmDelete" record="maxproattributes" recordid="{{ $MaxproAttributes['id'] }}" id="deleteMaxproAttributes"><i class="fas fa-trash"></i></a>
                      </td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" id="admin-btn" style="font-size: 1.0rem;">Cập Nhật SP (Cấp 1)</button>
                </div>


              </div>
            </form>
            <!-- /.card -->
          </div><div style="color: #f4f6f9; font-size: 0.5rem; margin: none; padding: none;">dummy text margin</div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection