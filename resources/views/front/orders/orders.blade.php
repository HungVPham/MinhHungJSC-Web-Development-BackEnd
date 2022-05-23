@extends('layouts.front_layout.front_layout')
@section('content')
<style>
    #name-error,#last_name-error, #mobile-error, #chkPwd, #current_pwd-error, #new_pwd-error, #confirm_pwd-error{
    display: block;
    font-size: 16px;
    font-weight: 700;
    width: 100%;
    text-align: left;
    color: var(--MinhHung-Red);
    margin-left: 5px;
    margin-top: -10px
    }
    a:not([href]):not([class]), a:not([href]):not([class]):hover {
        color: var(--Solid-White);
        text-decoration: none;
    }
    .pwd-toggle{
    width: 50px !important;
    position: absolute;
    right: -10px;
    top: 0;
    margin-top: 5px;
    color: rgba(0, 0,0, 0.3) !important;
    cursor: pointer;
    }
    .pwd-toggle.on{
        display: none;
    }

    input{
        margin-bottom: 10px;
    }

    .select2{
        margin-bottom: 10px;
    }
</style>
<div class="myAccount-page">
    <div class="small-container">
        <div class="row">
            <div class="myAccount-page-col-1">
                <div class="tab">
                    <a style="cursor: default;">{{ Auth::user()->last_name }} {{ Auth::user()->name }}</a>
                    <a href="{{ url('/my-account') }}"><i class="fas fa-user"></i>&nbsp;&nbsp;Hồ Sơ Của Tôi</a>
                    <a href="{{ url('/add-edit-delivery-address') }}"><i class="fas fa-map-pin"></i>&nbsp;&nbsp;Địa Chỉ Nhận Hàng</a>
                    <a href="{{ url('/orders') }}"><i style="color: var(--MinhHung-Red)" class="fas fa-shopping-bag"></i>&nbsp;&nbsp;Đơn Mua</a>
                </div>
            </div>
            <div class="myAccount-page-col-2">
                <div class="tabcontent">
                    <div class="tabcontent-title">
                    <h2>Đơn Mua</h2>
                    <h5>Quản lý dơn hàng</h5>
                    <hr>
                    </div>
                    @if(!empty($orders))
                    <table class="cart-table">
                        <tr>
                            <th>Đơn Hàng</th>
                            <th>Phân Loại/Số Lượng</th>
                            <th>Thanh Toán</th>
                            <th>Trị Giá</th>
                            <th>Ngày Đặt</th>
                            <th>Trạng Thái</th>
                            <th>Thao tác</th>
                        </tr>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order['id'] }}</td>
                                <td>
                                    @foreach($order['orders_products'] as $pro)
                                    &#9900; {{ $pro['sku'] }} <b>x {{ $pro['product_qty']}}</b><br>
                                    @endforeach
                                </td>
                                <td>
                                    @if($order['payment_method'] == "COD")
                                    COD
                                    @else
                                    chuyển khoản
                                    @endif                            
                                </td>
                                <td>
                                    <?php 
                                    $grand_total = $order['grand_total'];
                                    $format = number_format($grand_total,0,",",".");
                                     echo $format;
                                    ?> ₫ 
                                </td>
                                <td>{{ date('d-m-Y', strtotime($order['created_at'])) }}</td>
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
                                <td><a href="{{ url('orders/'.$order['id']) }}" title="xem chi tiết"><i class="fas fa-edit"></i></a></td>
                            </tr>
                        @endforeach
                    </table>
                @else
                <div class="empty-cart" style="width: auto;">
                    <svg viewBox="656 573 264 182" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <rect id="bg-line" stroke="none" fill-opacity="0.2" fill="var(--Solid-Gold)" fill-rule="evenodd" x="656" y="624" width="206" height="38" rx="19"></rect>
                        <rect id="bg-line" stroke="none" fill-opacity="0.2" fill="var(--Solid-Gold)" fill-rule="evenodd" x="692" y="665" width="192" height="29" rx="14.5"></rect>
                        <rect id="bg-line" stroke="none" fill-opacity="0.2" fill="var(--Solid-Gold)" fill-rule="evenodd" x="678" y="696" width="192" height="33" rx="16.5"></rect>
                        <g id="shopping-bag" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(721.000000, 630.000000)">
                            <polygon id="Fill-10" fill="#00000070" points="4 29 120 29 120 0 4 0"></polygon>
                            <polygon id="Fill-14" fill="#cb1c22" points="120 29 120 0 115.75 0 103 12.4285714 115.75 29"></polygon>
                            <polygon id="Fill-15" fill="#cb1c22" points="4 29 4 0 8.25 0 21 12.4285714 8.25 29"></polygon>
                            <polygon id="Fill-33" fill="#00000070" points="110 112 121.573723 109.059187 122 29 110 29"></polygon>
                            <polygon id="Fill-35" fill-opacity="0.5" fill="#FFFFFF" points="2 107.846154 10 112 10 31 2 31"></polygon>
                            <path d="M107.709596,112 L15.2883462,112 C11.2635,112 8,108.70905 8,104.648275 L8,29 L115,29 L115,104.648275 C115,108.70905 111.7365,112 107.709596,112" id="Fill-36" fill="#cb1c22"></path>
                            <path d="M122,97.4615385 L122,104.230231 C122,108.521154 118.534483,112 114.257931,112 L9.74206897,112 C5.46551724,112 2,108.521154 2,104.230231 L2,58" id="Stroke-4916" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
                            <polyline id="Stroke-4917" stroke="#000000" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" points="2 41.5 2 29 122 29 122 79"></polyline>
                            <path d="M4,50 C4,51.104 3.104,52 2,52 C0.896,52 0,51.104 0,50 C0,48.896 0.896,48 2,48 C3.104,48 4,48.896 4,50" id="Fill-4918" fill="#000000"></path>
                            <path d="M122,87 L122,89" id="Stroke-4919" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
                            <polygon id="Stroke-4922" stroke="#000000" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" points="4 29 120 29 120 0 4 0"></polygon>
                            <path d="M87,46 L87,58.3333333 C87,71.9 75.75,83 62,83 L62,83 C48.25,83 37,71.9 37,58.3333333 L37,46" id="Stroke-4923" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
                            <path d="M31,45 C31,41.686 33.686,39 37,39 C40.314,39 43,41.686 43,45" id="Stroke-4924" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
                            <path d="M81,45 C81,41.686 83.686,39 87,39 C90.314,39 93,41.686 93,45" id="Stroke-4925" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
                            <path d="M8,0 L20,12" id="Stroke-4928" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
                            <path d="M20,12 L8,29" id="Stroke-4929" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
                            <path d="M20,12 L20,29" id="Stroke-4930" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
                            <path d="M115,0 L103,12" id="Stroke-4931" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
                            <path d="M103,12 L115,29" id="Stroke-4932" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
                            <path d="M103,12 L103,29" id="Stroke-4933" stroke="#000000" stroke-width="3" stroke-linecap="round"></path>
                        </g>
                        <g id="glow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(768.000000, 615.000000)">
                            <rect id="Rectangle-2" fill="#000000" x="14" y="0" width="2" height="9" rx="1"></rect>
                            <rect fill="#000000" transform="translate(7.601883, 6.142354) rotate(-12.000000) translate(-7.601883, -6.142354) " x="6.60188267" y="3.14235449" width="2" height="6" rx="1"></rect>
                            <rect fill="#000000" transform="translate(1.540235, 7.782080) rotate(-25.000000) translate(-1.540235, -7.782080) " x="0.54023518" y="6.28207994" width="2" height="3" rx="1"></rect>
                            <rect fill="#000000" transform="translate(29.540235, 7.782080) scale(-1, 1) rotate(-25.000000) translate(-29.540235, -7.782080) " x="28.5402352" y="6.28207994" width="2" height="3" rx="1"></rect>
                            <rect fill="#000000" transform="translate(22.601883, 6.142354) scale(-1, 1) rotate(-12.000000) translate(-22.601883, -6.142354) " x="21.6018827" y="3.14235449" width="2" height="6" rx="1"></rect>
                        </g>
                        <polygon id="plus" stroke="none" fill="#7DBFEB" fill-rule="evenodd" points="689.681239 597.614697 689.681239 596 690.771974 596 690.771974 597.614697 692.408077 597.614697 692.408077 598.691161 690.771974 598.691161 690.771974 600.350404 689.681239 600.350404 689.681239 598.691161 688 598.691161 688 597.614697"></polygon>
                        <polygon id="plus" stroke="none" fill="#EEE332" fill-rule="evenodd" points="913.288398 701.226961 913.288398 699 914.773039 699 914.773039 701.226961 917 701.226961 917 702.711602 914.773039 702.711602 914.773039 705 913.288398 705 913.288398 702.711602 911 702.711602 911 701.226961"></polygon>
                        <polygon id="plus" stroke="none" fill="#FFA800" fill-rule="evenodd" points="662.288398 736.226961 662.288398 734 663.773039 734 663.773039 736.226961 666 736.226961 666 737.711602 663.773039 737.711602 663.773039 740 662.288398 740 662.288398 737.711602 660 737.711602 660 736.226961"></polygon>
                        <circle id="oval" stroke="none" fill="#A5D6D3" fill-rule="evenodd" cx="699.5" cy="579.5" r="1.5"></circle>
                        <circle id="oval" stroke="none" fill="#CFC94E" fill-rule="evenodd" cx="712.5" cy="617.5" r="1.5"></circle>
                        <circle id="oval" stroke="none" fill="#8CC8C8" fill-rule="evenodd" cx="692.5" cy="738.5" r="1.5"></circle>
                        <circle id="oval" stroke="none" fill="#3EC08D" fill-rule="evenodd" cx="884.5" cy="657.5" r="1.5"></circle>
                        <circle id="oval" stroke="none" fill="#66739F" fill-rule="evenodd" cx="918.5" cy="681.5" r="1.5"></circle>
                        <circle id="oval" stroke="none" fill="#C48C47" fill-rule="evenodd" cx="903.5" cy="723.5" r="1.5"></circle>
                        <circle id="oval" stroke="none" fill="#A24C65" fill-rule="evenodd" cx="760.5" cy="587.5" r="1.5"></circle>
                        <circle id="oval" stroke="#66739F" stroke-width="2" fill="none" cx="745" cy="603" r="3"></circle>
                        <circle id="oval" stroke="#EFB549" stroke-width="2" fill="none" cx="716" cy="597" r="3"></circle>
                        <circle id="oval" stroke="#cb1c22" stroke-width="2" fill="none" cx="681" cy="751" r="3"></circle>
                        <circle id="oval" stroke="#3CBC83" stroke-width="2" fill="none" cx="896" cy="680" r="3"></circle>
                        <polygon id="diamond" stroke="#C46F82" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none" points="886 705 889 708 886 711 883 708"></polygon>
                        <path d="M736,577 C737.65825,577 739,578.34175 739,580 C739,578.34175 740.34175,577 742,577 C740.34175,577 739,575.65825 739,574 C739,575.65825 737.65825,577 736,577 Z" id="bubble-rounded" stroke="#3CBC83" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" fill="none"></path>
                    </svg>
                    <h4 style="margin-bottom: 0px;">chưa có đơn hàng</>
                </div>
                @endif
                </div>  
            </div>
        </div>
    </div>
</div>
@endsection