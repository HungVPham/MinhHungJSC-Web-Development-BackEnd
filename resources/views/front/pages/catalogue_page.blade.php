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
    }
    .pdf-reader{
        margin-top: 20px;
    }
    embed{
        width: 100%;
        height: 700px;
    }

    @media only screen and (max-width: 600px) {
        embed{
        height: 300px;
    }

    }
</style>
<div class="listing-head">
    <div class="row listing head first">
        <h5><a href="{{ url('/') }}">Trang Chủ</a> / <a>Catalogue {{ $cataloguePageDetails['title'] }}</a></h5>
    </div>
    <div class="listing-title-and-count">
        <div class="row listing head">
        <h2>Catalogue {{ $cataloguePageDetails['title'] }}</h2>
        </div>
    </div>
    <hr>
</div>
<div class="small-container">
        <?php
        echo $cataloguePageDetails['description']
        ?>
        <div class="pdf-reader">
            <embed src="{{ url('files/catalogues/'.$cataloguePageDetails['file_path']) }}">
        </div>    
</div>
@endsection