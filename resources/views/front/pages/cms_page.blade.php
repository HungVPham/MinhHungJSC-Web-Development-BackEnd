@extends('layouts.front_layout.front_layout')
@section('content')
<style>
    .small-container tbody, td, tfoot, th, thead, tr{
        border-color: black;
        border-width: 1px;
        border-style: inherit;
    }
    .small-container li{
        margin-left: 20px;
    }
    .small-container{
        margin-bottom: 80px;
        padding-left: 45px;
        padding-right: 45px;
    }
</style>
<div class="listing-head">
    <div class="row listing head first">
        <h5><a href="{{ url('/') }}">Trang Chủ</a> / <a>Chính Sách {{ $cmsPageDetails['title'] }}</a></h5>
    </div>
    <div class="listing-title-and-count">
        <div class="row listing head">
        <h2>Chính Sách {{ $cmsPageDetails['title'] }}</h2>
        </div>
    </div>
    <hr>
</div>
<div class="small-container">
        <?php
        echo $cmsPageDetails['description']
        ?>
</div>
@endsection