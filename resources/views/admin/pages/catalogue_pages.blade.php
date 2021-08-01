@extends('layouts.admin_layout.admin_layout')
@section('content')
<style>
    .page-item.active .page-link {background-color: var(--MinhHung-Red);border-color: var(--MinhHung-Red);}
    .page-item.active .page-link:focus{box-shadow: none;} 
    .dropdown-item.active, .dropdown-item:active {background-color: var(--MinhHung-Red);}
    .page-item .page-link {color: #333}
    .page-item .page-link:focus{box-shadow: none}
    .updatePageStatus:hover{color: #4c5158 !important}
    #admin-btn{max-width: 200px; float: right; display: inline-block; background-color: var(--MinhHung-Red); border-color: var(--MinhHung-Red); font-size: 1.0rem}
    #deletePage{color:var(--Delete-Red)}
    #deletePage:hover{color: var(--MinhHung-Red-Hover)}
    #updatePage{color: #000000;}
    #updatePage:hover{color:#4c5158;}
    a{color: inherit}
    .swal2-icon.swal2-warning {border-color:var(--Delete-Red);color:var(--Delete-Red);}
    .swal2-icon.swal2-info {border-color:var(--Info-Yellow);color:var(--Info-Yellow);}
    .card-title{
      font-size: 1.3rem;
    }
    b{
      font-weight: 600;
    }
    #active:hover{
      color: #4c5158 !important;
    }
    #inactive:hover{
      color: #4c5158 !important;
    }
</style>
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Nội Dung</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}" id="admin-home">Trang Chủ</a></li>
              <li class="breadcrumb-item active">Booklet Catalogue</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- /.card -->
            @if(Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert" style="color: #228B22; background-color: #ffffff; border: 1px solid #228B22">
                {{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Booklet Catalogue</h3>
                <a href="{{ url('admin/add-edit-catalogue-page') }}" class="btn btn-block btn-success" id="admin-btn">Thêm Booklet Catalogue</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Tựa Đề</th>
                    <th>URL</th>
                    <th>Trạng Thái</th>
                    <th>Điều Khiển</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($catalogue_pages as $catalogue_page)
                  <tr>
                    <td>{{ $catalogue_page->id }}</td>
                    <td>
                        {{ $catalogue_page->title }}
                    </td>
                    <td>
                        {{ $catalogue_page->url }}
                    </td>
                    <td style="width: 135px;">
                      @if ($catalogue_page->status==1)
                      <a class="updateCataloguePageStatus" id="page-{{ $catalogue_page->id }}" page_id="{{ $catalogue_page->id }}" href="javascript:void(0)"><i id="active"  status="Active" style="color: var(--Positive-Green); font-size: 1.05rem;" class="fas fa-toggle-on" aria-hidden="true"> đang hoạt động</i></a>   
                      @elseif ($catalogue_page->status==0)
                      <a class="updateCataloguePageStatus" id="page-{{ $catalogue_page->id }}" page_id="{{ $catalogue_page->id }}" href="javascript:void(0)"><i id="inactive" status="Inactive" style="color: var(--Delete-Red); font-size: 1.05rem;" class="fas fa-toggle-off" aria-hidden="true"> chưa hoạt động</i></a> 
                      @endif
                    </td>
                    <td style="width: 50px;">
                      <a title="sửa booklet catalogue" id="updatePage" href="{{ url('admin/add-edit-catalogue-page/'.$catalogue_page->id) }}"><i class="fas fa-edit"></i></a>
                      &nbsp; &nbsp;<a title="xóa booklet catalogue" href="javascript:void(0)" class="confirmDelete" record="catalogue-page" recordid="{{ $catalogue_page->id }}"  class="confirmDelete" id="deletePage"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection