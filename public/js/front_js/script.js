// Slick Carousel in news-events.html
$(document).ready(function(){
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
              slidesToScroll: 2,  
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ]
      });
      $('.prev').hide();
  
  slider2.on('afterChange', function(event, slick, currentSlide) {  	
  console.log(currentSlide);
  	//If we're on the first slide hide the Previous button and show the Next
    if (currentSlide === 0) {
      $('.prev').hide();
      $('.next').show();
    }
    else {
    	$('.prev').show();
    }
    
    //If we're on the last slide hide the Next button.
    if (slick.slideCount === currentSlide + 1) {
    	$('.next').hide();
    }
  });
});

