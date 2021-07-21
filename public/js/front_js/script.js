$(document).ready(function () {

    // setup ajax csrf token for post method
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(window).on("scroll", function(){
        if ($(window).scrollTop()){
            $('.header').addClass('sticky');
        }
        else
        {   
            $('.header').removeClass('sticky');
        }
    });

    // Slick Carousel in news-events
    var slider2 = $('.post-wrapper').slick({
        slidesToShow: 3,
        infinite: false,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        nextArrow: $('.next'),
        prevArrow: $('.prev'),
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }, {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding: settings: "unslick"
            // instead of a settings object
        ]
    });
    $('.prev').hide();

    slider2.on('afterChange', function (event, slick, currentSlide) {
        console.log(currentSlide);
        //If we're on the first slide hide the Previous button and show the Next
        if (currentSlide === 0) {
            $('.prev').hide();
            $('.next').show();
        } else {
            $('.prev').show();
        }

        //If we're on the last slide hide the Next button.
        if (slick.slideCount === currentSlide + 1) {
            $('.next').hide();
        }
    });

    // featured carousel on home page
    var slider2 = $('#featuredCarousel').slick({
        slidesToShow: 4,
        infinite: true,
        slidesToScroll: 4,
        autoplay: true,
        autoplaySpeed: 8000,
        nextArrow: $('.next'),
        prevArrow: $('.prev'),
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            }, {
                breakpoint: 601,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding: settings: "unslick"
            // instead of a settings object
        ]
    });
    $('.prev').hide();

    slider2.on('afterChange', function (event, slick, currentSlide) {
        console.log(currentSlide);
        //If we're on the first slide hide the Previous button and show the Next
        if (currentSlide === 0) {
            $('.prev').hide();
            $('.next').show();
        } else {
            $('.prev').show();
        }

        //If we're on the last slide hide the Next button.
        if (slick.slideCount === currentSlide + 1) {
            $('.next').hide();
        }
    });

    // sort filers ajax
    $("#sortProducts").on('change',function(){
        var sortProducts = $(this).val();
        var url = $('#url').val();
        $.ajax({
            url:url,
            method:"get",
            data:{sortProducts:sortProducts, url:url},
            success:function(data){
                $('.filter_products').html(data);
            }
        })
    });

    // select2 without search fucntion for filter box
    $('.select2').select2({minimumResultsForSearch: Infinity});

    // get tool products information given sku
    $("#getMaxproPrice").change(function(){
        var sku = $(this).val();
        var product_id = $(this).attr("product-id");
        $.ajax({
           url:'/get-maxpro-product-price',
           data: {sku:sku, product_id:product_id},
           type: 'post',
           success:function(resp){
               let formatter = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }); 
                let data = formatter.format(resp);
                // alert(resp);
                $(".getMaxproAttrPrice").html(data);
           },error:function(){
            Swal.fire({
                title: 'Vui lòng chọn mã sản phẩm bạn muốn mua!',
                confirmButtonColor: '#cb1c22',
                confirmButtonText: 'Okay Luôn!'
              });
           }
        });
        $.ajax({
            url:'/get-maxpro-product-voltage',
            data: {sku:sku, product_id:product_id},
            type: 'post',
            success:function(resp){
                 $(".getMaxproVoltage").html(resp);
            }
         });
         $.ajax({
            url:'/get-maxpro-product-power',
            data: {sku:sku, product_id:product_id},
            type: 'post',
            success:function(resp){
                 $(".getMaxproPower").html(resp);
            }
         });
    });

    // get hhose products information given sku
    $("#getHhosePrice").change(function(){
        var sku = $(this).val();
        var product_id = $(this).attr("product-id");
        $.ajax({
            url:'/get-hhose-product-price',
            data: {sku:sku, product_id:product_id},
            type: 'post',
            success:function(resp){
                let formatter = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }); 
                let data = formatter.format(resp);
                // alert(resp);
                $(".getHhoseAttrPrice").html(data);
            },error:function(){
                Swal.fire({
                    title: 'Vui lòng chọn mã sản phẩm bạn muốn mua!',
                    confirmButtonColor: '#cb1c22',
                    confirmButtonText: 'Okay Luôn!'
                  });
            }
         });
         $.ajax({
            url:'/get-hhose-product-diameter',
            data: {sku:sku, product_id:product_id},
            type: 'post',
            success:function(resp){
                // alert(resp);
                $(".getHhoseDiameter").html(resp);
            }
         });
         $.ajax({
            url:'/get-hhose-product-length',
            data: {sku:sku, product_id:product_id},
            type: 'post',
            success:function(resp){
                $(".getHhoseLength").html(resp);
            }
         });
         $.ajax({
            url:'/get-hhose-product-embossed',
            data: {sku:sku, product_id:product_id},
            type: 'post',
            success:function(resp){
                if(resp=='Yes') 
                $(".getHhoseEmbossed").html('Có');
                else
                $(".getHhoseEmbossed").html('Không');
            }
         });
         $.ajax({
            url:'/get-hhose-product-smooth',
            data: {sku:sku, product_id:product_id},
            type: 'post',
            success:function(resp){
                if(resp=='Yes') 
                $(".getHhoseSmooth").html('Có');
                else
                $(".getHhoseSmooth").html('Không');
            }
         });
    });

    // get pump products information given sku
    $("#getShimgePrice").change(function(){
        var sku = $(this).val();
        var product_id = $(this).attr("product-id");
        $.ajax({
            url:'/get-shimge-product-price',
            data: {sku:sku, product_id:product_id},
            type: 'post',
            success:function(resp){
                let formatter = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }); 
                let data = formatter.format(resp);
                // alert(resp);
                $(".getShimgeAttrPrice").html(data);
            },error:function(){
                Swal.fire({
                    title: 'Vui lòng chọn mã sản phẩm bạn muốn mua!',
                    confirmButtonColor: '#cb1c22',
                    confirmButtonText: 'Okay Luôn!'
                  });
            }
         });
         $.ajax({
            url:'/get-shimge-product-voltage',
            data: {sku:sku, product_id:product_id},
            type: 'post',
            success:function(resp){
                $(".getShimgeVoltage").html(resp);
            }
         });
         $.ajax({
            url:'/get-shimge-product-power',
            data: {sku:sku, product_id:product_id},
            type: 'post',
            success:function(resp){
                $(".getShimgePower").html(resp);
            }
         });
         $.ajax({
            url:'/get-shimge-product-maxflow',
            data: {sku:sku, product_id:product_id},
            type: 'post',
            success:function(resp){
                $(".getShimgeMaxflow").html(resp);
            }
         });
         $.ajax({
            url:'/get-shimge-product-vertical',
            data: {sku:sku, product_id:product_id},
            type: 'post',
            success:function(resp){
                $(".getShimgeVertical").html(resp);
            }
         });
         $.ajax({
            url:'/get-shimge-product-indiameter',
            data: {sku:sku, product_id:product_id},
            type: 'post',
            success:function(resp){
                $(".getShimgeIndiameter").html(resp);
            }
         });
         $.ajax({
            url:'/get-shimge-product-outdiameter',
            data: {sku:sku, product_id:product_id},
            type: 'post',
            success:function(resp){
                $(".getShimgeOutdiameter").html(resp);
            }
         });
    });
});

// switch view btn for detail page
var ViewBtn = document.getElementsByClassName("viewbtn");
var ViewSw = document.getElementsByClassName("viewsw");
var count = 0;

function Btn(n) {
    CurrentShowViewButton(count = n);
    CurrentShowViewSwitchButton(count = n);
}

function CurrentShowViewButton(n) {
    for (var i = 0; i < ViewBtn.length; i++) {
        ViewBtn[i].className = ViewBtn[i]
            .className
            .replace(" Active", "");
    }
    ViewBtn[n].className += " Active";
}

function CurrentShowViewSwitchButton(n) {
    for (var i = 0; i < ViewSw.length; i++) {
        ViewSw[i].className = ViewSw[i]
            .className
            .replace(" Active", "");
    }
    ViewSw[n].className += " Active";
}

// switch view btn for listing page
var MyBtn = document.getElementsByClassName("mybtn");
var index = 0;

function Button(n) {
    CurrentShowButton(index = n);
}

function CurrentShowButton(n) {
    for (var i = 0; i < MyBtn.length; i++) {
        MyBtn[i].className = MyBtn[i]
            .className
            .replace(" Active", "");
    }
    MyBtn[n].className += " Active";
}


function listToggleListOff() {
    const toggleList = document.querySelector('.row.listing.body');
    toggleList
        .classList
        .add('list')
}
function listToggleListOn() {
    const toggleList = document.querySelector('.row.listing.body.list');
    toggleList
        .classList
        .remove('list')
}
function listToggleBtnOff() {
    const toggleList = document.querySelector('.btn.compare');
    toggleList
        .classList
        .add('active')
}
function listToggleBtnOn() {
    const toggleList = document.querySelector('.btn.compare.active');
    toggleList
        .classList
        .remove('active')
}

// toggle nav-sidebar in responsive view
function menuToggle() {
    const toggleMenu = document.querySelector('.menu');
    toggleMenu
        .classList
        .toggle('active')
}

// toggle search bar in user menu
const icon = document.querySelector('.icon');
const search = document.querySelector('.search');
icon.onclick = function () {
    search
        .classList
        .toggle('active')
}

// switch images on detail page
var ProductImg = document.getElementById("ProductImg");
var SmallImg = document.getElementsByClassName("small-img");

SmallImg[0].onclick = function()
{
    ProductImg.src = SmallImg[0].src
}    
SmallImg[1].onclick = function()
{
    ProductImg.src = SmallImg[1].src
}    
SmallImg[2].onclick = function()
{
    ProductImg.src = SmallImg[2].src
}    
SmallImg[3].onclick = function()
{
    ProductImg.src = SmallImg[3].src
}    

var tag = document.createElement('script');
tag.id = 'iframe-demo';
tag.src = 'https://www.youtube.com/iframe_api';
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag
.parentNode
.insertBefore(tag, firstScriptTag);

var player;
function onYouTubeIframeAPIReady() {
player = new YT.Player('existing-iframe-example', {
playerVars: {
'rel': 0
},
events: {
'onReady': onPlayerReady,
'onStateChange': onPlayerStateChange
},
});
}
function onPlayerReady(event) {
document
.getElementById('existing-iframe-example')
.style
.borderColor = '#FFFFFF';
}
function changeBorderColor(playerStatus) {
var color;
if (playerStatus == -1) {
color = "#FFFFFF"; // unstarted = gray
} else if (playerStatus == 0) {
color = "#FFFFFF"; // ended = yellow
} else if (playerStatus == 1) {
color = "#FFFFFF"; // playing = green
} else if (playerStatus == 2) {
color = "#FFFFFF"; // paused = red
} else if (playerStatus == 3) {
color = "#FFFFFF"; // buffering = purple
} else if (playerStatus == 5) {
color = "#FFFFFF"; // video cued = orange
}
if (color) {
document
.getElementById('existing-iframe-example')
.style
.borderColor = color;
}
}
function onPlayerStateChange(event) {
changeBorderColor(event.data);
}

function pauseVideo(){
    player.pauseVideo();
}

function playVideo(){
    player.playVideo();
}