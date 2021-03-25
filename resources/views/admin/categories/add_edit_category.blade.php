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
              <li class="breadcrumb-item active">Thêm Thể Loại SP</li>
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
        <form name="categoryForm" id="CategoryForm" action="{{ url('admin/add-edit-category') }}" method="post" enctype="multipart/form-data">@csrf
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Thêm Thể Loại Sản Phẩm</h3>

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
                      <input type="text" class="form-control" name="category_name" id="category_name" placeholder="nhập tên thể loại sản phẩm...">
                  </div>
                  <div id="appendCategoriesLevel">
                    @include('admin.categories.append_categories_level')
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                <div class="form-group">
                    <label>Danh Mục của Thể Loại</label>
                    <select name="section_id" id="section_id" class="form-control select2" style="width: 100%;">
                      <option value="">Chọn danh mục...</option>
                      @foreach($getSections as $section)
                      <option value="{{ $section->id }}">{{ $section->name }}</option>
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
                      <label for="category_name">Giảm Giá toàn Thể Loại</label>
                      <input type="text" class="form-control" name="category_discount" id="category_discount" placeholder="nhập khoản giảm giá...">
                  </div>
                  <div class="form-group">
                      <label for="category_name">Mô Tả Thể Loại</label>
                      <textarea name="category_description" id="category_description" class="form-control" rows="3" placeholder=" nhập mô tả thể loại..."></textarea>
                  </div>
                  <!-- /.form-group -->
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                      <label for="category_name">URL Thể Loại</label>
                      <input name="url" id="url" type="text" class="form-control" placeholder="nhập URL thể loại...">
                  </div>
                  <div class="form-group">
                      <label for="category_name">Metadata Title (Cho SEO)</label>
                      <textarea name="meta_title" id="meta_title" class="form-control" rows="3" placeholder="nhập meta title cho SEO..."></textarea>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                      <label for="category_name">Metadata Keywords (Cho SEO)</label>
                      <textarea name="meta_keywords" id="meta_keywords" class="form-control" rows="3" placeholder="nhập meta keywords cho SEO..."></textarea>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                      <label for="category_name">Metadata Description (Cho SEO)</label>
                      <textarea name="meta_description" id="meta_description" class="form-control" rows="3" placeholder="nhập meta description cho SEO..."></textarea>
                  </div>
                </div>
              </div>
              <!-- /.row -->
          </div>
        </form>
              <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" id="admin-btn" style="font-size: 1.0rem;">Thêm Thể Loại SP</button>
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