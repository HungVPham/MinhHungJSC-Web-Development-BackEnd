<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>CTCP Đầu Tư và Phát Triển Minh Hưng | Web TMDT</title>
  <link rel = "icon" href="{{ ('images/front_images/logoMinhHung.png') }}" type="image/x-icon"> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ url('css/front_css/style.css') }}">
  <script src="https://kit.fontawesome.com/197ff1d829.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@100;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="{{ url('js/front_js/google-code-prettify/prettify.css') }}" rel="stylesheet"/>
  <style type="text/css" id="enject"></style>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
  <link rel="stylesheet" href="{{ url('css/front_css/select2.css') }}">
</head> 
<body>
@include('layouts.front_layout.front_header')
@yield('content')
@include('layouts.front_layout.front_footer')		
<!-- Placed at the end of the document so the pages load faster ============================================= -->
<script src="{{ url('js/front_js/jquery.js') }}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="{{ url('js/front_js/front.min.js') }}" type="text/javascript"></script>
<script src="{{ url('js/front_js/google-code-prettify/prettify.js') }}"></script>
<script src="{{ url('js/front_js/front.js') }}"></script>
<script src="{{ url('js/front_js/jquery.lightbox-0.5.js') }}"></script>
<script src="{{ url('js/front_js/tilt.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!--Slick Carousel-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="{{ url('js/front_js/script.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>