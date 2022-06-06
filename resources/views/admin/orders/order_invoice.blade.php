<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<style>
  .invoice-title h2, .invoice-title h3 {
    display: inline-block;
}

.table > tbody > tr > .no-line {
    border-top: none;
}

.table > thead > tr > .no-line {
    border-bottom: none;
}

.table > tbody > tr > .thick-line {
    border-top: 2px solid;
}
</style>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2>Hóa Đơn</h2><h3 class="pull-right">Mã: {{ $orderDetails['order_id'] }}</h3>
				<br>
				<span class="pull-right">
					<?php echo DNS1D::getBarcodeHTML($orderDetails['order_id'], 'C39'); ?>
				</span>
				<br>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
					@if($userDetails != Null)
    				<address>
    				<strong>Xuất hóa đơn:</strong><br>
						{{ $userDetails['last_name'] }} {{ $userDetails['name'] }}<br>
    					{{ $userDetails['address'] }}<br>
    					{{ $userDetails['ward'] }}<br>
						{{ $userDetails['district'] }}<br>
						{{ $userDetails['province'] }}<br>	
    					Việt Nam
						<br><br>{{ $userDetails['mobile'] }}<br>
    				</address>
					@endif
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			<strong>Giao tới:</strong><br>
    					{{ $orderDetails['name'] }}<br>
    					{{ $orderDetails['address'] }}<br>
    					{{ $orderDetails['ward'] }}<br>
						{{ $orderDetails['district'] }}<br>
						{{ $orderDetails['province'] }}<br>
    					Việt Nam
						<br><br>{{ $orderDetails['mobile'] }}<br>
						Ghi chú:     
						@if(!empty($orderDetails['note']))
                        {{ $orderDetails['note']}} 
                        @else
                        không có ghi chú
                        @endif
    				</address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Phương thức thanh toán:</strong><br>
						@if($orderDetails['payment_method'] == "COD")
						thanh toán khi nhận hàng
						@else
						chuyển khoản
						@endif     <br>
    					{{ $orderDetails['email'] }}
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Ngày đặt:</strong><br>
    					{{ date('d-m-Y', strtotime($orderDetails['created_at'])) }}<br><br>
    				</address>
    			</div>
    		</div>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Tóm tắt đơn hàng</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Tên Sản Phẩm</strong></td>
        							<td class="text-center"><strong>Mã Sản Phẩm</strong></td>
									<td class="text-center"><strong>Giá Trị</strong></td>
        							<td class="text-center"><strong>Số Lượng</strong></td>
        							<td class="text-right"><strong>Số Tiền</strong></td>
                                </tr>
    						</thead>
    						<tbody>
								@php $subTotal = 0; @endphp
								@foreach($orderDetails['orders_products'] as $pro)
								<tr>
									<td>
										{{ $pro['product_name'] }}
										<br>
										<?php echo DNS1D::getBarcodeHTML($pro['product_code'], 'C39'); ?>
									</td>
									<td  class="text-center">{{ $pro['sku'] }}</td>
									<td class="text-center">
										<?php 
										$grand_total = $pro['product_price'];
										$format = number_format($grand_total,0,",",".");
										 echo $format;
										?> ₫ 
									</td>
									<td class="text-center">{{ $pro['product_qty'] }}</td>
									<td class="text-right">
										<?php 
										$grand_total = $pro['product_price'] * $pro['product_qty'];
										$format = number_format($grand_total,0,",",".");
										 echo $format;
										?> ₫ 
									</td>
								</tr>
								@php $subTotal = $subTotal + ($pro['product_price'] * $pro['product_qty']); @endphp
								@endforeach         
								<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
									<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Tổng Giá</strong></td>
    								<td class="thick-line text-right"><?php 
										$format = number_format($subTotal,0,",",".");
										 echo $format;
										?> ₫ </td>
    							</tr>                     
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
									<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Khuyến Mãi</strong></td>
    								<td class="no-line text-right"><?php 
										$grand_total = $orderDetails['coupon_amount'];
										$format = number_format($grand_total,0,",",".");
										 echo $format;
										?> ₫ </td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
									<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Phí Giao Hàng</strong></td>
    								<td class="no-line text-right"><?php 
										$grand_total = $orderDetails['shipping_charges'];
										$format = number_format($grand_total,0,",",".");
										 echo $format;
										?> ₫ </td></td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
									<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Tổng Thanh Toán</strong></td>
    								<td class="no-line text-right"><?php 
										$grand_total = $orderDetails['grand_total'] + $orderDetails['shipping_charges'];
										$format = number_format($grand_total,0,",",".");
										 echo $format;
										?> ₫ </td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>