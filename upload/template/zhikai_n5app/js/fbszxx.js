$(document).ready(function() { 
	(function ($) { 
		$('.ztfb_tabk ul.tabs li a').click(function (g) { 
			var tab = $(this).closest('.ztfb_tabk'), 
				index = $(this).closest('li').index();
			
			tab.find('ul.tabs > li').removeClass('current');
			$(this).closest('li').addClass('current');
			
			tab.find('.tab_content').find('div.tabs_item').not('div.tabs_item:eq(' + index + ')').slideUp();
			tab.find('.tab_content').find('div.tabs_item:eq(' + index + ')').slideDown();
			
			g.preventDefault();
		} );
	})(jQuery);
});