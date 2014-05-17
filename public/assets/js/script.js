$('document').ready(function() 
{
	// Just to activate the custom scrolling using the jScrollPane jQuery plugin
	$('.scrollable').jScrollPane({ hideFocus : true, autoReinitialise : true, contentWidth : '218px' });

	// If clicking anywhere in the dropdown menu, it doesn't close
	$('.dropdown-menu').click(function(e) {
        e.stopPropagation();
    });

	// Listing of publications
    $('#publ-list').dataTable( {
        "paging":   false,
         "order": [[ 5, "desc" ]],
        "info":     false,
        "searching": false
    } );

    // Everything for filtering to work
    filtering();

    // Everything for searching to work
    searching();

    // Everything for deleting a publication
    deletePublication();
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
		// Clean search bar
		$('#search input#search-input').val('');
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
			  function() { $('#main').html('<div class="ajax-loading"></div>' + loading_message);})
			.done(function( data ) 
			{
				if(data.length == 0)
					$('#main').html(nothing_returned_message);
				else
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


function deletePublication()
{
	$('.button_edit .glyphicon-remove').on('click', function()
	{
		var publ_id = $(this).parent().attr('id');
		$('#myModal .modal-publ-id').remove();
		$('#myModal').append('<div class="modal-publ-id" id="' + publ_id + '"></div>');
		$('#myModal').modal();
	});

	$('#myModal .btn-success').on('click', function()
	{
		$('#myModal').modal('hide');
		var id_publ = $('#myModal .modal-publ-id').attr('id');

		// Let's delete the publications
		$.post('publications/delete/' + id_publ)
			.done(function( data ) 
			{
				if(data == 'ok')
				{
					$('#main .row-publ #publ-' + id_publ).remove();
					alert("Publication successfully removed!");
					location.reload();
				}
				else
					alert("Some error occurred, please try again later");
			})
			.fail(function() 
			{
				//FIXME: Redirect to an error page
			    alert( "Sorry, an error occurred, please reload the page :(" );
			});
	});
}

function searching()
{
	// Selecting "OK" must send the ajax request and update content
	$('form#search').on('submit', function(e)
	{
		var search_content = $('#search input#search-input').val();
		e.preventDefault();

		if(search_content.length > 0)
		{
			//Clean filtering options
			$('#filt .filter-all').removeClass('selected');
			$('#filt .filter-opt').removeClass('selected');

			// Let's retrieve the publications
			$.get('publications/search/' + search_content,
				  function() { $('#main').html('<div class="ajax-loading"></div>' + loading_message);})
				.done(function( data ) 
				{
					if(data.length == 0)
						$('#main').html(nothing_returned_message);
					else
				    	$('#main').html(data);
				})
				.fail(function() 
				{
					//FIXME: Redirect to an error page
				    alert( "Sorry, an error occurred, please reload the page :(" );
				});
		}
	});
}