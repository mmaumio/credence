(function($) {
  
    "use strict";
   
    /*
    |=========================
    | Menu Sticky function
    |=========================
    */  
 	var credHeaderFixed = function() {
			var headerFix = $('.site-header').offset().top;
			console.log(headerFix);
			$(window).on('load scroll', function() {
				var y = $(this).scrollTop();
				if ( y >= headerFix) {
					$('.site-header').addClass('fixed');
					$('body').addClass('siteScrolled');
				} else {
					$('.site-header').removeClass('fixed');
					$('body').removeClass('siteScrolled');
				}
				if ( y >= 107 ) {
					$('.site-header').addClass('float-header shadow-bottom');
				} else {
					$('.site-header').removeClass('float-header shadow-bottom');
				}
			});
	};    

	// Dom Ready
	$(function() {
		credHeaderFixed();
	});
}(jQuery));