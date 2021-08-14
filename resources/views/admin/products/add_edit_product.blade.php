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
      margin-top: 7px;
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
    #dlt-product-img{color: var(--Delete-Red);}
    #dlt-product-img:hover{color: var(--Delete-Red-Hover);}
    /* #dlt-product-vid{color: var(--Delete-Red);}
    #dlt-product-vid:hover{color: var(--Delete-Red-Hover);} */
    .swal2-icon.swal2-warning {border-color:var(--Delete-Red);color:var(--Delete-Red);}
    /* #download-video-btn{color: var(--Positive-Green);}
    #download-video-btn:hover{color: var(--Positive-Green-Hover);} */
    .card-title{
      color: #ffffff;
      font-size: 1.2rem;
    }
    .card-header{
      background-color: var(--MinhHung-Red) !important;
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
  </style>
  @if(!empty($productdata['section_id']))
  @if($productdata['section_id']==1)
  <style>
    .card-title{color: #ffffff; font-size: 1.2rem;}
    .card-header{background-color: var(--MaxPro-Orange) !important;}
    #admin-btn{background-color:  var(--MaxPro-Orange);}
    #admin-btn:hover{background-color:  var(--MaxPro-Orange-Hover) !important;}
  </style>
  @endif
  @if($productdata['section_id']==2)
  <style>
    .card-title{color: #000000; font-size: 1.2rem;}
    .card-header{background-color: var(--Hhose-Yellow) !important;}
    #admin-btn{color: #000000; background-color:  var(--Hhose-Yellow);}
    #admin-btn:hover{color: #000000 !important; background-color:  var(--Hhose-Yellow-Hover) !important;}
  </style>
  @endif
  @if($productdata['section_id']==3)
  <style>
    .card-title{color: #ffffff;font-size: 1.2rem;}
    .card-header{background-color: var(--Shimge-Blue) !important;}
    #admin-btn{background-color:  var(--Shimge-Blue);}
    #admin-btn:hover{background-color:  var(--Shimge-Blue-Hover) !important;}
  </style>
  @endif
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
            <div class="alert alert-danger" style="color: var(--MinhHung-Red); background-color: #ffffff; border: 1px solid var(--MinhHung-Red)">
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
        <form name="productForm" id="ProductForm" 
          @if(empty($productdata['id'])) 
            action="{{ url('admin/add-edit-product') }}" 
          @else
            action="{{ url('admin/add-edit-product/'.$productdata['id']) }}" 
          @endif
          method="post" enctype="multipart/form-data">@csrf
          <div class="card card-default" style="margin-bottom: 0 !important">
            <div class="card-header">
              <h3 class="card-title">{{ $title }}</h3>
            </div>
            <div class="card-body">
              <div class="row">
                @if(empty($productdata['section_id']))
                <p aria-hidden="true" id="required-description" style="width: 100%;">
                  <label><span aria-hidden="true" class="required">&nbsp;*</span></label> &nbsp;trường nhập bắt buộc
                </p>
                @endif
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="category_id">&nbsp;Thể Loại Cấp (0) @if(empty($productdata['section_id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <select name="category_id" id="category_id" class="form-control select2" style="width: 100%;">
                      <option value="">chọn danh mục...</option>
                      @foreach($categories as $section)
                        <optgroup label="{{ $section['name'] }}"></optgroup>
                        @foreach($section['categories'] as $category)
                          <option  value="{{ $category['id'] }}" @if(!empty(@old('category_id')) && $category['id'] ==@old('category_id')) selected=""@elseif(!empty($productdata['category_id']) && $productdata['category_id']==$category['id']) selected="" @endif> {{ $category['category_name'] }}</option>
                          @foreach($category['subcategories'] as $subcategory)
                            <option  value="{{ $subcategory['id'] }}" @if(!empty(@old('category_id')) && $subcategory['id'] ==@old('category_id')) selected=""@elseif(!empty($productdata['category_id']) && $productdata['category_id']==$subcategory['id']) selected="" @endif>&nbsp;&nbsp;---&nbsp;&nbsp;{{ $subcategory['category_name'] }}</option>
                          @endforeach
                        @endforeach
                      @endforeach
                    </select>
                  </div>
                  <div id="appendPrimeCategoriesLevel">
                    @include('admin.categories.append_prime_categories_level')
                  </div>
                  <div class="form-group">
                    <label for="product_name">&nbsp;Tên Sản Phẩm @if(empty($productdata['section_id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <input type="text" class="form-control" name="product_name" id="product_name" placeholder="nhập tên..."
                    @if (!empty($productdata['product_name'])) value="{{ $productdata['product_name'] }}"
                    @else value="{{ old("product_name") }}"
                    @endif>
                  </div>
                  <div class="form-group">
                    <label for="product_price">&nbsp;Giá Sản Phẩm @if(empty($productdata['product_price']))(1000000 &#8594; 1,000,000) [VND]@endif</label>
                    <input type="number" min="0" class="form-control" name="product_price" id="product_price" placeholder="nhập giá..."
                    @if (!empty($productdata['product_price'])) value="{{ $productdata['product_price'] }}"
                    @else value="{{ old("product_price") }}"
                    @endif>
                    @if(!empty($productdata['product_price']))
                    <div style="color: grey">&nbsp;&nbsp;giá hiện tại = <?php 
                          $num = $productdata['product_price'];
                          $format = number_format($num,0,",",".");
                          echo $format;
                        ?> ₫
                    </div>
                    @endif
                  </div>
                 
                <div class="form-group">
                  <label for="main_image">&nbsp;Hình Ảnh (Cấp 0)</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="main_image" id="main_image" accept="image/*">
                      <label class="custom-file-label" for="main_image">chọn hình ảnh...</label>
                    </div>
                  </div>
                  @if(!empty($productdata['section_id']))
                    @if(!empty($productdata['main_image']))
                    <div style="padding-top: 10px;"><p>&nbsp;(Người dùng nên xóa ảnh cũ trước khi thêm ảnh mới để tối ưu hóa dung lượng.)<p><img style="width: 80px" src="{{ asset('images/product_images/main_image/small/'.$productdata['main_image']) }}">
                      &nbsp;&nbsp;<a title="xóa ảnh" class="confirmDelete" href="javascript:void(0)" class="confirmDelete" record="product-image" recordid="{{ $productdata['id'] }}" id="dlt-product-img"><i class="fas fa-trash"></i></a>
                    </div>
                    @endif
                  @else<div style="color: grey">&nbsp;&nbsp;độ phân giải đề xuất (750x650) [px]</div>
                  @endif
                </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="brand_id">&nbsp;Chọn Thương Hiệu Sản Phẩm @if(empty($productdata['section_id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <select name="brand_id" id="brand_id" class="form-control select2" style="width: 100%;">
                      <option value="">chọn thương hiệu</option>
                      @foreach($brands as $brand)
                      <option value="{{ $brand['id'] }}" @if(!empty($productdata['brand_id']) && $productdata['brand_id']==$brand['id']) selected="" @endif><?php echo $brand['name'] ?></option>
                      @endforeach
                    </select> 
                  </div>
                  <div class="form-group">
                    <label for="product_code">&nbsp;Mã Sản Phẩm @if(empty($productdata['section_id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <input type="text" class="form-control" name="product_code" id="product_code" placeholder="nhập mã..."
                    @if (!empty($productdata['product_code'])) value="{{ $productdata['product_code'] }}"
                    @else value="{{ old("product_code") }}"
                    @endif>
                  </div>
                  <div class="form-group">
                    <label for="product_weight">&nbsp;Trọng Lượng Sản Phẩm @if(empty($productdata['product_weight']))(0.0) [Kg]@endif</label>
                    <input type="number" step="0.1" type="number" min="0" class="form-control" name="product_weight" id="product_weight" placeholder="nhập trọng lượng..."
                    @if (!empty($productdata['product_weight'])) value="{{ $productdata['product_weight'] }}"
                    @else value="{{ old("product_weight") }}"
                    @endif>
                    @if(!empty($productdata['product_weight']))
                    <div style="color: grey">&nbsp;&nbsp;trọng lượng hiện tại =  {{ $productdata['product_weight'] }} [Kg]
                    </div>
                    @endif
                  </div>
                  {{-- <div class="form-group">
                    <label for="exampleInputFile">&nbsp;Video Demo Sản Phẩm</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="product_video" id="product_video" accept="video/mp4,video/x-m4v,video/*">
                        <label class="custom-file-label" for="product_video">chọn video...</label>
                      </div>
                    </div>
                    @if(!empty($productdata['product_video']))
                      <div style="color: grey;">&nbsp;&nbsp;tải hoặc xóa video hiện tại:&nbsp;&nbsp;<a title="tải video" id="download-video-btn" href="{{ url('videos/product_videos/'.$productdata['product_video']) }}" download><i class="fas fa-file-video"></i></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a class="confirmDelete" href="javascript:void(0)" class="confirmDelete" title="xóa video" record="product-video" recordid="{{ $productdata['id'] }}" id="dlt-product-vid"><i class="fas fa-trash"></i></a></div>
                    @endif
                  </div> --}}
                  <div class="form-group">
                    <label for="product_discount">&nbsp;Giảm Giá Sản Phẩm @if(empty($productdata['id']))(00.0) [%]@endif</label>
                  <input type="number" min="0" max="100" step="0.1" class="form-control" name="product_discount" id="product_discount" placeholder="nhập khoản giảm giá..."
                  @if (!empty($productdata['product_discount'])) value="{{ $productdata['product_discount'] }}"
                  @else value="{{ old("product_discount") }}"
                  @endif>
                  @if(!empty($productdata['product_discount']))
                    <div style="color: grey">&nbsp;&nbsp;giảm giá hiện tại =  {{ $productdata['product_discount'] }} [%]</div>
                  @elseif(!empty($productdata['id']))
                    <div style="color: grey">&nbsp;&nbsp;giảm giá hiện tại =  0 [%]</div>
                  @endif
                </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="product_video">&nbsp;Link Video Demo Sản Phẩm [Link Youtube]</label>
                    <div style="padding-top: 10px; padding-bottom: 10px; text-align: center;"><img style="width: 580px;" src="{{ asset('images/admin_images/example-iframe-embed.png') }}"></div>
                    <input type="text" class="form-control" name="product_video" id="product_video" placeholder="nhập đường dẫn..."
                    @if (!empty($productdata['product_video'])) value="{{ $productdata['product_video'] }}"
                    @else value="{{ old("product_video") }}"
                    @endif>
                  </div>
                  <div class="form-group">
                    <label for="meta_description">&nbsp;Metadata Description [SEO]</label>
                    <textarea name="meta_description" id="meta_description" class="form-control" rows="3" placeholder="nhập meta description cho SEO...">@if (!empty($productdata['meta_description'])) {{ $productdata['meta_description'] }}@else {{ old("meta_description") }}@endif
                  </textarea>
                </div>
                </div>
                <div class="col-md-6" style="display: flex; flex-direction: column;">
                  <div class="form-group" style="width: 100%;">
                    <label for="is_featured">&nbsp;Sản Phẩm Nổi Bật: Có/Không</label>
                    <input type="checkbox" name="is_featured" id="is_featured" value="Yes" @if(!empty($productdata['is_featured']) && $productdata['is_featured']=="Yes") checked="" @endif>
                  </textarea>
                  </div>
                  <div class="form-group" style="width: 100%;">
                    <label for="is_exclusive">&nbsp;Sản Phẩm Độc Quyền: Có/Không</label>
                    <input type="checkbox" name="is_exclusive" id="is_exclusive" value="Yes" @if(!empty($productdata['is_exclusive']) && $productdata['is_exclusive']=="Yes") checked="" @endif>
                  </textarea>
                  </div>
                  <div class="form-group">
                    <label for="product_info">&nbsp;Tính Năng Sản Phẩm @if(empty($productdata['section_id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <textarea name="product_info" id="product_info" class="form-control mce" rows="3" placeholder="nhập tính năng sản phẩm...">@if (!empty($productdata['product_info'])) {{ $productdata['product_info'] }}@else {{ old("product_info") }}@endif
                    </textarea>
                  </div>
                  <div class="form-group">
                    <label for="product_description">&nbsp;Mô Tả Sản Phẩm @if(empty($productdata['section_id']))<span class="required" aria-hidden="true">*</span>@endif</label>
                    <textarea name="product_description" id="product_description" class="form-control mce" rows="3" placeholder=" nhập mô tả sản phẩm...">@if (!empty($productdata['product_description'])) {{ $productdata['product_description'] }}@else {{ old("product_description") }}@endif
                    </textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="meta_keywords">&nbsp;Metadata Keywords [SEO]</label>
                    <textarea name="meta_keywords" id="meta_keywords" class="form-control" rows="3" placeholder="nhập meta keywords cho SEO...">@if (!empty($productdata['meta_keywords'])) {{ $productdata['meta_keywords'] }}@else {{ old("meta_keywords") }}@endif
                  </textarea>
                </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="meta-title">&nbsp;Metadata Title [SEO]</label>
                    <textarea name="meta_title" id="meta_title" class="form-control" rows="3" placeholder="nhập meta title cho SEO...">@if (!empty($productdata['meta_title'])) {{ $productdata['meta_title'] }}@else {{ old("meta_title") }}@endif
                  </textarea>
                  </div>
                </div>
              </div>
          </div>
        </form>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" id="admin-btn" style="font-size: 1.0rem;">{{ $title }}</button>
            </div>
            </div>
          </div><div style="color: #f4f6f9; font-size: 0.5rem; margin: none; padding: none;">dummy text margin</div>
        </div>
      </div>
    </section>
  </div>
@endsection