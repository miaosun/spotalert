@foreach ($publications as $publication)
    	
	<div class="col-md-5 publication-{{{$publication['type']}}} publ-risk{{{$publication['risk']}}}"
		id="publ-{{ $publication['id'] }}" style="border-style:solid;border-width:1px;">
			
		<div class="publ-risk">
			<img class="ray-high"src="{{asset('assets/images/ray_high.png')}}"></img>
			<img class="ray-low"src="{{asset('assets/images/ray_low.png')}}"></img>
			<img class="ray-medium"src="{{asset('assets/images/ray_medium.png')}}"></img>
			<img class="cross-plus"src="{{asset('assets/images/plus.png')}}"></img>
		</div>
	
		<div class="publ-type">
			@foreach ($publication['event_types'] as $eventType)
				{{{$eventType}}}
			@endforeach
		</div>
		
		<div class="publ-countr">
			@foreach ($publication['affected_countries'] as $country)
				{{{$country}}}<br>
			@endforeach
		</div>
		
		<hr>
		
		<div class="publ-title">{{{$publication['title']}}}</div>
		
		<hr> 
        <!-- facebook -->
        <a href="https://www.facebook.com/sharer/sharer.php?u={http://spotalert.fe.up.pt/publication/{{{$publication['id']}}}"
   onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');shareFacebook({{{$publication['id']}}});return false;"
   target="_blank" title="Share on Facebook">
            <img src="https://www.gstatic.com/images/icons/gplus-16.png" alt="Share on Facebook"/></a>
        </a>
        <!-- google+ -->
        <a href="https://plus.google.com/share?url={http://spotalert.fe.up.pt/publication/{{{$publication['id']}}}" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');shareGoogle({{{$publication['id']}}});return false;" target="_blank" title="Share on Google+">
            <img src="https://www.gstatic.com/images/icons/gplus-16.png" alt="Share on Google+"/>
        </a>
        <!-- twitter -->
        <a href="https://twitter.com/share?url=http://spotalert.fe.up.pt/publication/{{{$publication['id']}}}&hashtags=SPOTALERT&text={{{$publication['title']}}}"
   onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');shareTwitter({{{$publication['id']}}});return false;"
   target="_blank" title="Share on Twitter">
            <img src="https://www.gstatic.com/images/icons/gplus-16.png" alt="Share on Twitter"/>
        </a>
        <!-- linkedIn -->
        <a href="http://www.linkedin.com/shareArticle?mini=true&url=http://spotalert.fe.up.pt/publication/{{{$publication['id']}}}&title={{{$publication['title']}}}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');shareLinkdIn({{{$publication['id']}}});return false;"
   target="_blank" title="Share on LinkdIn">
            <img src="https://www.gstatic.com/images/icons/gplus-16.png" alt="Share on LinkdIn"/>
        </a>

		<hr>
		<form id="arrow-expand">
			<input class="arrow_white" type="image" src="{{asset('assets/images/arrow_white.png')}}">
		</form>
		<form id="arrow-expand2">
			<input class="arrow_gray" type="image" src="{{asset('assets/images/arrow_gray.png')}}">	
		</form>
	</div>

@endforeach