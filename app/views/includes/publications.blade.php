@foreach ($publications as $publication)
    	
	<div class="col-md-4 col-sm-10 publication-{{{$publication['type']}}} publ-risk{{{$publication['risk']}}}"
		id="publ-{{ $publication['id'] }}">
			
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
		


		
		<form id="edit-publ">
			<input class"edit-button" type="image" src="{{asset('assets/images/edit-white.png')}}">
			<input class"edit-button2" type="image" src="{{asset('assets/images/edit-gray.png')}}">
		</form>
		
		<button type="button" class="close" aria-hidden="true">&times;</button>
		
		<br>
		<form id="arrow-expand">
			<input class="arrow_white" type="image" src="{{asset('assets/images/arrow_white.png')}}">
		</form>

		<form id="arrow-expand2">
			<input class="arrow_gray" type="image" src="{{asset('assets/images/arrow_gray.png')}}">	
		</form>
		
	</div>

@endforeach