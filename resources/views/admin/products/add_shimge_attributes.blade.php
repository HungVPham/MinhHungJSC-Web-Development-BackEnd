@extends('layouts.admin_layout.admin_layout')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <style>
    .page-item.active .page-link {background-color: var(--Shimge-Blue);border-color: var(--Shimge-Blue)}
    .page-item.active .page-link:focus{box-shadow: none;} 
    .dropdown-item.active, .dropdown-item:active {background-color: var(--Shimge-Blue)}
    .page-item .page-link {color: #333}
    .page-item .page-link:focus{box-shadow: none}
    /* Add/Remove Attributes Array Btns */
    .remove_button3{color: var(--Delete-Red);}
    .remove_button3:hover{color: var(--Delete-Red-Hover);}
    .swal2-icon.swal2-warning {border-color:var(--Delete-Red);color:var(--Delete-Red);}
    .swal2-icon.swal2-info {border-color:var(--Info-Yellow);color:var(--Info-Yellow);}
    .card-title{
      color: #ffffff;
      font-size: 1.2rem;
    }
    .card-header{
      background-color: var(--Shimge-Blue) !important;
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
      background-color: var(--Shimge-Blue);
    }
    #admin-btn:hover{
      background-color: var(--Shimge-Blue-Hover) !important;
    }
    #add-atr-ic{
      color: var(--Shimge-Blue);
    }
    #add-atr-ic:hover{
      color: var(--Shimge-Blue-Hover);
    }
    #deleteShimgeAttributes{
      color: var(--Delete-Red);
    }
    #deleteShimgeAttributes:hover{
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
            <div class="alert alert-danger" style="color: var(--Delete-Red); background-color: #ffffff; border: 1px solid var(--Delete-Red)">
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
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="color: var(--Delete-Red); background-color: #ffffff; border: 1px solid var(--Delete-Red)">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;●&nbsp;&nbsp;{{ Session::get('error_message') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        @endif
        <form name="attributeForm" id="attributeForm" 
          method="post" action="{{ url('admin/add-shimge-attributes/'.$productdata['id']) }}">@csrf
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
                            <label for="product_code">Trọng Lượng: <p style="display: inline; font-weight: lighter;">@if(!empty($productdata['product_weight']))
                              &nbsp;{{ $productdata['product_weight'] }}&nbsp;[Kg]
                              @else 
                              <i>&nbsp;không có dữ liệu</i>
                              @endif</p></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            @if(!empty($productdata['main_image']))
                            <img style="width: 155px; border: 3px dashed var(--Shimge-Blue); padding: 5px;" src="{{ asset('images/product_images/main_image/small/'.$productdata['main_image']) }}">
                            @else
                            <img style="width: 155px; border: 3px dashed var(--Shimge-Blue); padding: 5px;" src="{{ asset('images/product_images/main_image/small/no-img.jpg') }}">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="field_wrapper3">
                          <div>
                            <input id="voltage"  name="voltage[]" type="number" min="0" name="voltage[]" value="" placeholder="nguồn điện [V]" style="width: 125px; margin-top: 5px;"/>
                            <input id="power"  name="power[]" type="number" min="0" name="power[]" value="" placeholder="công suất [W]" style="width: 125px; margin-top: 5px;"/>
                            <input id="maxflow"  name="maxflow[]" type="number" min="0" step="0.1" name="maxflow[]" value="" placeholder="lưu lượng [m³/h]" style="width: 135px; margin-top: 5px;"/>
                            <input id="vertical"  name="vertical[]" type="number" min="0" step="0.1" name="vertical[]" value="" placeholder="đẩy cao [m]" style="width: 100px; margin-top: 5px;"/>
                            <input id="indiameter"  name="indiameter[]" type="number" min="0" name="indiameter[]" value="" placeholder="họng hút [mm]" style="width: 125px; margin-top: 5px;"/>
                            <input id="outdiameter"  name="outdiameter[]" type="number" min="0" name="outdiameter[]" value="" placeholder="họng xả [mm]" style="width: 125px; margin-top: 5px;"/>
                            <input required id="sku"  name="sku[]" type="text" name="sku[]" value="" placeholder="mã SKU" style="width: 100px; margin-top: 5px;"/>
                            <input required id="price"  name="price[]" type="number" min="0" name="price[]" value="" placeholder="giá bán" style="width: 100px; margin-top: 5px;"/>
                            <input required id="stock"  name="stock[]" type="number" min="0" name="stock[]" value="" placeholder="tồn kho" style="width: 100px; margin-top: 5px;"/>
                              <a href="javascript:void(0);" class="add_button3" title="thêm dòng dữ liệu">&nbsp;<i id="add-atr-ic" class="fas fa-plus"></i></a>
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
            <form name="editShimgeAttributeForm" id="editShimgeAttributeForm" method="post" action="{{ url('admin/edit-shimge-attributes/'.$productdata['id']) }}">@csrf
            <div class="card" style="margin-bottom: 0 !important">
              <div class="card-header">
                <h3 class="card-title">Sản Phẩm Cấp (1)</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nguồn Điện</th>
                    <th>Công Suất</th>
                    <th>Lưu Lượng</th>
                    <th>Đẩy Cao</th>
                    <th>Họng Hút</th>
                    <th>Họng Xả</th>
                    <th>Mã SKU</th>
                    <th>Giá Bán</th>
                    <th>Tồn Kho</th>
                    <th>Trạng Thái</th>
                    <th>Điều Khiển</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($productdata['shimge_attributes'] as $ShimgeAttributes)
                  <input style="display: none;" type="text" name="attrId[]" value="{{ $ShimgeAttributes['id'] }}">
                  <tr>
                    <td>
                      @if(!empty($ShimgeAttributes['voltage']))
                      {{ $ShimgeAttributes['voltage'] }}&nbsp;[V]
                      @else 
                      <i>không có dữ liệu</i>
                      @endif
                    </td>
                    <td>
                      @if(!empty($ShimgeAttributes['power']))
                      {{ $ShimgeAttributes['power'] }}&nbsp;[W]
                      @else 
                      <i>không có dữ liệu</i>
                      @endif 
                    </td>
                    <td>
                      @if(!empty($ShimgeAttributes['maxflow']))
                      {{ $ShimgeAttributes['maxflow'] }}&nbsp;[m³/h]
                      @else 
                      <i>không có dữ liệu</i>
                      @endif 
                    </td>
                    <td>
                      @if(!empty($ShimgeAttributes['vertical']))
                      {{ $ShimgeAttributes['vertical'] }}&nbsp;[m]
                      @else 
                      <i>không có dữ liệu</i>
                      @endif 
                    </td>
                    <td>
                      @if(!empty($ShimgeAttributes['indiameter']))
                      {{ $ShimgeAttributes['indiameter'] }}&nbsp;[mm]
                      @else 
                      <i>không có dữ liệu</i>
                      @endif 
                    </td>
                    <td>
                      @if(!empty($ShimgeAttributes['outdiameter']))
                      {{ $ShimgeAttributes['outdiameter'] }}&nbsp;[mm]
                      @else 
                      <i>không có dữ liệu</i>
                      @endif 
                    </td>
                    <td>{{ $ShimgeAttributes['sku'] }}</td>
                    <td>
                      <input style="width: 80%;" type="number" min="0" name="price[]" value="{{ $ShimgeAttributes['price'] }}" required=""> 
                      <div> = <?php 
                      $num = $ShimgeAttributes['price'];
                      $format = number_format($num,0,",",".");
                      echo $format;
                      ?> ₫
                      </div>
                    </td>
                    <td>
                      <input style="width: 70%;" type="number" min="0" name="stock[]" value="{{ $ShimgeAttributes['stock'] }}" required=""> [Cái]
                    </td>
                    <td style="width: 135px;">
                      @if ($ShimgeAttributes['status']==1)
                      <a class="updateShimgeAttributesStatus" id="ShimgeAttributes-{{ $ShimgeAttributes['id'] }}" ShimgeAttributes_id="{{ $ShimgeAttributes['id'] }}" href="javascript:void(0)" style="color: var(--Positive-Green); font-size: 1.05rem;"><i id="active" style="color: var(--Positive-Green); font-size: 1.05rem;"  class="fas fa-toggle-on" aria-hidden="true"> đang hoạt động</i></a>   
                      @elseif ($ShimgeAttributes['status']==0)
                      <a class="updateShimgeAttributesStatus" id="ShimgeAttributes-{{ $ShimgeAttributes['id'] }}" ShimgeAttributes_id="{{ $ShimgeAttributes['id'] }}" href="javascript:void(0)" style="color: var(--Delete-Red); font-size: 1.05rem;"><i id="inactive" style="color: var(--Delete-Red); font-size: 1.05rem;" class="fas fa-toggle-off" aria-hidden="true"> chưa hoạt động</i></a> 
                      @endif
                  </td>
                  <td style="width: 50px;">
                      <a title="xóa sản phẩm cấp (1)" href="javascript:void(0)" class="confirmDelete" record="shimgeattributes" recordid="{{ $ShimgeAttributes['id'] }}" id="deleteShimgeAttributes"><i class="fas fa-trash"></i></a>
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