@extends('layouts.admin_layout.admin_layout')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Danh Mục</h1>
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
        <form name="categoryForm" id="CategoryForm" 
          @if(empty($categorydata['id'])) 
            action="{{ url('admin/add-edit-category') }}" 
          @else
            action="{{ url('admin/add-edit-category/'.$categorydata['id']) }}" 
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
                  <!-- /.form-group -->
                  <div class="form-group">
                      <label for="category_name">Tên Thể Loại Sản Phẩm</label>
                      <input type="text" class="form-control" name="category_name" id="category_name" placeholder="nhập tên thể loại sản phẩm..."
                      @if (!empty($categorydata['category_name'])) value="{{ $categorydata['category_name'] }}"
                      @else value="{{ old("category_name") }}"
                      @endif>
                  </div>
                  <div id="appendCategoriesLevel">
                    @include('admin.categories.append_categories_level')
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                <div class="form-group">
                    <label for="section_id">Danh Mục của Thể Loại</label>
                    <select name="section_id" id="section_id" class="form-control select2" style="width: 100%;">
                      <option value="">Chọn danh mục...</option>
                      @foreach($getSections as $section)
                      <option value="{{ $section->id }}" @if(!empty($categorydata['section_id']) && $categorydata['section_id']==$section->id) selected @endif>{{ $section->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="row">
                <div class="col-12 col-sm-6">
                  <!-- /.form-group -->
                  <div class="form-group">
                      <label for="category_discount">Giảm Giá toàn Thể Loại</label>
                      <input type="text" class="form-control" name="category_discount" id="category_discount" placeholder="nhập khoản giảm giá..."
                      @if (!empty($categorydata['category_discount'])) value="{{ $categorydata['category_discount'] }}"
                      @else value="{{ old("category_discount") }}"
                      @endif>
                  </div>
                  <div class="form-group">
                      <label for="category_description">Mô Tả Thể Loại</label>
                      <textarea name="category_description" id="category_description" class="form-control" rows="3" placeholder=" nhập mô tả thể loại...">@if (!empty($categorydata['category_description'])) {{ $categorydata['category_description'] }}@else {{ old("category_description") }}@endif
                      </textarea>
                  </div>
                  <!-- /.form-group -->
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                      <label for="url">URL Thể Loại</label>
                      <input name="url" id="url" type="text" class="form-control" placeholder="nhập URL thể loại..."
                      @if (!empty($categorydata['url'])) value="{{ $categorydata['url'] }}"
                      @else value="{{ old("url") }}"
                      @endif>
                  </div>
                  <div class="form-group">
                      <label for="meta-title">Metadata Title (Cho SEO)</label>
                      <textarea name="meta_title" id="meta_title" class="form-control" rows="3" placeholder="nhập meta title cho SEO...">@if (!empty($categorydata['meta_title'])) {{ $categorydata['meta_title'] }}@else {{ old("meta_title") }}@endif
                    </textarea>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                      <label for="meta_keywords">Metadata Keywords (Cho SEO)</label>
                      <textarea name="meta_keywords" id="meta_keywords" class="form-control" rows="3" placeholder="nhập meta keywords cho SEO...">@if (!empty($categorydata['meta_keywords'])) {{ $categorydata['meta_keywords'] }}@else {{ old("meta_keywords") }}@endif
                    </textarea>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                      <label for="meta_description">Metadata Description (Cho SEO)</label>
                      <textarea name="meta_description" id="meta_description" class="form-control" rows="3" placeholder="nhập meta description cho SEO...">@if (!empty($categorydata['meta_description'])) {{ $categorydata['meta_description'] }}@else {{ old("meta_description") }}@endif
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