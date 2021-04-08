@extends('layouts.admin_layout.admin_layout')
@section('content')
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
                            <option value="{{ $subcategory['id'] }}"> --- {{ $subcategory['category_name'] }}</option>
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
                  <label for="product_price">Giá Sản Phẩm (x,000.00) [VND]</label>
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
                  </div>
                  <div class="form-group">
                    <label for="section_id">Chọn hiệu điện thế [V]</label>
                    <select name="maxpro_voltage" id="maxpro_voltage" class="form-control select2" style="width: 100%;">
                      <option value="">Chọn điện thế...</option>
                      @foreach($maxpro_voltageArray as $voltage)
                      <option value="{{ $voltage }}">{{ $voltage }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                      <label for="product_description">Mô Tả Sản Phẩm</label>
                      <textarea name="product_description" id="product_description" class="form-control" rows="3" placeholder=" nhập mô tả sản phẩm...">@if (!empty($productdata['product_description'])) {{ $productdata['product_description'] }}@else {{ old("product_description") }}@endif
                      </textarea>
                  </div>
                  <!-- /.form-group -->
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="exampleInputFile">Video Sản Phẩm</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="product_video" id="product_video" accept="video/mp4,video/x-m4v,video/*">
                        <label class="custom-file-label" for="product_video">chọn video...</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="section_id">Chọn công suất điện [W]</label>
                    <select name="maxpro_power" id="maxpro_power" class="form-control select2" style="width: 100%;">
                      <option value="">Chọn công suất...</option>
                      @foreach($maxpro_powerArray as $power)
                      <option value="{{ $power }}">{{ $power }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                      <label for="meta-title">Metadata Title [SEO]</label>
                      <textarea name="meta_title" id="meta_title" class="form-control" rows="3" placeholder="nhập meta title cho SEO...">@if (!empty($productdata['meta_title'])) {{ $productdata['meta_title'] }}@else {{ old("meta_title") }}@endif
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
                    <label for="meta_keywords">Sản Phẩm Nổi Bật: Có/Không</label>
                    <input type="checkbox" name="is_featured" id="is_featured" value="1">
                  </textarea>
                </div>
                </div>
                <div class="col-12 col-sm-6">
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