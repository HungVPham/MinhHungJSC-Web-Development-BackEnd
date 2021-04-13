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
        <form name="productForm" id="ProductForm" 
          @if(empty($productdata['id'])) 
            action="{{ url('admin/add-edit-product') }}" 
          @else
            action="{{ url('admin/add-edit-product/'.$productdata['id']) }}" 
          @endif
          method="post" enctype="multipart/form-data">@csrf
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">{{ $title }}</h3>

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
                    <label for="section_id">Thể Loại Cấp (0)</label>
                    <select name="category_id" id="category_id" class="form-control select2" style="width: 100%;">
                      <option value="">Chọn danh mục...</option>
                      @foreach($categories as $section)
                        <optgroup label="{{ $section['name'] }}"></optgroup>
                        @foreach($section['categories'] as $category)
                          <option disabled value="{{ $category['id'] }}"> {{ $category['category_name'] }}</option>
                          @foreach($category['subcategories'] as $subcategory)
                            <option value="{{ $subcategory['id'] }}" @if(!empty(@old('category_id')) && $subcategory['id'] ==@old('category_id')) selected=""@elseif(!empty($productdata['category_id']) && $productdata['category_id']==$subcategory['id']) selected="" @endif>&nbsp;&nbsp;---&nbsp;&nbsp;{{ $subcategory['category_name'] }}</option>
                          @endforeach
                        @endforeach
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="product_name">Tên Sản Phẩm</label>
                    <input type="text" class="form-control" name="product_name" id="product_name" placeholder="nhập tên..."
                    @if (!empty($productdata['product_name'])) value="{{ $productdata['product_name'] }}"
                    @else value="{{ old("product_name") }}"
                    @endif>
                </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="product_code">Mã Sản Phẩm</label>
                    <input type="text" class="form-control" name="product_code" id="product_code" placeholder="nhập mã..."
                    @if (!empty($productdata['product_code'])) value="{{ $productdata['product_code'] }}"
                    @else value="{{ old("product_code") }}"
                    @endif>
                  </div>
                  <div class="form-group">
                    <label for="product_weight">Trọng Lượng Sản Phẩm [Kg]</label>
                    <input type="text" class="form-control" name="product_weight" id="product_weight" placeholder="nhập trọng lượng..."
                    @if (!empty($productdata['product_weight'])) value="{{ $productdata['product_weight'] }}"
                    @else value="{{ old("product_weight") }}"
                    @endif>
                  </div>
                </div>
                </div>
                <!-- /.col -->
              <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="product_price">Giá Sản Phẩm (1000000 &#8594; 1,000,000) [VND]</label>
                  <input type="text" class="form-control" name="product_price" id="product_price" placeholder="nhập giá..."
                  @if (!empty($productdata['product_price'])) value="{{ $productdata['product_price'] }}"
                  @else value="{{ old("product_price") }}"
                  @endif>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label for="product_discount">Giảm Giá Sản Phẩm [%]</label>
                  <input type="text" class="form-control" name="product_discount" id="product_discount" placeholder="nhập khoản giảm giá..."
                  @if (!empty($productdata['product_discount'])) value="{{ $productdata['product_discount'] }}"
                  @else value="{{ old("product_discount") }}"
                  @endif>
                </div>
              </div>
              </div>
              <!-- /.row -->
              <div class="row">
                <div class="col-12 col-sm-6">
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label for="exampleInputFile">Hình Ảnh Sản Phẩm v0</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="main_image" id="main_image" accept="image/*">
                        <label class="custom-file-label" for="main_image">chọn hình ảnh...</label>
                      </div>
                    </div>
                    <div style="color: grey">Độ phân giải đề xuất (750x650)</div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Hình Ảnh Sản Phẩm v1</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image_v1" id="image_v1" accept="image/*">
                        <label class="custom-file-label" for="image_v1">chọn hình ảnh...</label>
                      </div>
                    </div>
                    <div style="color: grey">Độ phân giải đề xuất (750x650)</div>
                  </div>
                  <div class="maxpro-container" style="border: 3px solid #db880d; padding-left: 10px; padding-right: 10px; margin-bottom: 10px;">
                    <div class="form-group">
                      <label for="section_id">Chọn hiệu điện thế [V] (SP MaxPro Tools)</label>
                      <select name="maxpro_voltage" id="maxpro_voltage" class="form-control select2" style="width: 100%;">
                        <option value="">Chọn điện thế...</option>
                        @foreach($maxpro_voltageArray as $voltage)
                        <option value="{{ $voltage }}" @if(!empty($productdata['maxpro_voltage']) && $productdata['maxpro_voltage']==$voltage) selected="" @endif>{{ $voltage }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="section_id">Chọn công suất điện [W] (SP MaxPro Tools)</label>
                      <select name="maxpro_power" id="maxpro_power" class="form-control select2" style="width: 100%;">
                        <option value="">Chọn công suất...</option>
                        @foreach($maxpro_powerArray as $power)
                        <option value="{{ $power }}" @if(!empty($productdata['maxpro_power']) && $productdata['maxpro_power']==$power) selected="" @endif>{{ $power }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="hhose-container" style="border: 3px solid #efe649; padding-left: 10px; padding-right: 10px;">
                    <div class="form-group">
                      <label for="section_id">Chọn đường kính [Inch] (SP Ống Tuy Ô - Thủy Lực)</label>
                      <select name="hhose_diameter" id="hhose_diameter" class="form-control select2" style="width: 100%;">
                        <option value="">Chọn đường kính...</option>
                        @foreach($hhose_diameterArray as $diameter)
                        <option value="{{ $diameter }}" @if(!empty($productdata['hhose_diameter']) && $productdata['hhose_diameter']==$diameter) selected="" @endif>{{ $diameter }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="hhose_spflex_embossed">SP Flex (In Nổi): Có/Không</label>
                      <input type="checkbox" name="hhose_spflex_embossed" id="hhose_spflex_embossed" value="Yes" @if(!empty($productdata['hhose_spflex_embossed']) && $productdata['hhose_spflex_embossed']=="Yes") checked="" @endif>
                    </div>
                    <div class="form-group">
                      <label for="hhose_spflex_smoothtexture">SP Flex (Da Trơn): Có/Không</label>
                      <input type="checkbox" name="hhose_spflex_smoothtexture" id="hhose_spflex_smoothtexture" value="Yes" @if(!empty($productdata['hhose_spflex_smoothtexture']) && $productdata['hhose_spflex_smoothtexture']=="Yes") checked="" @endif>
                    </div>
                  </div>
                  <!-- /.form-group -->
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="exampleInputFile">Hình Ảnh Sản Phẩm v2</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image_v2" id="image_v2" accept="image/*">
                        <label class="custom-file-label" for="image_v2">chọn hình ảnh...</label>
                      </div>
                    </div>
                    <div style="color: grey">Độ phân giải đề xuất (750x650)</div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Hình Ảnh Sản Phẩm v3</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image_v3" id="image_v3" accept="image/*">
                        <label class="custom-file-label" for="image_v3">chọn hình ảnh...</label>
                      </div>
                    </div>
                    <div style="color: grey">Độ phân giải đề xuất (750x650)</div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Video Demo Sản Phẩm</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="product_video" id="product_video" accept="video/mp4,video/x-m4v,video/*">
                        <label class="custom-file-label" for="product_video">chọn video...</label>
                      </div>
                    </div>
                  </div>
                  <div class="shimge-container" style="border: 3px solid #00a0a8; padding-left: 10px; padding-right: 10px;">
                    <div class="form-group">
                      <label for="section_id">Chọn lưu lượng [m³/h] (SP Shimge Pumps)</label>
                      <select name="shimge_maxflow" id="shimge_maxflow" class="form-control select2" style="width: 100%;">
                        <option value="">Chọn lưu lượng...</option>
                        @foreach($shimge_maxflowArray as $maxflow)
                        <option value="{{ $maxflow }}" @if(!empty($productdata['shimge_maxflow']) && $productdata['shimge_maxflow']==$maxflow) selected="" @endif>{{ $maxflow }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="section_id">Chọn công suất điện [W] (SP Shimge Pumps)</label>
                      <select name="shimge_power" id="shimge_power" class="form-control select2" style="width: 100%;">
                        <option value="">Chọn công suất...</option>
                        @foreach($shimge_powerArray as $power)
                        <option value="{{ $power }}" @if(!empty($productdata['shimge_power']) && $productdata['shimge_power']==$power) selected="" @endif>{{ $power }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="product_description">Mô Tả Sản Phẩm</label>
                    <textarea name="product_description" id="product_description" class="form-control" rows="3" placeholder=" nhập mô tả sản phẩm...">@if (!empty($productdata['product_description'])) {{ $productdata['product_description'] }}@else {{ old("product_description") }}@endif
                    </textarea>
                </div>
                  <div class="form-group">
                    <label for="meta-title">Metadata Title [SEO]</label>
                    <textarea name="meta_title" id="meta_title" class="form-control" rows="3" placeholder="nhập meta title cho SEO...">@if (!empty($productdata['meta_title'])) {{ $productdata['meta_title'] }}@else {{ old("meta_title") }}@endif
                  </textarea>
                </div>
                  <div class="form-group">
                    <label for="is_featured">&nbsp;&nbsp;Sản Phẩm Nổi Bật: Có/Không</label>
                    <input type="checkbox" name="is_featured" id="is_featured" value="Yes" @if(!empty($productdata['is_featured']) && $productdata['is_featured']=="Yes") checked="" @endif>
                  </textarea>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="meta_keywords">Metadata Keywords [SEO]</label>
                    <textarea name="meta_keywords" id="meta_keywords" class="form-control" rows="3" placeholder="nhập meta keywords cho SEO...">@if (!empty($productdata['meta_keywords'])) {{ $productdata['meta_keywords'] }}@else {{ old("meta_keywords") }}@endif
                  </textarea>
                </div>
                  <div class="form-group">
                      <label for="meta_description">Metadata Description [SEO]</label>
                      <textarea name="meta_description" id="meta_description" class="form-control" rows="3" placeholder="nhập meta description cho SEO...">@if (!empty($productdata['meta_description'])) {{ $productdata['meta_description'] }}@else {{ old("meta_description") }}@endif
                    </textarea>
                  </div>
                </div>
              </div>
              <!-- /.row -->
          </div>
        </form>
              <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" id="admin-btn" style="font-size: 1.0rem;">{{ $title }}</button>
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