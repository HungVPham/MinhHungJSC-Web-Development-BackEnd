@extends('layouts.admin_layout.admin_layout')
@section('content')

<style>
    .page-item.active .page-link {background-color: var(--MinhHung-Red);border-color: var(--MinhHung-Red)}
    .page-item.active .page-link:focus{box-shadow: none;} 
    .dropdown-item.active, .dropdown-item:active {background-color: var(--MinhHung-Red)}
    .page-item .page-link {color: #333}
    .page-item .page-link:focus{box-shadow: none}
    .updateProductStatus:hover{color: #4c5158 !important}
    #updateorder{color: #000000;}
    #updateorder:hover{color: #4c5158;}
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
              <li class="breadcrumb-item active">Đơn Mua</li>
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
                <h3 class="card-title">Đơn Mua</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Ngày Đặt</th>
                    <th>Tên Khách Hàng</th>
                    <th>Email Liên Hệ</th>
                    <th>Số Liên Hệ</th>
                    <th>Sản Phẩm/Số Lượng</th>
                    <th>Trị Giá</th>
                    <th>Trạng Thái</th>
                    <th>Thanh Toán</th>
                    <th>Điều Khiển</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($orders as $order)
                  <tr>
                    <td>{{ $order['id'] }}</td>
                    <td>{{ date('d-m-Y', strtotime($order['created_at'])) }}</td>
                    @foreach($userDetails as $user)
                      @if($user['id'] == $order['user_id'])
                        <td>
                            {{ $user['last_name'] }} {{ $user['name'] }}
                            <br>
                            @if(!empty($user['company_name']))
                            (đại diện doanh nghiệp)
                            @endif  
                        </td>
                      @endif
                    @endforeach
                    @if($order['user_id'] == null)
                    <td>khách không có tài khoản</td>
                    @endif
                    <td>{{ $order['email'] }}</td>
                    <td>{{ $order['mobile'] }}</td>
                    <td>
                      @foreach($order['orders_products'] as $pro)
                      &#9900; {{ $pro['sku'] }} <b> x {{ $pro['product_qty']}}</b><br>
                      @endforeach
                    </td>
                    <td>
                      <?php 
                      $grand_total = $order['grand_total'];
                      $format = number_format($grand_total,0,",",".");
                       echo $format;
                      ?> ₫ 
                    </td>
                    <td>
                      @if($order['order_status'] ==  "New")
                      <b style="color: var(--MaxPro-Orange)">chờ xác nhận</b>
                      @endif
                      @if($order['order_status'] ==  "Pending")
                      <b style="color: var(--Info-Yellow)">đang giao hàng</b>
                      @endif
                      @if($order['order_status'] ==  "Completed")
                      <b style="color: #228B22;">đã giao hàng</b>
                      @endif
                      @if($order['order_status'] ==  "Cancelled")
                      <b style="color: var(--MinhHung-Red)">đã hủy</b>
                      @endif
                    </td>
                    <td>
                      @if($order['payment_method'] == "COD")
                      thanh toán khi nhận hàng
                      @else
                      chuyển khoản
                      @endif     
                    </td>
                    <td>
                      &nbsp;&nbsp;<a title="xem chi tiết đơn mua" id="updateorder" href="{{ url('admin/orders/'.$order['id']) }}"><i class="fas fa-edit"></i></a>
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