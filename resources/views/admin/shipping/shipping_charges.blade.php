@extends('layouts.admin_layout.admin_layout')
@section('content')

<style>
    .page-item.active .page-link {background-color: var(--MinhHung-Red);border-color: var(--MinhHung-Red)}
    .page-item.active .page-link:focus{box-shadow: none;} 
    .dropdown-item.active, .dropdown-item:active {background-color: var(--MinhHung-Red)}
    .page-item .page-link {color: #333}
    .page-item .page-link:focus{box-shadow: none}
    .updateProductStatus:hover{color: #4c5158 !important}
    #admin-btn{max-width: 180px; float: right; display: inline-block; background-color: var(--MinhHung-Red); border-color: var(--MinhHung-Red); font-size: 1.0rem}
    #updateshipping{color: #000000;}
    #updateshipping:hover{color: #4c5158;}
    #orderInvoice{color: #000000;}
    #orderInvoice:hover{color: #4c5158;}
    a{color: inherit;}
    .swal2-icon.swal2-warning {border-color:var(--Delete-Red);color:var(--Delete-Red);}
    .swal2-icon.swal2-info {border-color:var(--Info-Yellow);color:var(--Info-Yellow);}
    .card-title{
      font-size: 1.3rem;
    }
    #active:hover{
      color: #4c5158 !important;
    }
    #inactive:hover{
      color: #4c5158 !important;
    }
    #deleteshipping{color:var(--Delete-Red)}
    #deleteshipping:hover{color: var(--MinhHung-Red-Hover)}
</style>
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Thương Mại</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}" id="admin-home">Trang Chủ</a></li>
              <li class="breadcrumb-item active">Phí Giao Hàng</li>
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
                <h3 class="card-title">Phí Giao Hàng</h3>
                <a href="{{ url('admin/add-edit-shipping-charges') }}" class="btn btn-block btn-success" id="admin-btn">Thêm Phí Giao Hàng</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Phường/Xã</th>
                    <th>Quận/Huyện</th>
                    <th>Tỉnh/Thành Phố</th>
                    <th>0-1 kg</th>
                    <th>1-3 kg</th>
                    <th>3-5 kg</th>
                    <th>5-10 kg</th>
                    <th>hơn 10 kg</th>
                    <th>Trạng Thái</th>
                    <th>Điều Khiển</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($shipping_charges as $ship)
                  <tr>
                    <td>{{ $ship['id'] }}</td>
                    <td>{{ $ship['ward'] }}</td>
                    <td>{{ $ship['district'] }}</td>
                    <td>{{ $ship['province'] }}</td>
                    <td>
                      <?php 
                      echo number_format($ship['0_1000g'],0,",",".");
                      ?> ₫
                    </td>
                    <td>
                      <?php 
                      echo number_format($ship['1001_3000g'],0,",",".");
                      ?> ₫
                    </td>
                    <td>
                      <?php 
                      echo number_format($ship['3001_5000g'],0,",",".");
                      ?> ₫
                    </td>
                    <td>
                      <?php 
                      echo number_format($ship['5001_10000g'],0,",",".");
                      ?> ₫
                    </td>
                    <td>
                      <?php 
                      echo number_format($ship['above_10000g'],0,",",".");
                      ?> ₫
                    </td>
                    <td style="width: 135px;">
                        @if ($ship['status'] == 1)
                        <a class="updateShippingStatus" id="shipping-{{ $ship['id'] }}" shipping_id="{{ $ship['id'] }}" href="javascript:void(0)" style="color: var(--Positive-Green);"><i id="active" style="color: var(--Positive-Green); font-size: 1.05rem;"  class="fas fa-toggle-on" aria-hidden="true"> đang hoạt động</i></a>   
                        @elseif ($ship['status'] == 0)
                        <a class="updateShippingStatus" id="shipping-{{ $ship['id'] }}" shipping_id="{{ $ship['id'] }}" href="javascript:void(0)" style="color: var(--Delete-Red);"><i id="inactive" style="color: var(--Delete-Red); font-size: 1.05rem;" class="fas fa-toggle-off" aria-hidden="true"> chưa hoạt động</i></a> 
                        @endif
                    </td>
                    <td> &nbsp;<a title="cập nhật phí giao hàng" id="updateshipping" href="{{ url('admin/add-edit-shipping-charges/'.$ship['id']) }}"><i class="fas fa-edit"></i></a>
                      &nbsp;<a title="xóa phí giao hàng" href="javascript:void(0)" class="confirmDelete" record="shipping-charge" recordid="{{ $ship['id'] }}" id="deleteshipping"><i class="fas fa-trash"></i></a></td>
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