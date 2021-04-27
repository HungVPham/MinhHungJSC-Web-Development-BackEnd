@extends('layouts.admin_layout.admin_layout')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <style>
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
      background-color: #228B22;
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
    .add_button2{color: #228B22;}
    .add_button2:hover{color: #563434;}
    .remove_button2{color: #cb1c22;}
    .remove_button2:hover{color: #563434;}
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
      color: #000000
    }
    #add-atr-ic{
      color: var(--Hhose-Yellow);
    }
    #add-atr-ic:hover{
      color: #563434;
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
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="color: #228B22; background-color: #ffffff; border: 1px solid #228B22">
              {{ Session::get('success_message') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        @endif
        @if (Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="color: var(--Delete-Red); background-color: #ffffff; border: 1px solid var(--Delete-Red)">
              {{ Session::get('error_message') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        @endif
        <form name="attributeForm" id="attributeForm" 
          method="post" action="{{ url('admin/add-hhose-attributes/'.$productdata['id']) }}">@csrf
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">{{ $title }} <strong>[Ống Tuy Ô - Thủy Lực]</strong></h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>

              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product_name">Tên Sản Phẩm: <p style="display: inline; font-weight: lighter;">&nbsp;{{ $productdata['product_name'] }}</p></label>
                        </div>
                        <div class="form-group">
                            <label for="product_code">Mã Sản Phẩm: <p style="display: inline; font-weight: lighter;">&nbsp;{{ $productdata['product_code'] }}</p></label>
                        </div>
                        <div class="form-group">
                            <label for="product_code">Trọng Lượng Sản Phẩm: <p style="display: inline; font-weight: lighter;">&nbsp;{{ $productdata['product_weight'] }} Kg</p></label>
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
                            <input name="diameter[]" placeholder="đường kính" value="" id="diameter[]" style="width: 100px;" type="text" name="diameter[]"/>
                            <input required id="sku"  name="sku[]" type="text" name="sku[]" value="" placeholder="mã SKU" style="width: 100px;"/>
                            <input required id="price"  name="price[]" type="number" min="0" step="1" oninput="validity.valid||(value='');"  name="price[]" value="" placeholder="giá bán" style="width: 100px;"/>
                            <input required id="stock"  name="stock[]" type="number" min="0" step="1" oninput="validity.valid||(value='');"  name="stock[]" value="" placeholder="tồn kho" style="width: 100px;"/>
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