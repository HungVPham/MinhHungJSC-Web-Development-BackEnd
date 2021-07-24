/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/script.js":
/*!********************************!*\
  !*** ./resources/js/script.js ***!
  \********************************/
/***/ (() => {

$(document).ready(function () {
  // setup ajax csrf token for post method
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  }); // scroll to top 

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

  var slider2 = $('.post-wrapper').slick({
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
  }); // featured carousel on home page

  var slider2 = $('#featuredCarousel').slick({
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
  }); // sort filers ajax

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
  }); // select2 without search fucntion for filter box

  $('.select2').select2({
    minimumResultsForSearch: Infinity
  }); // get tool products information given sku

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
  }); // get hhose products information given sku

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
  }); // get pump products information given sku

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
  });
  $('.small-img').click(function () {
    $('.small-img').removeClass('checked'); //Clear all checked class on .small-img

    $(this).addClass('checked'); //Add checked class to current clicked .small-img
  });
}); // preloader

$(window).on("load", function () {
  $(".preloaderBg").fadeOut("slow");
}); // switch view btn for detail page

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
}; // switch view btn for listing page


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
}; // toggle nav-sidebar in responsive view


window.menuToggle = function () {
  var toggleMenu = document.querySelector('.menu');
  toggleMenu.classList.toggle('active');
}; // toggle search bar in user menu


var icon = document.querySelector('.icon');
var search = document.querySelector('.search');

icon.onclick = function () {
  search.classList.toggle('active');
}; // switch images on detail page


var ProductImg = document.getElementById("ProductImg");
var SmallImg = document.getElementsByClassName("small-img");

SmallImg[0].onclick = function () {
  ProductImg.src = SmallImg[0].src;
};

SmallImg[1].onclick = function () {
  ProductImg.src = SmallImg[1].src;
};

SmallImg[2].onclick = function () {
  ProductImg.src = SmallImg[2].src;
};

SmallImg[3].onclick = function () {
  ProductImg.src = SmallImg[3].src;
};

SmallImg[4].onclick = function () {
  ProductImg.src = SmallImg[4].src;
};

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
};

/***/ }),

/***/ "./resources/sass/select2.scss":
/*!*************************************!*\
  !*** ./resources/sass/select2.scss ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/sass/style.scss":
/*!***********************************!*\
  !*** ./resources/sass/style.scss ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/front_js/script": 0,
/******/ 			"css/front_css/style": 0,
/******/ 			"css/front_css/select2": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			for(moduleId in moreModules) {
/******/ 				if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 					__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 				}
/******/ 			}
/******/ 			if(runtime) var result = runtime(__webpack_require__);
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkIds[i]] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/front_css/style","css/front_css/select2"], () => (__webpack_require__("./resources/js/script.js")))
/******/ 	__webpack_require__.O(undefined, ["css/front_css/style","css/front_css/select2"], () => (__webpack_require__("./resources/sass/select2.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/front_css/style","css/front_css/select2"], () => (__webpack_require__("./resources/sass/style.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;