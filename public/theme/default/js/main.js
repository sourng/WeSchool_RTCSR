(function($) {
	"use strict"
	
	// Preloader
	$(window).on('load', function() {
		$("#preloader").delay(600).fadeOut();
	});

	$("#fresponsive .dropdown-menu").parent().addClass("dropdown");
	$("#fresponsive li:not(.dropdown) > a, .footer-nav li:not(.dropdown) > a").removeClass("dropdown-toggle");
    $("#fresponsive li:not(.dropdown) > a, .footer-nav li:not(.dropdown) > a").removeAttr("data-toggle");
	$("#fresponsive li:not(.dropdown) > a, .footer-nav li:not(.dropdown) > a").removeAttr("aria-expanded");
	
	$('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
		event.preventDefault(); 
		event.stopPropagation(); 
		$(this).parent().siblings().removeClass('open');
		$(this).parent().toggleClass('open');
	});
	
	/* Content Slider Section */
    $('#slider').owlCarousel({
	    loop:true,
	    items:1,
	    autoplay:true,
	    margin:10,
	    nav:false,
	    smartSpeed:600,
	    responsive:{
	        0:{
	            items:1
	        },
	        600:{
	            items:1
	        },
	        1000:{
	            items:1
	        }
	    }
	});
	
	$("#slider").on("translate.owl.carousel", function(){
        $(".slider-heading, .slider-content").removeClass("animated fadeInUp").css("opacity", "0");
        $(".slider-item a").removeClass("animated fadeInDown").css("opacity", "0");
     });
        
    $("#slider").on("translated.owl.carousel", function(){
        $(".slider-heading, .slider-content").addClass("animated fadeInUp").css("opacity", "1");
        $(".slider-item a").addClass("animated fadeInDown").css("opacity", "1");
    });
	
	
})(jQuery);