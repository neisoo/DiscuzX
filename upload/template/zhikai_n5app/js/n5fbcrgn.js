$(document).ready(function() { 
	(function ($) { 
		$('.n5fb_crgn ul.crgn_btqh li a').click(function (g) { 
			var tab = $(this).closest('.n5fb_crgn'), 
				index = $(this).closest('li').index();
			
			tab.find('ul.crgn_btqh > li').removeClass('current');
			$(this).closest('li').addClass('current');
			
			tab.find('.crgn_qhnr').find('div.n5fb_crxm').not('div.n5fb_crxm:eq(' + index + ')').slideUp();
			tab.find('.crgn_qhnr').find('div.n5fb_crxm:eq(' + index + ')').slideDown();
			
			g.preventDefault();
		} );
	})(jQuery);
});