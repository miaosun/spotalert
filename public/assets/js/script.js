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
    FB.Event.subscribe('edge.create', function(targetUrl) {
        ga('send', {
          'hitType': 'social',
          'socialNetwork': 'facebook',
          'socialAction': 'share',
          'socialTarget': 'http://spotalert.fe.up.pt',
          'page': '/publication/'+id
            });
        alert('enviou hit sobre o share no facebook para o id:'+id);
    });
});
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
    alert('enviou hit sobre o share no facebook para o id:'+id);
}
// Send hit to google analytics for a Twitter tweet
function shareTwitter(id){
    ga('send', {
  'hitType': 'social',
  'socialNetwork': 'twitter',
  'socialAction': 'tweet',
  'socialTarget': 'http://spotalert.fe.up.pt/publication/'+id
    });
    alert('enviou hit sobre o share no twitter para o id:'+id);
}
// Send hit to google analytics for a google share 
function shareGoogle(id){
    var a = ga('send','social','google','shareplus','http://spotalert.fe.up.pt','/publication/'+id);
     alert('enviou hit sobre o share no google para o id:'+id);
}
// Send hit to google analytics for a linkdIn share
function shareGoogle(id){
    var a = ga('send','social','google','shareplus','http://spotalert.fe.up.pt','/publication/'+id);
     alert('enviou hit sobre o share no google para o id:'+id);
}

