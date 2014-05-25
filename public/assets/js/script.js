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

    // Everything for searching to work
    searching();

    // Everything for deleting a publication
    deletePublication();

    // Infinite scrolling
    $('.scroll').jscroll(
    {
    	nextSelector: 'a.jscroll-next:last'
    });
    
    // setting up expand buttons for publication
    setupBtnPublication();
});


function filtering()
{
	// Function for possibility to have submenus dropdown on filtering menu
	$("#filt .dropdown-menu > div > a.trigger").on("click",function(e)
	{
		var current     = $(this).next();
		var grandparent = $(this).parent().parent();
		var children    = $(this).children();

		if(children.hasClass('glyphicon-chevron-right') || children.hasClass('glyphicon-chevron-left'))
			children.toggleClass('glyphicon-chevron-right glyphicon-chevron-left');
		
		grandparent.find('.glyphicon-chevron-left').not(children).toggleClass('glyphicon-chevron-right glyphicon-chevron-left');
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
		$.get('/publications/filter', 
			  { 'risks': risks, 'event_types': eventTypes, 'affected_countries': countries},
			  function() { $('#main').html('<div class="ajax-loading"></div>' + loading_message);})
			.done(function( data ) 
			{
				if(data.length == 0)
					$('#main').html(nothing_returned_message);
				else
			    	$('#main').html(data);
			    // Infinite scrolling
			    $('.scroll').jscroll(
			    {
			    	nextSelector: 'a.jscroll-next:last'
			    });
                // reload click on btns
                setupBtnPublication();
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
		$.post('/publications/delete/' + id_publ)
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
			$.get('/publications/search/' + search_content,
				  function() { $('#main').html('<div class="ajax-loading"></div>' + loading_message);})
				.done(function( data ) 
				{
					if(data.length == 0)
						$('#main').html(nothing_returned_message);
					else
				    	$('#main').html(data);

				    // Infinite scrolling
				    $('.scroll').jscroll(
				    {
				    	nextSelector: 'a.jscroll-next:last'
				    });

                    setupBtnPublication();
				})
				.fail(function() 
				{
					//FIXME: Redirect to an error page
				    alert( "Sorry, an error occurred, please reload the page :(" );
				});
		}
	});
}

/**
* Get publication content by ajax
**/
function getPublicationContent(id)
{
    jQuery.getJSON("publications/content/"+id,function(data){
        // fill description
        $('#publ-'+id+' .publ-content p').html(data.content);
        // fill linked publications
        if(data.pubLinked.length == 0)
            $('#publ-'+id+' .publ-linked').remove();
        else
        {
            var links = "";
            for(var i = 0; i < data.pubLinked.length ; i++){
                links = links + "<p><a href='publication/"+id+"'>"+data.pubLinked[i].title+"</a>";
            }
            $('#publ-'+id+' .publ-content .publ-linked-toggle').html(links);
        }
        // fill comments 
        if(data.comments.length == 0)
            $('#publ-'+id+' .publ-comments').remove();
        else
        {
            //TODO insert number of comments
            var links = "";
            for(var i = 0; i < data.comments.length ; i++){
                if(i != 0)
                    links = links +"<hr>"
                links = links +
                    "<div class='comments'>\
                    <p class='comments-content'>"+data.comments[i].content+"</p>\
                    <p class='comments-info'>"+data.comments[i].user+" - "+data.comments[i].date.date+"</p>\
                    </div>";
            }
            //alert(links);
            $('#publ-'+id+' .publ-content .publ-comments-toggle').html(links);
        }
        // change btn to toggle only
        var btn = $('#publ-'+id+' .publ-expand');
        btn.unbind();
        btn.click(function(){
            togglePubBtn(id);
        });
        // show content
        togglePubBtn(id);
    });
}
// toggle expansion btn
function togglePubBtn(id)
{
    var btn = $('#publ-'+id+' .publ-expand');
    btn.toggleClass("glyphicon-chevron-down");
    btn.toggleClass("glyphicon-chevron-up");
    $('#publ-'+id+' .publ-colapse').toggle();
    
}
// toggle linked div and arrow
function toggleLinkedBtn(id)
{
    var btn = $('#publ-'+id+' .publ-linked-toggle-btn');
    btn.toggleClass("glyphicon-chevron-right");
    btn.toggleClass("glyphicon-chevron-down");
    $('#publ-'+id+' .publ-linked-toggle').toggle();
    
}
// toggle comments div and arrow
function toggleCommentsBtn(id)
{
    var btn = $('#publ-'+id+' .publ-comments-toggle-btn');
    btn.toggleClass("glyphicon-chevron-right");
    btn.toggleClass("glyphicon-chevron-down");
    $('#publ-'+id+' .publ-comments-toggle').toggle();
    
}
// setup btn to expand and load updated data missing
function setupBtnPublication(){
    $('.publ-expand').bind('click','.publ-expand', function(){
        var id = $(this).attr('publicationid');
        getPublicationContent(id);
    });
    $('.publ-linked-toggle-btn').bind('click',function(){
        var id = $(this).attr('publicationid');
        toggleLinkedBtn(id);
    });
    $('.publ-comments-toggle-btn').bind('click',function(){
        var id = $(this).attr('publicationid');
        toggleCommentsBtn(id);
    });
}

/**
* Share links code
**/
// Send hit to google analytics for a facebook share
function shareFacebook(id){
    ga('send', {
  'hitType': 'social',
  'socialNetwork': 'facebook',
  'socialAction': 'share',
  'socialTarget': 'http://spotalert.fe.up.pt',
  'page': '/publication/'+id
    });
    //alert('enviou hit sobre o share no facebook para o id:'+id);
}
// Send hit to google analytics for a Twitter tweet
function shareTwitter(id){
    ga('send', {
  'hitType': 'social',
  'socialNetwork': 'twitter',
  'socialAction': 'tweet',
  'socialTarget': 'http://spotalert.fe.up.pt/publication/'+id
    });
    //alert('enviou hit sobre o share no twitter para o id:'+id);
}
// Send hit to google analytics for a google share 
function shareGoogle(id){
    var a = ga('send','social','google','shareplus','http://spotalert.fe.up.pt','/publication/'+id);
     //alert('enviou hit sobre o share no google para o id:'+id);
}
// Send hit to google analytics for a linkdIn share
function shareLinkdIn(id){
    var a = ga('send','social','Linkdin','share','http://spotalert.fe.up.pt','/publication/'+id);
     //alert('enviou hit sobre o share no linkdIn para o id:'+id);
}
