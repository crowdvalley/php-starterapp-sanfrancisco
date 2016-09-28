//Initaiate Flexslider 
if(jQuery().flexslider) {
$(window).load(function() {
  // The slider being synced must be initialized first
  $('#carousel').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 210,
    itemMargin: 5,
    asNavFor: '#slider'
  });
   
  $('#slider').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    sync: "#carousel"
  });
});
}
//Backstretch

if(jQuery().backstretch) {
    $(document).ready(function(){
        $(".parallax-one").backstretch("/bundles/cvseismic/images/signup_background.jpg");
    });
}
// Initiate CSS3 animate it
if(jQuery().pluginName) {
$(document).ready(function(){
	$.doTimeout(2500, function(){
		$('.repeat.go').removeClass('go');

		return true;
	});
	$.doTimeout(2520, function(){
		$('.repeat').addClass('go');
		return true;
	});
	
});
}
// Initiate Isotope
if(jQuery().isotope) {
$(window).load(function(){
    var $container = $('#container');
    $container.isotope({
	    itemSelector: '.item',
        filter: '*',
        animationOptions: {
            duration: 2000,
            easing: 'linear',
            queue: false,
		  transitionDuration: 1.9,
        }
    });
	var iso = $container.data('isotope');
  $container.isotope( 'reveal', iso.items );

	var $optionSets = $('.button-group'),
       $optionLinks = $optionSets.find('div');
 
       $optionLinks.click(function(){
          var $this = $(this);
	  // don't proceed if already selected
	  if ( $this.hasClass('selected') ) {
	      return false;
	  }
   var $optionSet = $this.parents('.button-group');
   $optionSet.find('.selected').removeClass('selected');
   $this.addClass('selected'); 
});
$('#filters').on( 'click', 'div', function() {
  var filterValue = $(this).attr('data-filter');
  $container.isotope({ filter: filterValue });
});
});
$(".isotope").bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(){
});
}
// Initaiate Owl carousel
if(jQuery().owlCarousel) {
$('.owl-carousel').owlCarousel({
    loop:true,
    margin:30,
	center: false,
    nav:false,
	startPosition: 'owl-first',
	stagePadding: 15,
	dots:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:3
        }
    }
});
}
//initiate layer slider
if(jQuery().layerSlider) {
// Running the code when the document is ready
    $(document).ready(function(){
 
        // Calling LayerSlider on the target element
        $('#layerslider').layerSlider({
			autoStart: true,
			responsiveUnder : 960,
            layersContainer : 960
 
            // Slider options goes here,
            // please check the 'List of slider options' section in the documentation
        });
    });

    //Detect touch screens for overlays

    $(document).ready(function(){
        if (Modernizr.touch) {
            // show the close overlay button
            $(".close-overlay").removeClass("hidden");
            // handle the adding of hover class when clicked
            $(".img").click(function(e){
                if (!$(this).hasClass("hover")) {
                    $(this).addClass("hover");
                }
            });
            // handle the closing of the overlay
            $(".close-overlay").click(function(e){
                e.preventDefault();
                e.stopPropagation();
                if ($(this).closest(".img").hasClass("hover")) {
                    $(this).closest(".img").removeClass("hover");
                }
            });
        } else {
            // handle the mouseenter functionality
            $(".img").mouseenter(function(){
                $(this).addClass("hover");
            })
            // handle the mouseleave functionality
            .mouseleave(function(){
                $(this).removeClass("hover");
            });
        }
    });
}
//Skillbars

jQuery(document).ready(function () {

    /*----------------------------------------------------*/
    /*  Animated Progress Bars
    /*----------------------------------------------------*/

    jQuery('.skills li').each(function () {
        jQuery(this).appear(function() {
          jQuery(this).animate({opacity:1,left:"0px"},1000);
          var b = jQuery(this).find(".progress-bar").attr("data-width");
          jQuery(this).find(".progress-bar").animate({
            width: b + "%"
          }, 1300, "linear");
        }); 
    });

    var checkedInvestors = false;

    $('#investorForm input[type=checkbox]').click(function() {
        if($(this).is(':checked')) {
            $(this).parents('.col-md-6').find('.investors').show();
            $(this).parents('.col-md-6').find('.investors input[type=radio]').first().prop('checked', true);
        } else {
            $(this).parents('.col-md-6').find('.investors').hide();
            $(this).parents('.col-md-6').find('.investors input[type=radio]').each(function() {
                $(this).prop('checked', false);
            });
        }
    });

    $('#investorBtn').click(function(e) {
        $('#investorForm').find('input[type=checkbox]').each(function() {
            if($(this).is(':checked')) {
                checkedInvestors = true;
            }
        });
        if(checkedInvestors == true) {
            $('#investorForm').find('input[type=checkbox]').each(function() {
                $(this).removeAttr('required');
            });
        } else {
            $('#investorForm').find('input[type=checkbox]').each(function() {
                $(this).prop('required', true);
            });
        }
    });
});

//initaiate Lightbox
if(jQuery().nivoLightbox) {
    $(document).ready(function(){
        $('a').nivoLightbox();
    });
}
//Maps


	




	
   