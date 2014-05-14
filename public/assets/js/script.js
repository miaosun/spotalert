$('document').ready(function() 
{
	// Just to activate the custom scrolling using the jScrollPane jQuery plugin
	$('.scrollable').jScrollPane({ hideFocus : true, autoReinitialise : true, contentWidth : '218px' });

	// If clicking anywhere in the dropdown menu, it doesn't close
	$('.dropdown-menu').click(function(e) {
        e.stopPropagation();
    });

    // Everything for filtering to work
    filtering();



    //FIXME: Deixar opção de ALLCOUNTRIES (novo parametro GET?)
/*
    filter-ok -> mandar tudo
    filter-risk -> mandar tudo com risco incluido*/
});


function filtering()
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

	// Change color of filter options
	$('#filt .filter-opt').on('click', function()
	{
		$(this).toggleClass('selected');
	});

	// Selecting all countries the rest must be unselected
	$('#filt .filter-all').on('click', function()
	{
		$(this).siblings().find('.selected').toggleClass('selected');
	});

	// Selecting some country we must unselect 'All countries'
	$('#filt .filter-country').on('click', function()
	{
		$('#filt .filter-all').removeClass('selected');
	});

	// Selecting "OK" must send the ajax request and update content
	$('#filt .filter-ok, #filt .filter-risk').on('click', function()
	{
		var risks = '';
		$('#filt .filter-risk.selected').each(function() 
		{
			if( $(this).text() == 'EXTREME')
				risks += ',5';
			else if( $(this).text() == 'MEDIUM')
				risks += ',3,4';
			else if( $(this).text() == 'LOW')
				risks += ',1,2';
		});
		
		var eventTypes = addText('#filt .filter-eventType.selected');

		var countries = '';
		if($('#filt .filter-all.selected').length == 1) // "All countries" selected
			countries = addText('#filt .filter-country');
		else
			countries = addText('#filt .filter-country.selected');

		// Let's retrieve the publications
		$.get('publications/filter', 
			  { 'risks': risks, 'event_types': eventTypes, 'affected_countries': countries},
			  function() { $('#main').html('<div class="ajax-loading"></div>');})
			.done(function( data ) 
			{
			    $('#main').html(data);
			})
			.fail(function() 
			{
				//FIXME: Redirect to an error page
			    alert( "Sorry, an error occurred, please reload the page :(" );
			});
	});
}

/**
 * Utility function for returning every words in some selector separated by commas
 */
function addText(selector)
{
	var temp = '';
	$(selector).each(function() 
	{
		temp += ',' + $(this).text();
	});

	return temp;
}