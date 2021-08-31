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
  
    scrollToTopBtn.addEventListener("click", scrollToTop); 
  
    lastScroll = 0;
    $(window).on("scroll", function () {
      var scroll = $(window).scrollTop();
      if(lastScroll - scroll > 0) {
        $('.header').addClass('sticky');
        $('.toTopBg').addClass('active');
      }else{
        $('.header').removeClass('sticky');
        $('.toTopBg').removeClass('active');
      }

      if(scroll == 0) {
        $('.header').removeClass('sticky');
        $('.toTopBg').removeClass('active');
      }
      lastScroll = scroll;
    }); // sticky header
    
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
      this.form.submit();
    }); // sort filers for category listing page

    $("#sort").on('change', function () {
        this.form.submit();
    }); // sort filers for section listing page
  
    $('.select2').select2({
      minimumResultsForSearch: 1
    }); // select2 without search fucntion for filter box

    $('.select2-no-search').select2({
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
          var data = formatter.format(resp['product_price']);
          var dataDiscounted = formatter.format(resp['discounted_price']);
          if(resp['product_price']!=null)
            if(resp['product_price']>resp['discounted_price']){
              $(".getMaxproAttrPrice").html("<del>"+data+"</del>"+"<strong style='color: var(--MinhHung-Red)'>&nbsp;&nbsp;&nbsp;"+dataDiscounted)+'</strong>';
            }else{
              $(".getMaxproAttrPrice").html(data);
            }
          else{
            Swal.fire({
              title: 'Vui lòng chọn mã sản phẩm bạn muốn mua!',
              confirmButtonColor: '#cb1c22',
              confirmButtonText: 'Okay Luôn!'
            });
            return false;
          }
        },
        error: function error() {
          alert("error");
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
      // $.ajax({
      //   url: '/get-hhose-product-price',
      //   data: {
      //     sku: sku,
      //     product_id: product_id
      //   },
      //   type: 'post',
      //   success: function success(resp) {
      //     var formatter = new Intl.NumberFormat('vi-VN', {
      //       style: 'currency',
      //       currency: 'VND'
      //     });
      //     var data = formatter.format(resp['product_price']);
      //     var dataDiscounted = formatter.format(resp['discounted_price']);

      //     if(resp['discounted_price']>0){
      //       $(".getHhoseAttrPrice").html("<del>"+data+"</del>"+"<strong style='color: var(--MinhHung-Red)'>&nbsp;&nbsp;&nbsp;"+dataDiscounted)+'</strong>';
      //     }else{
      //       $(".getHhoseAttrPrice").html(data);
      //     }
      //   },
      //   error: function error() {
      //     Swal.fire({
      //       title: 'Vui lòng chọn mã sản phẩm bạn muốn mua!',
      //       confirmButtonColor: '#cb1c22',
      //       confirmButtonText: 'Okay Luôn!'
      //     });
      //   }
      // });
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
          var data = formatter.format(resp['product_price']);
          var dataDiscounted = formatter.format(resp['discounted_price']);
          if(resp['product_price']!=null)
            if(resp['product_price']>resp['discounted_price']){
              $(".getShimgeAttrPrice").html("<del>"+data+"</del>"+"<strong style='color: var(--MinhHung-Red)'>&nbsp;&nbsp;&nbsp;"+dataDiscounted)+'</strong>';
            }else{
              $(".getShimgeAttrPrice").html(data);
            }
          else{
            Swal.fire({
              title: 'Vui lòng chọn mã sản phẩm bạn muốn mua!',
              confirmButtonColor: '#cb1c22',
              confirmButtonText: 'Okay Luôn!'
            });
            return false;
          }
        },
        error: function error() {
         alert("error");
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

    $(document).on('click','.btnItemUpdate',function(){
        if($(this).hasClass('plus')){
          var $qty = $(this).closest('.number-input').find('.quantity');
          var currentVal = parseInt($qty.val());
          if (!isNaN(currentVal)) {
              $qty.val(currentVal + 1);
          }
          new_qty = currentVal + 1;
        }
        if($(this).hasClass('minus')){
          var $qty = $(this).closest('.number-input').find('.quantity');
          var currentVal = parseInt($qty.val());
          if (!isNaN(currentVal) && currentVal > 1) {
              $qty.val(currentVal - 1);
              new_qty = currentVal - 1;
          }
          if(currentVal <= 1){
            Swal.fire({
              title: 'Xác nhận xóa?',
              text: "Bạn sẽ không thay đổi được sau khi xóa!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#cb1c22',
              cancelButtonColor: '#cb1c22',
              confirmButtonText: 'Xóa!',
              cancelButtonText: 'Không xóa.'
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                  data:{"cartid":cartid},
                  url:'/delete-cart-item',
                  type: 'post',
                  success:function success(resp){
                    $("#AppendCartItems").html(resp.view);
                    $(".navbar-cart").attr('cartcount', resp.totalCartItems);
                    if(resp.totalCartItems==0){
                      $("#cart-container").load(window.location.href + " #cart-container" );
                    }
                  },error:function(){
                    alert("Error");
                  }
                })
              }
            });
          }
      };
      // alert(new_qty);
      var cartid = $(this).data('cartid');
      var sectionid = $(this).data('sectionid');
      // alert(cartid);
      $.ajax({
        data:{"cartid":cartid,"qty":new_qty,"secid":sectionid},
        url:'/update-cart-item-qty',
        type: 'post',
        success:function success(resp){
          if(resp.status==false){
            Swal.fire({
              title: resp.message,
              confirmButtonColor: '#cb1c22',
              confirmButtonText: 'Okay Luôn!'
            });
          }
          $("#AppendCartItems").html(resp.view);
          $(".navbar-cart").attr('cartcount', resp.totalCartItems); 
        },error:function(){
          alert("Error");
        }
      });
    });// update cart items

    $(document).on('click','.btnItemDelete',function(){
    var cartid = $(this).data('cartid');
    // alert(cartid); return false;
        $.ajax({
          data:{"cartid":cartid},
          url:'/delete-cart-item',
          type: 'post',
          success:function success(resp){
            $("#AppendCartItems").html(resp.view);       
            $(".navbar-cart").attr('cartcount', resp.totalCartItems);
            if(resp.totalCartItems==0){
              $("#cart-container").load(window.location.href + " #cart-container" );
            }
          },error:function(){
            alert("Error");
          }
        })
  });// update cart items

  // validate signup form on keyup and submit
  $("#PriceQuotationForm").validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      full_name: "required",
      mobile: {
        required: true,
        minlength: 10,
        maxlength: 10,
        digits: true,
      },
    },
    messages: {
      email: {
        required: "Vui lòng nhập email của quý khách.",
        email: "Email không hợp lệ.",
      },
      full_name: "Vui nhập tên của quý khách.",
      mobile: {
        required: "Vui lòng nhập số điện thoại.",
        minlength: "Số điện thọai không hợp lệ.",
        maxlength: "Số điện thọai không hợp lệ.",
        digits: "Số điện thoại không hợp lệ."
      },
    }
  });

  $("#OrderForNonUserForm").validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      full_name: "required",
      mobile: {
        required: true,
        minlength: 10,
        maxlength: 10,
        digits: true,
      },
      address: "required",
    },
    messages: {
      email: {
        required: "Vui lòng nhập email của quý khách.",
        email: "Email không hợp lệ.",
      },
      full_name: "Vui nhập tên của quý khách.",
      address: "Vui nhập địa chỉ nhận hàng.",
      mobile: {
        required: "Vui lòng nhập số điện thoại.",
        minlength: "Số điện thọai không hợp lệ.",
        maxlength: "Số điện thọai không hợp lệ.",
        digits: "Số điện thoại không hợp lệ."
      },
    }
  });

  $("#ContactForm").validate({
    rules: {
      name: "required",
      email: {
        required: true,
        email: true,
      },
      subject: "required",
      message: "required",
    },
    messages: {
      email: {
        required: "Vui lòng nhập email của quý khách.",
        email: "Email không hợp lệ.",
      },
      name: "Vui nhập tên của quý khách.",
      subject: "Vui nhập chủ đề câu hỏi của quý khách.",
      message: "Vui nhập lời nhắn/câu hỏi của quý khách.",
    }
  });
  
  $("#InformationForm").validate({
    rules: {
      name: {
        required: true,
      },
      last_name: "required",
      mobile: {
        required: true,
        minlength: 10,
        maxlength: 10,
        digits: true,
      },
    },
    messages: {
      name: {
        required: "Vui lòng nhập tên.",
      },
      last_name: "Vui lòng nhập họ.",
      mobile: {
        required: "Vui lòng nhập số điện thoại.",
        minlength: "Số điện thọai không hợp lệ.",
        maxlength: "Số điện thọai không hợp lệ.",
        digits: "Số điện thoại không hợp lệ."
      },
    }
  });

  $("#deliveryAddressForm").validate({
    rules: {
      name: {
        required: true,
      },
      address: {
        required: true,
      },
      mobile: {
        required: true,
        minlength: 10,
        maxlength: 10,
        digits: true,
      },
    },
    messages: {
      name: {
        required: "Vui lòng nhập họ và tên người nhận hàng.",
      },
      address: {
        required: "Vui lòng nhập địa chỉ cụ thể.",
      },
      mobile: {
        required: "Vui lòng nhập số điện thoại.",
        minlength: "Số điện thọai không hợp lệ.",
        maxlength: "Số điện thọai không hợp lệ.",
        digits: "Số điện thoại không hợp lệ."
      },
    }
  });

  $("#RegForm").validate({
    rules: {
      name: "required",
      last_name: "required",
      mobile: {
        remote: "check-mobile",
        required: true,
        minlength: 10,
        maxlength: 10,
        digits: true,
      },
      password: {
        required: true,
        minlength: 6,
      },
      email: {
        remote: "check-email",
        required: true,
        email: true,
      },
      company_email: {
        email: true,
      },
    },
    messages: {
      name: "Vui lòng nhập tên.",
      last_name: "Vui lòng nhập họ.",
      password: {
        required: "Vui lòng nhập mật khẩu.",
        minlength: "Mật khẩu phải dài ít nhất 6 chữ hoặc số.",
      },
      email: {
        remote: "Email đã được đăng kí.",
        required: "Vui lòng nhập email của quý khách.",
        email: "Email không hợp lệ.",
      },
      company_email: {
        email: "Email doanh nghiệp không hợp lệ.",
      },
      mobile: {
        remote: "Số điện thoại đã được đăng kí ở một tài khoản khác.",
        required: "Vui lòng nhập số điện thoại.",
        minlength: "Số điện thọai không hợp lệ.",
        maxlength: "Số điện thọai không hợp lệ.",
      },
    }
  });

  $("#LoginForm").validate({
    rules: {
      id: "required",
      password: "required",
    },
    messages: {
      id: "Vui nhập số điện thoại hoặc email của quý khách.",
      password: "Vui nhập mật khẩu của quý khách.",
    }
  });

  $("#ForgotPwdForm").validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
    },
    messages: {
      email: {
        remote: "Email đã được đăng kí.",
        required: "Vui lòng nhập email của quý khách.",
        email: "Email không hợp lệ.",
      },
    }
  });

  $.validator.addMethod( "notEqualTo", function( value, element, param ) {
    return this.optional( element ) || !$.validator.methods.equalTo.call( this, value, element, param );
  }, "Mật khẩu mới không được giống với mật khẩu hiện tại." );

  $("#NewPwdForm").validate({
    // debug: true,
    rules: {
      current_pwd: {
        required: true,
      },
      new_pwd: {
        required: true,
        minlength: 6,
        notEqualTo: "#current_pwd",
      },
      confirm_pwd: {
        required: true,
        equalTo:"#new_pwd",
      },
    },
    messages: {
      current_pwd: {
        required: "Vui lòng nhập mật khẩu hiện tại.",
      },
      new_pwd: {
        required: "Vui lòng nhập mật khẩu mới.",
        minlength: "Mật khẩu phải dài ít nhất 6 chữ hoặc số.",
      },
      confirm_pwd: {
        required: "Vui lòng xác nhận mật khẩu mới.",
        equalTo: "Xác nhận mật khẩu không chính xác.",
      },
    }
  });

  
  $("#current_pwd").keyup(function(){
    var current_pwd = $(this).val();
    $.ajax({
      type:'post',
      url:'/check-user-pwd',
      data:{current_pwd:current_pwd},
      success:function(resp){
        // alert(resp);
        if(resp=="false"){
          $("#chkPwd").html("<font color='#cb1c22'>Mật khẩu không đúng.</font>");
        }else if(resp=="true"){
          $("#chkPwd").html("<font color='#228B22'>Mật khẩu đúng.</font>");
        }
      },error:function(){
        alert("Error");
      }
    })
  });// Check Current User Password

  // Apply Coupon 
  $("#ApplyCoupon").submit(function(){
    var user = $(this).attr("user");
    if(user==1){
    }else{
      Swal.fire({
        title: "Quý khách có thể đăng ký tài khoản để sử dụng mã khuyến mãi và nhận nhiều ưu đãi hấp dẫn hơn nữa!",
        confirmButtonColor: '#cb1c22',
        confirmButtonText: 'Okay Luôn!'
      });
      return false;
    }
    var code = $("#code").val();
    $.ajax({
      type:'post',
      data:{code:code},
      url:'/apply-coupon',
      success:function(resp){
        var formatter = new Intl.NumberFormat('vi-VN', {
          style: 'currency',
          currency: 'VND'
        });
        var coupon_amount = formatter.format(resp.couponAmount);
        var total_amount = formatter.format(resp.totalAmount);
        if(resp.message!=""){
          Swal.fire({
            title: resp.message,
            confirmButtonColor: '#cb1c22',
            confirmButtonText: 'Okay Luôn!'
          });
        }
        $("#AppendCartItems").html(resp.view);
        if(resp.couponAmount>=0){
          $(".couponAmount").text(coupon_amount);
        }else{
          $(".couponAmount").text('0 ₫');
        }
        if(resp.totalAmount>=0){
          $(".totalAmount").text(total_amount);
        }
      },error:function(){
          alert("Error");
      }
    })
  });

  $(document).on("click", ".addressDelete", function(){
    var recordid = $(this).attr("recordid");
    var record = $(this).attr("record");
    Swal.fire({
        title: 'Xác nhận xóa?',
        text: "Bạn sẽ không thay đổi được sau khi xóa!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: 'var(--Positive-Green)',
        cancelButtonColor: 'var(--Delete-Red)',
        confirmButtonText: 'Xóa!',
        cancelButtonText: 'Không xóa.'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href="/delete-"+record+"/"+recordid;
        }
      });
  });

  
  $(document).on('change', '#province', function(){
    var province_id = $(this).val();
    $.ajax({
        type:'post',
        url:'/append-districts-level',
        data:{province_id:province_id},
        success:function(resp){
            $("#appendDistrictsLevel").html(resp);
            $("#appendWardsLevel").html('<label for="ward">Phường Xã:</label><select id="ward" name="ward" style="width: 100%;" class="form-control select2"><option value="">chọn phường/xã</option></select>');
            $(".select2").select2(); // init the select
        },error:function(){
            alert("Error");
        }
    });
  }); // Append Districts Level 

  $(document).on('change', '#district', function(){
    // alert("test");
    var district_id = $(this).val();
    $.ajax({
        type:'post',
        url:'/append-wards-level',
        data:{district_id:district_id},
        success:function(resp){
            $("#appendWardsLevel").html(resp);
            $(".select2").select2(); // init the select
        },error:function(){
            alert("Error");
        }
    });
  }); // Append Wards Level

  $("#payment_method_banking").click(function(){
    $('#bankingInfo').show();
  });

  $("#payment_method_cod").click(function(){
    $('#bankingInfo').hide();
  });
}); 
  
  $(window).on("load", function () {
    $(".preloaderBg").fadeOut("slow");
  }); // preloader 
  
  var ViewBtn = document.getElementsByClassName("viewbtn");
  var ViewSw = document.getElementsByClassName("viewsw");
  var count = 0;
  
  
  window.goBack = function() {
    window.location.replace(document.referrer);
  } // back to previous page 


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

  var LoginForm = document.getElementById("LoginForm");
  var RegForm = document.getElementById("RegForm");
  var Indicator = document.getElementById("Indicator");
  var RegLabel = document.getElementById("RegLabel");
  var LogForNav = document.getElementById("LogForNav");

  window.login = function() {
    RegForm.style.transform = "translateX(0px)";
    RegLabel.style.display = "inline-block";
    LoginForm.style.transform = "translateX(0px)";
    ForgotPwdForm.style.transform = "translateX(0px)";
    Indicator.style.visibility = "visible";
    Indicator.style.transform = "translateX(200px)";
    LogForNav.style.display = "none";
  }

  window.register = function () {
    RegForm.style.transform = "translateX(400px)";
    LoginForm.style.transform = "translateX(400px)";
    ForgotPwdForm.style.transform = "translate(0px)";
    Indicator.style.visibility = "visible";
    Indicator.style.transform = "translateX(100px)";
  }

  window.forgot = function () {
    ForgotPwdForm.style.transform = "translateX(-400px)";
    Indicator.style.visibility = "hidden";
    RegLabel.style.display = "none";
    LogForNav.style.display = "inline-block";
    LoginForm.style.transform = "translateX(-400px)";
  } // login/register page switching forms

  window.visibility0= function () {
    var password_login = document.getElementById('password_login');
    if (password_login.type === 'text') {
      password_login.type = "password";
      $('#eyeShow0').hide();
      $('#eyeSlash0').show();
    }else {
      password_login.type = "text";
      $('#eyeShow0').show();
      $('#eyeSlash0').hide();
    }
  } // change visibility on password input


  window.visibility1 = function () {
    var password_login = document.getElementById('password_register');
    if (password_login.type === 'text') {
      password_login.type = "password";
      $('#eyeShow1').hide();
      $('#eyeSlash1').show();
    }else {
      password_login.type = "text";
      $('#eyeShow1').show();
      $('#eyeSlash1').hide();
    }
  }

  window.visibility2 = function () {
    var password_login = document.getElementById('current_pwd');
    if (password_login.type === 'text') {
      password_login.type = "password";
      $('#eyeShow2').hide();
      $('#eyeSlash2').show();
    }else {
      password_login.type = "text";
      $('#eyeShow2').show();
      $('#eyeSlash2').hide();
    }
  }

  window.visibility3 = function () {
    var password_login = document.getElementById('new_pwd');
    if (password_login.type === 'text') {
      password_login.type = "password";
      $('#eyeShow3').hide();
      $('#eyeSlash3').show();
    }else {
      password_login.type = "text";
      $('#eyeShow3').show();
      $('#eyeSlash3').hide();
    }
  }

  window.visibility4 = function () {
    var password_login = document.getElementById('confirm_pwd');
    if (password_login.type === 'text') {
      password_login.type = "password";
      $('#eyeShow4').hide();
      $('#eyeSlash4').show();
    }else {
      password_login.type = "text";
      $('#eyeShow4').show();
      $('#eyeSlash4').hide();
    }
  }