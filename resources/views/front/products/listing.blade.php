@extends('layouts.front_layout.front_layout')
@section('content')
<style>
    #comparision-container input[type="checkbox"]{
      appearance: none;
      -webkit-appearance: none;
      height: 18px;
      width: 18px;
      background-color: #d5d5d5;
      outline: none;
      cursor: pointer;
      border: 1px solid #333;
      align-items: center;
      justify-content: center;
      display: flex;
      float: right;
      margin-top: 7px;
    }
    #comparision-container input[type="checkbox"]:after{
      font-family: "Font Awesome 5 Free";
      font-weight: 900;
      content: "\f00c";
      font-size: 13px;
      color: #ffffff;
      display: none;

    }
    #comparision-container input[type="checkbox"]:hover{
      background-color: #a5a5a5;
    }
    #comparision-container input[type="checkbox"]:checked{
      appearance: none;
      -webkit-appearance: none;
      background-color: var(--Positive-Green);
      height: 18px;
      width: 18px;
      align-items: center;
      justify-content: center;
      display: flex;
    }
    #comparision-container input[type="checkbox"]:checked::after{
      display: block;
    }
    .page-link{
        border: none;
    }
    
    .page-item{
        font-size: 1.2rem;
        font-weight: 700;
        margin-left: 15px;
    }
    .page-item .page-link{
        color: var(--MinhHung-Red);
    }
    .page-item.active .page-link {
        background-color: var(--MinhHung-Red);
        color: var(--Solid-White);
    }
    .page-item:last-child .page-link, .page-item:first-child .page-link{
        font-weight: 900;
    }
    
</style>
<div class="listing-head">
    <div class="row listing head first">
        <h5><a href="{{ url('/') }}">Trang Chủ</a> / <?php echo $categoryDetails['breadcrumbs'] ?></h5>
    </div>
    <div class="listing-title-and-count">
        <div class="row listing head">
        <h2>{{ $categoryDetails['catDetails']['category_name'] }}</h2>
        </div>
        <div class="row listing head">
        <p><span style="color: var(--MinhHung-Red); font-weight: bolder;">{{ count($categoryProducts) }}+</span> sản phẩm có sẵn!</p>
        </div>
    </div>
    @if(!empty($categoryDetails['catDetails']['category_description']))
    <hr>
    <div class="row listing head">
        <p class="category_description">{{ $categoryDetails['catDetails']['category_description'] }}</p>
    </div>
    @endif
    <hr>
</div>
<div class="small-container listing">
    <form class="sorting-dropdown">
        <input type="hidden" name="url" id="url" value="{{ $url }}">
        <label for="sortProducts">Sắp xếp theo:</label>
        <select name="sortProducts" id="sortProducts" class="select2">
            <option value="">chọn bộ lọc...</option>
            <option value="product_latest" @if(isset($_GET['sortProducts']) && $_GET['sortProducts']=="product_latest") selected @endif>Mới &rarr; Cũ</option>
            <option value="product_name_a_z" @if(isset($_GET['sortProducts']) && $_GET['sortProducts']=="product_name_a_z") selected @endif>Tên A &rarr; Z</option>
            <option value="product_name_z_a" @if(isset($_GET['sortProducts']) && $_GET['sortProducts']=="product_name_z_a") selected @endif>Tên Z &rarr; A</option>
            <option value="price_lowest" @if(isset($_GET['sortProducts']) && $_GET['sortProducts']=="price_lowest") selected @endif>Giá: thấp &rarr; cao</option>
            <option  value="price_highest" @if(isset($_GET['sortProducts']) && $_GET['sortProducts']=="price_highest") selected @endif>Giá: cao &rarr; thấp</option>
        </select>
        <i title="hiện thị danh sách" class="mybtn fas fa-th-list" onclick="Button(0); listToggleListOff();listToggleBtnOff()"></i>
        <i title="hiện thị lưới" class="mybtn fas fa-th-large Active" onclick="Button(1); listToggleListOn();listToggleBtnOn()"></i>
    </form>
    <div class="filter_products">
    @include('front.products.ajax_products_listing')
    </div>
    <div class="page-btn">
        <a href="" class="btn compare">So Sánh Đã Chọn [0]</a>
        @if(isset($_GET['sortProducts']) && !empty($_GET['sortProducts']))
        {{ $categoryProducts->appends(['sortProducts' => $_GET['sortProducts']])->links() }}
        @else
        {{ $categoryProducts->links() }}
        @endif
    </div>
</div>
@endsection