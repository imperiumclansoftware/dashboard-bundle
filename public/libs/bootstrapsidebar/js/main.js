(function($) {

	"use strict";

	var fullHeight = function() {

		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function(){
			$('.js-fullheight').css('height', $(window).height());
		});

	};
	fullHeight();

	$('#sidebar-widget').toggleClass('active');
	
	$('#dashboard-addwidget').on('click', function () {
      $('#sidebar-widget').toggleClass('active');
  });

})(jQuery);
