$('document').ready(function() 
{
	// Function for possibility to have submenus dropdown on filtering menu
	$("#filt .dropdown-menu > div > a.trigger").on("click",function(e)
	{
		var current     = $(this).next();
		var grandparent = $(this).parent().parent();

		if($(this).hasClass('left-caret') || $(this).hasClass('right-caret'))
			$(this).toggleClass('right-caret left-caret');
		
		grandparent.find('.left-caret').not(this).toggleClass('right-caret left-caret');
		grandparent.find(".sub-menu:visible").not(current).hide();
		current.toggle();
		e.stopPropagation();
	});

	// Just to activate the custom scrolling using the jScrollPane jQuery plugin
	$('.scrollable').jScrollPane({ hideFocus : true, autoReinitialise : true, contentWidth : '218px' });

	// If clicking anywhere in the dropdown menu, it doesn't close
	$('.dropdown-menu').click(function(e) {
        e.stopPropagation();
    });
});