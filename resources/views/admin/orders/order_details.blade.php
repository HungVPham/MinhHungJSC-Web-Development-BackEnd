@extends('layouts.admin_layout.admin_layout')
@section('content')
<?php use App\Product; ?>
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
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="color: var(--Positive-Green); background-color: #ffffff; border: 1px solid var(--Positive-Green)">
              {{ Session::get('success_message') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            {{ Session::forget('success_message') }}
        @endif
        @if (Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="color: var(--Delete-Red); background-color: #ffffff; border: 1px solid var(--Delete-Red);">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;●&nbsp;&nbsp;{{ Session::get('error_message') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span style="color: var(--Delete-Red);" aria-hidden="true">&times;</span>
              </button>
            </div>
        @endif
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Thương Mại</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}" id="admin-home">Trang Chủ</a></li>
              <li class="breadcrumb-item active">Thông Tin Đơn Mua #{{ $orderDetails['id'] }}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

     <!-- Main content -->
     <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Thông Tin Đơn Mua</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>Ngày Đặt: </td>
                      <td style="text-align: left !important">{{ date('d-m-Y', strtotime($orderDetails['created_at'])) }}</td>
                  </tr>
                  <tr>
                      <td><b>Trạng Thái:</b></td>
                      <td style="text-align: left !important">
                          @if($orderDetails['order_status'] ==  "New")
                          <b style="color: var(--MaxPro-Orange)">chờ xác nhận</b>
                          @endif
                          @if($orderDetails['order_status'] ==  "Pending")
                          <b style="color: var(--Info-Yellow)">đang giao hàng</b>
                          @endif
                          @if($orderDetails['order_status'] ==  "Completed")
                          <b style="color: #228B22;">đã giao hàng</b>
                          @endif
                          @if($orderDetails['order_status'] ==  "Cancelled")
                          <b style="color: var(--MinhHung-Red)">đã hủy</b>
                          @endif
                      </td>
                  </tr>
                  @if(!empty($orderDetails['courier_name']) && !empty($orderDetails['tracking_number']))
                  <tr>
                      <td><b>Đại Lý Giao Hàng:</b></td>
                      <td style="text-align: left !important">{{ $orderDetails['courier_name'] }}</td>
                  </tr>
                  <tr>
                      <td><b>Số Tracking:</b></td>
                      <td style="text-align: left !important">{{ $orderDetails['tracking_number'] }}</td>
                  </tr>
                  @endif
                  <tr>
                      <td>Phí Giao Hàng: </td>
                      <td style="text-align: left !important">
                          <?php 
                          $shipping_charges = $orderDetails['shipping_charges'];
                          $format = number_format($shipping_charges,0,",",".");
                          echo $format;
                          ?> ₫ 
                      </td>
                  </tr>
                  <tr>
                      <td>Mã Khuyến Mãi: </td>
                     
                      <td style="text-align: left !important">
                          @if($orderDetails['coupon_code'] ==  NULL)
                          không áp dụng
                          @else
                          {{ $orderDetails['coupon_code'] }}
                          @endif
                      </td>
                  </tr>
                  <tr>
                      <td>Giá Trị Khuyến Mãi: </td>
                      <td style="text-align: left !important">
                          @if($orderDetails['coupon_amount'] ==  NULL)
                          0 ₫
                          @else
                          <?php 
                          $coupon_amount = $orderDetails['coupon_amount'];
                          $format = number_format($coupon_amount,0,",",".");
                          echo $format;
                          ?> ₫ 
                          @endif
                      </td>
                  </tr>
                  <tr>
                      <td>Tổng Giá Trị: </td>
                      <td style="text-align: left !important">
                          <?php 
                          $grand_total = $orderDetails['grand_total'];
                          $format = number_format($grand_total,0,",",".");
                          echo $format;
                          ?> ₫ 
                      </td>
                  </tr>
                  <tr>
                      <td>Phương Thức Thanh Toán: </td>
                      <td style="text-align: left !important"> 
                           @if($orderDetails['payment_method'] == "COD")
                          thanh toán khi nhận hàng
                          @else
                          chuyển khoản
                          @endif         
                      </td>
                  </tr>
                  <tr>
                    <td>Ghi chú đơn hàng: </td>
                    <td  style="text-align: left !important">
                        @if(!empty($orderDetails['note']))
                        {{ $orderDetails['note']}} 
                        @else
                        không có ghi chú
                        @endif
                    </td>
                </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Thông Tin Giao Hàng</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>Địa Chỉ:</td>
                      <td style="text-align: left !important">{{ $orderDetails['address'] }}</td>
                  </tr>
                  <tr>
                      <td>Phường/Xã:</td>
                      <td style="text-align: left !important">{{ $orderDetails['ward'] }}</td>
                  </tr>
                  <tr>
                      <td>Quận/Huyện:</td>
                      <td style="text-align: left !important">{{ $orderDetails['district'] }}</td>
                  </tr>
                  <tr>
                      <td>Tỉnh/Thành Phố:</td>
                      <td style="text-align: left !important">{{ $orderDetails['province'] }}</td>
                  </tr>
                  <tr>
                      <td>Tên Người Nhận Hàng:</td>
                      <td style="text-align: left !important">{{ $orderDetails['name'] }}</td>
                  </tr>
                  @if($userDetails == Null)
                  <tr>
                    <td>Email Liên Hệ:</td>
                    <td style="text-align: left !important">{{ $orderDetails['email'] }}</td>
                  </tr>
                  @endif
                  <tr>
                      <td style="width: fit-content">Số Điện Thoại Liên Hệ:</td>
                      <td style="text-align: left !important">{{ $orderDetails['mobile'] }}</td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          @if($userDetails != Null)
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Thông Tin Khách Hàng</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>ID Khách Hàng:</td>
                      <td style="text-align: left !important">{{ $userDetails['id'] }}</td>
                  </tr>
                    <tr>
                      <td>Họ Tên:</td>
                      <td style="text-align: left !important">{{ $userDetails['last_name'] }} {{ $userDetails['name'] }}</td>
                  </tr>
                  <tr>
                      <td style="width: fit-content">Email:</td>
                      <td style="text-align: left !important">{{ $userDetails['email'] }}</td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Địa Chỉ Thanh Toán (Billing Address)</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                  <tr>
                    <td>Thôn/Xóm/Số Nhà:</td>
                    <td style="text-align: left !important">{{ $userDetails['address'] }}</td>
                  </tr>
                  <tr>
                      <td>Phường/Xã:</td>
                      <td style="text-align: left !important">{{ $userDetails['ward'] }}</td>
                  </tr>
                  <tr>
                      <td>Quận/Huyện:</td>
                      <td style="text-align: left !important">{{ $userDetails['district'] }}</td>
                  </tr>
                  <tr>
                      <td>Tỉnh/Thành Phố:</td>
                      <td style="text-align: left !important">{{ $userDetails['province'] }}</td>
                  </tr>
                  <tr>
                    <td>Số Điện Thoại:</td>
                    <td style="text-align: left !important">{{ $userDetails['mobile'] }}</td>
                </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>

            @if(!empty($userDetails['company_name']))
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Khách Đại Diện Doanh Nghiệp</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                  <tr>
                    <td>Tên Doanh Nghiệp:</td>
                    <td style="text-align: left !important">{{ $userDetails['company_name'] }}</td>
                  </tr>
                  <tr>
                      <td>Email Doanh Nghiệp:</td>
                      <td style="text-align: left !important">{{ $userDetails['company_email'] }}</td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            @endif


          @endif

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Cập Nhận Trạng Thái Đơn Mua</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered">
                <tbody>
                <tr>
                  <td colspan=2>
                    <form action="{{ url('admin/update-order-status') }}" method="post">@csrf
                      <input type="hidden" name="order_id" value="{{ $orderDetails['id'] }}">
                      @if($userDetails != Null)
                      <input type="hidden" name="email" value="{{ $userDetails['email'] }}">
                      <input type="hidden" name="name" value="{{ $userDetails['name'] }}">
                      @else
                      <input type="hidden" name="email" value="{{ $orderDetails['email'] }}">
                      <input type="hidden" name="name" value="{{ $orderDetails['name'] }}">
                      @endif
                      <select style="width: 100%;" name="order_status" id="order_status" required="" class="form-control select2">
                      <option value="">chọn trạng thái...</option>
                      @foreach($orderStatuses as $status)
                      <option value="{{ $status['name'] }}" @if(isset($orderDetails['order_status']) && $orderDetails['order_status'] == $status['name']) selected="" @endif>
                        @if($status['name'] == "New")
                        chờ xác nhận
                        @endif
                        @if($status['name'] == "Pending")
                        đang giao hàng
                        @endif
                        @if($status['name'] == "Completed")
                        đã giao hàng
                        @endif
                        @if($status['name'] == "Cancelled")
                        đã hủy
                        @endif
                      </option>
                      @endforeach
                    </select>
                    <div @if(empty($orderDetails['courier_name'])) id="delivery_options" @endif>
                      <br>
                      Đại lý/Số Tracking:
                      <input value="{{ $orderDetails['courier_name'] }}" style="width: 120px;" type="text" name="courier_name" placeholder="tên đại lý">
                      <input value="{{ $orderDetails['tracking_number'] }}" style="width: 120px;" type="text" name="tracking_number" placeholder="số tracking">
                    </div>
                    <br>
                    Phí Giao Hàng:
                    <input value="{{ $orderDetails['shipping_charges'] }}" style="width: 120px;" type="text" name="shipping_charges" placeholder="phí vận chuyển">
                    &nbsp;phí hiện tại: <?php echo number_format($orderDetails['shipping_charges'],0,",","."); ?> ₫ 
                    <hr>
                    <button type="submit" class="btn btn-primary" id="admin-btn" style="font-size: 1.0rem;">Cập Nhật</button>
                  </form>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <h5>Lịch Sử Cập Nhật Trạng Thái</h5>
                    @if(!empty($orderLog))
                      @foreach($orderLog as $key => $log)
                      @if($key == 0)
                      gần nhất: <br>
                      @endif
                      <strong>
                        @if($log['order_status'] == "New")
                        chờ xác nhận
                        @endif
                        @if($log['order_status'] == "Pending")
                        đang giao hàng
                        @endif
                        @if($log['order_status'] == "Completed")
                        đã giao hàng
                        @endif
                        @if($log['order_status'] == "Cancelled")
                        đã hủy
                        @endif
                      </strong>
                      <br>
                      {{ date('d/m/Y \v\à\o\ \l\ú\c\ H:i', strtotime($log['created_at'])) }}
                      <hr>
                      @endforeach
                    @else
                    không có lịch sử cập nhật
                    @endif
                  </td>
                </tr>
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
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Sản Phẩm Trong Đơn Mua</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Tên Sản Phẩm</th>
                      <th>Hình Ảnh</th>
                      <th>Phân Loại</th>
                      <th>Số Lượng</th>   
                      <th>Trị Giá</th>         
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($orderDetails['orders_products'] as $product)
                            <tr>
                                <td>
                                  {{ $product['product_name'] }}    
                                </td>
                                <td><?php $getProductImage = Product::getProductImage($product['product_id']) ?>
                                <img style="width: 50%" src="{{ asset('images/product_images/main_image/small/'.$getProductImage) }}"></td>
                                <td>
                                    {{ $product['sku'] }}                          
                                </td>
                                <td>{{ $product['product_qty'] }}</td>
                                <td>
                                    <?php 
                                    $grand_total = $product['product_price'];
                                    $format = number_format($grand_total,0,",",".");
                                     echo $format;
                                    ?> ₫ 
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
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->


</div>

@endsection