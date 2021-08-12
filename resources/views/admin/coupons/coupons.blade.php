@extends('layouts.admin_layout.admin_layout')
@section('content')
<style>
    .page-item.active .page-link {background-color: var(--MinhHung-Red);border-color: var(--MinhHung-Red);}
    .page-item.active .page-link:focus{box-shadow: none;} 
    .dropdown-item.active, .dropdown-item:active {background-color: var(--MinhHung-Red);}
    .page-item .page-link {color: #333}
    .page-item .page-link:focus{box-shadow: none}
    .updateBrandStatus:hover{color: #4c5158 !important}
    #admin-btn{max-width: 180px; float: right; display: inline-block; background-color: var(--MinhHung-Red); border-color: var(--MinhHung-Red); font-size: 1.0rem}
    #deleteCoupon{color:var(--Delete-Red)}
    #deleteCoupon:hover{color: var(--MinhHung-Red-Hover)}
    #updateCoupon{color: #000000;}
    #updateCoupon:hover{color:#4c5158;}
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
            <h1>Thương Mại</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}" id="admin-home">Trang Chủ</a></li>
              <li class="breadcrumb-item active">Coupons Khuyến Mãi</li>
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
                <h3 class="card-title">Coupons Khuyến Mãi</h3>
                <a href="{{ url('admin/add-edit-coupon') }}" class="btn btn-block btn-success" id="admin-btn">Thêm Coupon</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Thể Lệ</th>
                    <th>Giá Trị Giảm</th>
                    <th>Hết Hạn</th>
                    <th>Trạng Thái</th>
                    <th>Điều Khiển</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($coupons as $coupon)
                  <tr>
                    <td>{{ $coupon['id'] }}</td>
                    <td>{{ $coupon['coupon_code'] }}</td>
                    <td>
                      @if($coupon['coupon_type']=="Single")
                      Dùng Một Lần
                      @else
                      Dùng Nhiều Lần
                      @endif
                    </td>
                    <td>
                        @if($coupon['amount_type']=="Percentage")
                            {{ $coupon['amount'] }}%
                        @else
                            <?php 
                            $num = $coupon['amount'];
                            $format = number_format($num,0,",",".");
                            echo $format;
                            ?>₫
                        @endif
                    </td>
                    <td>{{ $coupon['expiry_date'] }}</td>
                    <td style="width: 135px;">
                      @if ($coupon['status']==1)
                      <a class="updateCouponStatus" id="coupon-{{ $coupon['id'] }}" coupon_id="{{ $coupon['id'] }}" href="javascript:void(0)"><i id="active"  status="Active" style="color: var(--Positive-Green); font-size: 1.05rem;" class="fas fa-toggle-on" aria-hidden="true"> đang hoạt động</i></a>   
                      @elseif ($coupon['status']==0)
                      <a class="updateCouponStatus" id="coupon-{{ $coupon['id'] }}" coupon_id="{{ $coupon['id'] }}" href="javascript:void(0)"><i id="inactive" status="Inactive" style="color: var(--Delete-Red); font-size: 1.05rem;" class="fas fa-toggle-off" aria-hidden="true"> chưa hoạt động</i></a> 
                      @endif
                    </td>
                    <td style="width: 50px;">
                      <a title="sửa Thương Hiệu" id="updateCoupon" href="{{ url('admin/add-edit-coupon/'.$coupon['id']) }}"><i class="fas fa-edit"></i></a>
                      &nbsp; &nbsp;<a title="xóa Thương Hiệu" href="javascript:void(0)" class="confirmDelete" record="coupon" recordid="{{ $coupon['id'] }}"  class="confirmDelete" id="deleteCoupon"><i class="fas fa-trash"></i></a>
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