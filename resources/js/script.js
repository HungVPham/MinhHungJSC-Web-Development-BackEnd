$(document).ready(function () {
    // setup ajax csrf token for post method
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    }); 
  
    var scrollToTopBtn = document.getElementById("scrollToTopBtn");
    var rootElement = document.documentElement;
  
    function scrollToTop() {
      rootElement.scrollTo({
        top: 0,
        behavior: "smooth"
      });
    }
  
    scrollToTopBtn.addEventListener("click", scrollToTop); // sticky header
  
    $(window).on("scroll", function () {
      if ($(window).scrollTop()) {
        $('.header').addClass('sticky');
      } else {
        $('.header').removeClass('sticky');
      }
    }); // Slick Carousel in news-events
    
    
    var slider1 = $('#featuredCarousel').slick({
      slidesToShow: 4,
      infinite: true,
      slidesToScroll: 4,
      autoplay: true,
      autoplaySpeed: 8000,
      nextArrow: $('.next'),
      prevArrow: $('.prev'),
      responsive: [{
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
      } // You can unslick at a given breakpoint now by adding: settings: "unslick"
      // instead of a settings object
      ]
    });
    $('.prev').hide();
    slider1.on('afterChange', function (event, slick, currentSlide) {
      console.log(currentSlide); //If we're on the first slide hide the Previous button and show the Next
  
      if (currentSlide === 0) {
        $('.prev').hide();
        $('.next').show();
      } else {
        $('.prev').show();
      } //If we're on the last slide hide the Next button.
  
  
      if (slick.slideCount === currentSlide + 1) {
        $('.next').hide();
      }
    });// featured carousel on home page 

    var slider2 = $('#smallCarousel').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      nextArrow: $('.next'),
      prevArrow: $('.prev'),
      responsive: [{
        breakpoint: 1024,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1
        }
      }, {
        breakpoint: 601,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1
        }
      }, {
        breakpoint: 480,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1
        }
      } // You can unslick at a given breakpoint now by adding: settings: "unslick"
      // instead of a settings object
      ]
    });
    $('.prev').hide();
    slider2.on('afterChange', function (event, slick, currentSlide) {
      console.log(currentSlide); //If we're on the first slide hide the Previous button and show the Next
  
      if (currentSlide === 0) {
        $('.prev').hide();
        $('.next').show();
      } else {
        $('.prev').show();
      } //If we're on the last slide hide the Next button.
  
  
      if (slick.slideCount === currentSlide + 1) {
        $('.next').hide();
      }
    });// image carousel on detail page 

    var slider3 = $('.post-wrapper').slick({
      slidesToShow: 3,
      infinite: false,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 3000,
      nextArrow: $('.next'),
      prevArrow: $('.prev'),
      responsive: [{
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
      } // You can unslick at a given breakpoint now by adding: settings: "unslick"
      // instead of a settings object
      ]
    });
    $('.prev').hide();
    slider3.on('afterChange', function (event, slick, currentSlide) {
      console.log(currentSlide); //If we're on the first slide hide the Previous button and show the Next
  
      if (currentSlide === 0) {
        $('.prev').hide();
        $('.next').show();
      } else {
        $('.prev').show();
      } //If we're on the last slide hide the Next button.
  
  
      if (slick.slideCount === currentSlide + 1) {
        $('.next').hide();
      }
    }); // scroll to top 
  
    
  
    $("#sortProducts").on('change', function () {
      var sortProducts = $(this).val();
      var url = $('#url').val();
      $.ajax({
        url: url,
        method: "get",
        data: {
          sortProducts: sortProducts,
          url: url
        },
        success: function success(data) {
          $('.filter_products').html(data);
        }
      });
    }); // sort filers ajax
  
    $('.select2').select2({
      minimumResultsForSearch: Infinity
    }); // select2 without search fucntion for filter box
  
    $("#getMaxproPrice").change(function () {
      var sku = $(this).val();
      var product_id = $(this).attr("product-id");
      $.ajax({
        url: '/get-maxpro-product-price',
        data: {
          sku: sku,
          product_id: product_id
        },
        type: 'post',
        success: function success(resp) {
          var formatter = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
          });
          var data = formatter.format(resp); // alert(resp);
  
          $(".getMaxproAttrPrice").html(data);
        },
        error: function error() {
          Swal.fire({
            title: 'Vui lòng chọn mã sản phẩm bạn muốn mua!',
            confirmButtonColor: '#cb1c22',
            confirmButtonText: 'Okay Luôn!'
          });
        }
      });
      $.ajax({
        url: '/get-maxpro-product-voltage',
        data: {
          sku: sku,
          product_id: product_id
        },
        type: 'post',
        success: function success(resp) {
          $(".getMaxproVoltage").html(resp);
        }
      });
      $.ajax({
        url: '/get-maxpro-product-power',
        data: {
          sku: sku,
          product_id: product_id
        },
        type: 'post',
        success: function success(resp) {
          $(".getMaxproPower").html(resp);
        }
      });
      $.ajax({
        url: '/get-maxpro-product-stock',
        data: {
          sku: sku,
          product_id: product_id
        },
        type: 'post',
        success: function success(resp) {
          $(".getMaxproStock").html(resp);
          $(".getMaxMaxpro").prop('max', resp);
        }
      });
    }); // get tool products information given sku
  
    $("#getHhosePrice").change(function () {
      var sku = $(this).val();
      var product_id = $(this).attr("product-id");
      $.ajax({
        url: '/get-hhose-product-price',
        data: {
          sku: sku,
          product_id: product_id
        },
        type: 'post',
        success: function success(resp) {
          var formatter = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
          });
          var data = formatter.format(resp); // alert(resp);
  
          $(".getHhoseAttrPrice").html(data);
        },
        error: function error() {
          Swal.fire({
            title: 'Vui lòng chọn mã sản phẩm bạn muốn mua!',
            confirmButtonColor: '#cb1c22',
            confirmButtonText: 'Okay Luôn!'
          });
        }
      });
      $.ajax({
        url: '/get-hhose-product-diameter',
        data: {
          sku: sku,
          product_id: product_id
        },
        type: 'post',
        success: function success(resp) {
          // alert(resp);
          $(".getHhoseDiameter").html(resp);
        }
      });
      $.ajax({
        url: '/get-hhose-product-length',
        data: {
          sku: sku,
          product_id: product_id
        },
        type: 'post',
        success: function success(resp) {
          $(".getHhoseLength").html(resp);
        }
      });
      $.ajax({
        url: '/get-hhose-product-embossed',
        data: {
          sku: sku,
          product_id: product_id
        },
        type: 'post',
        success: function success(resp) {
          if (resp == 'Yes') $(".getHhoseEmbossed").html('Có');else $(".getHhoseEmbossed").html('Không');
        }
      });
      $.ajax({
        url: '/get-hhose-product-smooth',
        data: {
          sku: sku,
          product_id: product_id
        },
        type: 'post',
        success: function success(resp) {
          if (resp == 'Yes') $(".getHhoseSmooth").html('Có');else $(".getHhoseSmooth").html('Không');
        }
      });
      $.ajax({
        url: '/get-hhose-product-stock',
        data: {
          sku: sku,
          product_id: product_id
        },
        type: 'post',
        success: function success(resp) {
          $(".getHhoseStock").html(resp);
          $(".getMaxHhose").prop('max', resp);
        }
      });
    }); // get hhose products information given sku
  
    $("#getShimgePrice").change(function () {
      var sku = $(this).val();
      var product_id = $(this).attr("product-id");
      $.ajax({
        url: '/get-shimge-product-price',
        data: {
          sku: sku,
          product_id: product_id
        },
        type: 'post',
        success: function success(resp) {
          var formatter = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
          });
          var data = formatter.format(resp); // alert(resp);
  
          $(".getShimgeAttrPrice").html(data);
        },
        error: function error() {
          Swal.fire({
            title: 'Vui lòng chọn mã sản phẩm bạn muốn mua!',
            confirmButtonColor: '#cb1c22',
            confirmButtonText: 'Okay Luôn!'
          });
        }
      });
      $.ajax({
        url: '/get-shimge-product-voltage',
        data: {
          sku: sku,
          product_id: product_id
        },
        type: 'post',
        success: function success(resp) {
          $(".getShimgeVoltage").html(resp);
        }
      });
      $.ajax({
        url: '/get-shimge-product-power',
        data: {
          sku: sku,
          product_id: product_id
        },
        type: 'post',
        success: function success(resp) {
          $(".getShimgePower").html(resp);
        }
      });
      $.ajax({
        url: '/get-shimge-product-maxflow',
        data: {
          sku: sku,
          product_id: product_id
        },
        type: 'post',
        success: function success(resp) {
          $(".getShimgeMaxflow").html(resp);
        }
      });
      $.ajax({
        url: '/get-shimge-product-vertical',
        data: {
          sku: sku,
          product_id: product_id
        },
        type: 'post',
        success: function success(resp) {
          $(".getShimgeVertical").html(resp);
        }
      });
      $.ajax({
        url: '/get-shimge-product-indiameter',
        data: {
          sku: sku,
          product_id: product_id
        },
        type: 'post',
        success: function success(resp) {
          $(".getShimgeIndiameter").html(resp);
        }
      });
      $.ajax({
        url: '/get-shimge-product-outdiameter',
        data: {
          sku: sku,
          product_id: product_id
        },
        type: 'post',
        success: function success(resp) {
          $(".getShimgeOutdiameter").html(resp);
        }
      });
      $.ajax({
        url: '/get-shimge-product-stock',
        data: {
          sku: sku,
          product_id: product_id
        },
        type: 'post',
        success: function success(resp) {
          $(".getShimgeStock").html(resp);
          $(".getMaxShimge").prop('max', resp);
        }
      });
    });// get pump products information given sku

    $('.small-img').click(function () {
        $('.small-img').removeClass('checked') //Clear all checked class on .small-img
        $(this).addClass('checked') //Add checked class to current clicked .small-img
    }); // change small-img class to selected

  }); 
  
  $(window).on("load", function () {
    $(".preloaderBg").fadeOut("slow");
  }); // preloader 
  
  var ViewBtn = document.getElementsByClassName("viewbtn");
  var ViewSw = document.getElementsByClassName("viewsw");
  var count = 0;
  
  window.Btn = function (n) {
    CurrentShowViewButton(count = n);
    CurrentShowViewSwitchButton(count = n);
  };
  
  window.CurrentShowViewButton = function (n) {
    for (var i = 0; i < ViewBtn.length; i++) {
      ViewBtn[i].className = ViewBtn[i].className.replace(" Active", "");
    }
  
    ViewBtn[n].className += " Active";
  };
  
  window.CurrentShowViewSwitchButton = function (n) {
    for (var i = 0; i < ViewSw.length; i++) {
      ViewSw[i].className = ViewSw[i].className.replace(" Active", "");
    }
  
    ViewSw[n].className += " Active";
  }; // switch view btn for detail page
  
  
  var MyBtn = document.getElementsByClassName("mybtn");
  var index = 0;
  
  window.Button = function (n) {
    CurrentShowButton(index = n);
  };
  
  window.CurrentShowButton = function (n) {
    for (var i = 0; i < MyBtn.length; i++) {
      MyBtn[i].className = MyBtn[i].className.replace(" Active", "");
    }
  
    MyBtn[n].className += " Active";
  };
  
  window.listToggleListOff = function () {
    var toggleList = document.querySelector('.row.listing.body');
    toggleList.classList.add('list');
  };
  
  window.listToggleListOn = function () {
    var toggleList = document.querySelector('.row.listing.body.list');
    toggleList.classList.remove('list');
  };
  
  window.listToggleBtnOff = function () {
    var toggleList = document.querySelector('.btn.compare');
    toggleList.classList.add('active');
  };
  
  window.listToggleBtnOn = function () {
    var toggleList = document.querySelector('.btn.compare.active');
    toggleList.classList.remove('active');
  }; // switch view btn for listing page
  
  
  window.menuToggle = function () {
    var toggleMenu = document.querySelector('.menu');
    toggleMenu.classList.toggle('active');
  }; // toggle nav-sidebar in responsive view
  
  
  var icon = document.querySelector('.icon');
  var search = document.querySelector('.search');
  
  icon.onclick = function () {
    search.classList.toggle('active');
  }; // toggle search bar in user menu

  document.addEventListener('DOMContentLoaded',function(){
    var secondarySlider = new Splide( '#secondary-slider', {
            fixedWidth  : 105,
            height      : 90,
            gap         : 5,
            cover       : true,
            pagination  : false,
            rewind      : true,
            isNavigation: true,
            arrows     : false,
            breakpoints : {
            '600': {
            fixedWidth: 80,
            height    : 60,
            },
        },
    } ).mount();

    var primarySlider = new Splide('#primary-slider',{
    type       : 'fade',
    heightRatio: 0.8666666666,
    pagination : false,
    arrows     : true,
    rewind     : true,
    cover      : true,
    classes: {
        arrows: 'splide__arrows custom',
        prev  : 'splide__arrow--prev btnPrev',
        next  : 'splide__arrow--next btnNext',
    },
    } ); // do not call mount() here.
    primarySlider.sync(secondarySlider).mount();
  }); // image carousel on detail page
  
  var tag = document.createElement('script');
  tag.id = 'iframe-demo';
  tag.src = 'https://www.youtube.com/iframe_api';
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
  var player;
  
  window.onYouTubeIframeAPIReady = function () {
    player = new YT.Player('existing-iframe-example', {
      playerVars: {
        'rel': 0
      },
      events: {
        'onReady': onPlayerReady,
        'onStateChange': onPlayerStateChange
      }
    });
  };
  
  window.onPlayerReady = function (event) {
    document.getElementById('existing-iframe-example').style.borderColor = '#FFFFFF';
  };
  
  window.changeBorderColor = function (playerStatus) {
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
      document.getElementById('existing-iframe-example').style.borderColor = color;
    }
  };
  
  window.onPlayerStateChange = function (event) {
    changeBorderColor(event.data);
  };
  
  window.pauseVideo = function () {
    player.pauseVideo();
  };
  
  window.playVideo = function () {
    player.playVideo();
  }; // Youtube video auto play/pause function