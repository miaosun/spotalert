$('document').ready(function() 
{
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

    // Style the form's selects
    $('.styled').customSelect();

    // For the radioboxes in the register page
    setRegisterRadioBoxes();
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
                //setupBtnPublication();
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

                    //setupBtnPublication();
				})
				.fail(function() 
				{
					//FIXME: Redirect to an error page
				    alert( "Sorry, an error occurred, please reload the page :(" );
				});
		}
	});
}

function setRegisterRadioBoxes()
{
	$('#create .radiobutton').click(function()
	{
		$(this).children('.glyphicon').addClass('glyphicon-remove');
		$(this).siblings('.radiobutton').children('.glyphicon').removeClass('glyphicon-remove');

		if($(this).children('.glyphicon').hasClass('yes'))
			$('#create .terms-service input#yes').prop('checked', true);
		else
			$('#create .terms-service input#no').prop('checked', true);
	});

	$('#create-alert .radiobutton').click(function()
	{
		$(this).children('.glyphicon').addClass('glyphicon-remove');
		$(this).siblings('.radiobutton').children('.glyphicon').removeClass('glyphicon-remove');

		if($(this).children('.glyphicon').hasClass('public-o'))
			$('#create-alert .visibility input#public-o').prop('checked', true);
		else
			$('#create-alert .visibility input#hidden-o').prop('checked', true);
	});
}

/**
* Get publication content by ajax
**/
function getPublicationContent(id)
{
	var btn = $('#publ-'+id+' .publ-expand');
	if(btn.hasClass('publ-ajax-loaded'))
		togglePubBtn(id);
	else
	{
	    jQuery.getJSON("/publications/content/"+id,function(data){
	        // fill description
	        $('#publ-'+id+' .publ-content p').html(data.content);
            // fill images
            var imgHTML ="";
            for(var i = 0; i < data.images.length ; i++){
                imgHTML = imgHTML + "<a href='"+data.images[i].url+"'><img src='"+data.images[i].url+"'alt='"+data.images[i].alt+"'/></a>";
            }
            $('#publ-'+id+' .pub-content-imgs').html(imgHTML);
	        // fill linked publications
	        if(data.pubLinked.length == 0)
	            $('#publ-'+id+' .publ-linked').remove();
	        else
	        {
                $('#publ-'+id+' .publ-content span.number-linked').html(data.pubLinked.length);
	            var links = "";
	            for(var i = 0; i < data.pubLinked.length ; i++){
	                links = links + "<p><a href='"+data.pubLinked[i].id+"'>"+data.pubLinked[i].title+"</a>";
	            }
	            $('#publ-'+id+' .publ-content .publ-linked-toggle').html(links);
	        }
	        // fill comments 
	        if(data.comments.length == 0){
	            $('#publ-'+id+' .publ-comments-toggle-btn').hide();
            }
	        else
	        {
	            //insert number of comments
                $('#publ-'+id+' .publ-content .publ-comments span.number-comments').html(data.comments.length);
	            var links = "";
	            for(var i = 0; i < data.comments.length ; i++)
                {
	                if(i != 0)
	                    links = links +"<hr>";
                   
                    links = links +"<div class='comments'>";
                    //if exist photo
	                if(data.comments[i].img.length != 0)
                    {
                        links = links +"<div class='comments-imgs'><a href=\""+data.comments[i].img.url+"\">\
                                        <img src='"+data.comments[i].img.url+"'alt='"+data.comments[i].img.alt+"'/>\
                                        </a></div>"
                    }
                    links = links +"<p class='comments-content'>"+data.comments[i].content+"</p>\
                                    <p class='comments-info'>"+data.comments[i].user+" - "+data.comments[i].date.date
	                                ;
                    if(data.comments[i].delete != 0)
                    {
                        links= links + "<span class='comments-delete'>\
                                        <a href='"+data.comments[i].delete.url+"'>"+data.comments[i].delete.text+"</a></span>";
                    }
                    links= links +"</p></div>";
                    
	            }
	            //alert(links);
	            $('#publ-'+id+' .publ-content .publ-comments-area').html(links);
	        }
	        // change btn to toggle only
	        btn.addClass('publ-ajax-loaded');
	        // show content
	        togglePubBtn(id);
	    });
	}
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
// add comments if login
function showAddCommentBtn(id){
    $('#publ-'+id+' .publ-comments-addcomment').show();
    
    var btn = $('#publ-'+id+' .publ-addcomment-btn');
    btn.toggleClass("glyphicon-chevron-right");
    btn.toggleClass("glyphicon-chevron-down");
    $('#publ-'+id+' .publ-comments-toggle').show();
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
    $('div#main').on('click', '.publ-expand', function(){
        var id = $(this).attr('publicationid');
        getPublicationContent(id);
    });
    $('div#main').on('click', '.publ-linked-toggle-btn', function(){
        var id = $(this).attr('publicationid');
        toggleLinkedBtn(id);
    });
    $('div#main').on('click', '.publ-comments-toggle-btn', function(){
        var id = $(this).attr('publicationid');
        toggleCommentsBtn(id);
    });
    $('div#main').on('click', 'span.addcomment-btn', function(){
        var id = $(this).attr('publicationid');
        showAddCommentBtn(id);
    });
    $('div#main').on('click', '.submit-comment-btn ', function(){
    var id = $(this).attr('publicationid');
    
    submitCommentBtn(id);
    });
}

function submitCommentBtn(id){
    data = new FormData();
    data.append('text',$('#publ-'+id+' .publ-comments-addcomment .submit-comment-textarea').val())
    data.append('img',$('#publ-'+id+' .publ-comments-addcomment .submit-comment-file')[0].files[0]);

    $.ajax({
        url : "/user/comments/submit/"+id,
        type: "POST",
        data : data,
        processData: false,
        contentType: false,
        datatype: JSON,
        success: function(data, textStatus, jqXHR)
        {
            alert(data.msg);
            $('#publ-'+id+' .publ-comments-addcomment .submit-comment-textarea').val("");
            $('#publ-'+id+' .publ-comments-addcomment .submit-comment-file').val("");
            $('#publ-'+id+' .publ-comments-addcomment').hide();
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert(textStatus);
        }
    });
}


/**
* Share links code
**/
// Send hit to google analytics for a facebook share
function shareFacebook(id,title){
    ga('send', {
      'hitType': 'social',
      'socialNetwork': 'Facebook',
      'socialAction': 'FacebookShare',
      'socialTarget': window.location.protocol + "//" + window.location.hostname+'/'+id+" Title: "+title
    });
}
// Send hit to google analytics for a Twitter tweet
function shareTwitter(id,title){
    ga('send', {
      'hitType': 'social',
      'socialNetwork': 'Twitter',
      'socialAction': 'Tweet',
      'socialTarget': window.location.protocol + "//" + window.location.hostname+'/'+id+" Title: "+title
    });
}
// Send hit to google analytics for a google share 
function shareGoogle(id,title){
    ga('send', {
      'hitType': 'social',
      'socialNetwork': 'GooglePlus',
      'socialAction': 'GooglePlusShare',
      'socialTarget': window.location.protocol + "//" + window.location.hostname+'/'+id+" Title: "+title
    });
}
// Send hit to google analytics for a linkdIn share
function shareLinkdIn(id,title){
     ga('send', {
      'hitType': 'social',
      'socialNetwork': 'LinkdIN',
      'socialAction': 'LinkdINShare',
      'socialTarget': window.location.protocol + "//" + window.location.hostname+'/'+id+" Title: "+title
     });
}
        
