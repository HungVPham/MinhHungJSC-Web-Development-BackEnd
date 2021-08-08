@extends('layouts.front_layout.front_layout')
@section('content')
<?php
    use App\AboutPage;
    $AboutDetails = AboutPage::aboutPageDetails();
?>
<div class="about-page">
    <div class="small-container">
        <div class="row">
            <div class="about-col-1">
                <div class="tab">
                    @foreach($AboutDetails as $NavLinks)
                    <a href="{{ url('about-us/'.$NavLinks['url'])}}">{{ $NavLinks['title'] }}</a>
                    @endforeach
                </div>
            </div>
            <div class="about-col-2">
                <div class="tabcontent">
                    <div class="tabcontent-title">
                    <h2>{{ $aboutPageDetails['title'] }}</h2>
                    </div>
                @if(!empty($aboutPageDetails['info_banner']))
                <img src="{{ asset('/images/infographic_images/'.$aboutPageDetails['info_banner']) }}">
                @endif
                @if(!empty($aboutPageDetails['description']))
                <div class="text-data">
                <?php echo $aboutPageDetails['description'] ?>
                </div>
                @endif
                </div>  
            </div>
        </div>
    </div>
</div>
@endsection