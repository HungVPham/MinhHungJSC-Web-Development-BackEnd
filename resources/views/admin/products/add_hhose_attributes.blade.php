@extends('layouts.admin_layout.admin_layout')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <style>
    .page-item.active .page-link {color: #000000;background-color: var(--Hhose-Yellow);border-color: var(--Hhose-Yellow)}
    .page-item.active .page-link:focus{box-shadow: none;} 
    .dropdown-item.active, .dropdown-item:active {background-color: var(--Hhose-Yellow); color: #000000;}
    .page-item .page-link {color: #333}
    .page-item .page-link:focus{box-shadow: none}
    .swal2-icon.swal2-warning {border-color:var(--Delete-Red);color:var(--Delete-Red);}
    .swal2-icon.swal2-info {border-color:var(--Info-Yellow);color:var(--Info-Yellow);}
    input[type="checkbox"]{
      appearance: none;
      -webkit-appearance: none;
      height: 18px;
      width: 18px;
      background-color: #d5d5d5;
      outline: none;
      cursor: pointer;
      border: 1px solid #333;
      align-items: center;
      justify-content: center;
      display: flex;
      float: right;
    }
    input[type="checkbox"]:after{
      font-family: "Font Awesome 5 Free";
      font-weight: 900;
      content: "\f00c";
      font-size: 13px;
      color: #ffffff;
      display: none;

    }
    input[type="checkbox"]:hover{
      background-color: #a5a5a5;
    }
    input[type="checkbox"]:checked{
      appearance: none;
      -webkit-appearance: none;
      background-color: var(--Positive-Green);
      height: 18px;
      width: 18px;
      align-items: center;
      justify-content: center;
      display: flex;
    }
    input[type="checkbox"]:checked::after{
      display: block;
    }
     /* Add/Remove Attributes Array Btns */
    .add_button2{color: var(--Positive-Green);}
    .add_button2:hover{color: var(--Hhose-Yellow-Hover);}
    .remove_button2{color: #cb1c22;}
    .remove_button2:hover{color: var(--Delete-Red-Hover);}
    .card-title{
      color: #000000;
      font-size: 1.2rem;
    }
    .card-header{
      background-color: var(--Hhose-Yellow) !important;
    }
    .fa-minus{
      color: #000000;
    }
    .fa-minus:hover{
      color: #6c757d;
    }
    .fa-plus{
      color: #000000;
    }
    .fa-plus:hover{
      color: #6c757d;
    }
    #admin-btn{
      background-color: var(--Hhose-Yellow);
      color: #000000;
    }
    #admin-btn:hover{
      background-color: var(--Hhose-Yellow-Hover) !important;
      color: #ffffff;
    }
    #add-atr-ic{
      color: var(--Hhose-Yellow);
    }
    #add-atr-ic:hover{
      color:  var(--Hhose-Yellow-Hover);
    }
    #deleteHhoseAttributes{
      color: var(--Delete-Red);
    }
    #deleteHhoseAttributes:hover{
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
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="color: var(--Delete-Red); background-color: #ffffff; border: 1px solid var(--Delete-Red)">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;●&nbsp;&nbsp;{{ Session::get('error_message') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        @endif
        <form name="attributeForm" id="attributeForm" 
          method="post" action="{{ url('admin/add-hhose-attributes/'.$productdata['id']) }}">@csrf
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
                            <label for="product_name">Tên Sản Phẩm Cấp (0): <p style="display: inline; font-weight: lighter;">&nbsp;{{ $productdata['product_name'] }}</p></label>
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
                            <img style="width: 155px; border: 3px dashed var(--Hhose-Yellow); padding: 5px;" src="{{ asset('images/product_images/main_image/small/'.$productdata['main_image']) }}">
                            @else
                            <img style="width: 155px; border: 3px dashed var(--Hhose-Yellow); padding: 5px;" src="{{ asset('images/product_images/main_image/small/no-img.jpg') }}">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="field_wrapper2">
                          <div>
                            <input name="diameter[]" placeholder="đường kính [Inch]" value="" id="diameter[]" style="width: 130px;" type="text" name="diameter[]"/>
                            <input required id="sku"  name="sku[]" type="text" name="sku[]" value="" placeholder="mã SKU" style="width: 100px;"/>
                            <input required id="price"  name="price[]" type="number" min="0" name="price[]" value="" placeholder="giá bán" style="width: 100px;"/>
                            <input required id="stock"  name="stock[]" type="number" min="0" name="stock[]" value="" placeholder="tồn kho" style="width: 100px;"/>
                            <div style="width: 100%; margin-top: 10px;">
                                <label style="font-weight: 500; color: #5c5c5c" for="hhose_spflex_embossed">Da Trơn: Có/Không</label>
                                <input id="hhose_spflex_embossed"  name="hhose_spflex_embossed[]" type="checkbox" name="hhose_spflex_embossed[]" value="Yes"/></div>
                                <div style="width: 100%;">
                                <label style="font-weight: 500; color: #5c5c5c" for="hhose_spflex_smoothtexture">Da Trơn: Có/Không</label>
                                <input id="hhose_spflex_smoothtexture"  name="hhose_spflex_smoothtexture[]" type="checkbox" name="hhose_spflex_smoothtexture[]" value="Yes"/>
                            </div>
                              <a href="javascript:void(0);" class="add_button2" title="thêm dòng dữ liệu"><i id="add-atr-ic" class="fas fa-plus"></i></a>
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
            <form name="editHhoseAttributeForm" id="editHhoseAttributeForm" method="post" action="{{ url('admin/edit-hhose-attributes/'.$productdata['id']) }}">@csrf
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Sản Phẩm Cấp (1)</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Đường Kính</th>
                    <th>In Nổi</th>
                    <th>Da Trơn</th>
                    <th>Mã SKU</th>
                    <th>Giá Bán</th>
                    <th>Tồn Kho</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($productdata['hhose_attributes'] as $HhoseAttributes)
                  <input style="display: none;" type="text" name="attrId[]" value="{{ $HhoseAttributes['id'] }}">
                  <tr>
                    <td>{{ $HhoseAttributes['id'] }}</td>
                    <td>
                      @if(!empty($HhoseAttributes['diameter']))
                      {{ $HhoseAttributes['diameter'] }}&nbsp;[Inch]
                      @else 
                      <i>không có dữ liệu</i>
                      @endif
                    </td>
                    <td>
                      @if($HhoseAttributes['hhose_spflex_embossed']=='Yes')
                      <p style="color: var(--Positive-Green-Hover)">Có</p>
                      @else 
                      <p style="color: var(--Delete-Red-Hover)">Không</p>
                      @endif 
                    </td>
                    <td>
                      @if($HhoseAttributes['hhose_spflex_smoothtexture']=='Yes')
                      <p style="color: var(--Positive-Green-Hover)">Có</p>
                      @else 
                      <p style="color: var(--Delete-Red-Hover)">Không</p>
                      @endif 
                    </td>
                    <td>{{ $HhoseAttributes['sku'] }}</td>
                    <td>
                      <input style="width: 50%;" type="number" min="0"  name="price[]" value="{{ $HhoseAttributes['price'] }}" required=""> = <?php 
                      $num = $HhoseAttributes['price'];
                      $format = number_format($num);
                      echo $format;
                      ?> [VNĐ]
                    </td>
                    <td>
                      <input style="width: 50%;" type="number" min="0"  name="stock[]" value="{{ $HhoseAttributes['stock'] }}" required=""> [Cái]
                    </td>
                    <td style="width: 125px;">
                      @if ($HhoseAttributes['status']==1)
                      <a class="updateHhoseAttributesStatus" id="HhoseAttributes-{{ $HhoseAttributes['id'] }}" HhoseAttributes_id="{{ $HhoseAttributes['id'] }}" href="javascript:void(0)" style="color: var(--Positive-Green); font-size: 1.05rem;"><i id="active" style="color: var(--Positive-Green); font-size: 1.05rem;"  class="far fa-check-circle"> đang hoạt động</i></a>   
                      @elseif ($HhoseAttributes['status']==0)
                      <a class="updateHhoseAttributesStatus" id="HhoseAttributes-{{ $HhoseAttributes['id'] }}" HhoseAttributes_id="{{ $HhoseAttributes['id'] }}" href="javascript:void(0)" style="color: var(--Delete-Red); font-size: 1.05rem;"><i id="inactive" style="color: var(--Delete-Red); font-size: 1.05rem;" class="far fa-circle"> chưa hoạt động</i></a> 
                      @endif
                  </td>
                  <td style="width: 50px;">
                      <a title="xóa sản phẩm cấp (1)" href="javascript:void(0)" class="confirmDelete" record="hhoseattributes" recordid="{{ $HhoseAttributes['id'] }}" id="deleteHhoseAttributes"><i class="fas fa-trash"></i></a>
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
          </div> font-size: 0.9rem;
    <!-- /.content -->
  </div>
@endsection