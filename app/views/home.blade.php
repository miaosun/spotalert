@extends('layouts.default')

@section('content')
    @foreach ($publications as $publication)
    	
		<div class="col-md-5 publication-{{{$publication->type}}} publ-risk{{{$publication->risk}}}" id="publ-{{ $publication->id }}" style="border-style:solid;border-width:1px;">
    			
    			<div class="publ-risk">
    			<img class="ray-high"src="{{asset('assets/images/ray_high.png')}}"></img>
    			<img class="ray-low"src="{{asset('assets/images/ray_low.png')}}"></img>
    			<img class="ray-medium"src="{{asset('assets/images/ray_medium.png')}}"></img>
    			<img class="cross-plus"src="{{asset('assets/images/plus.png')}}"></img>
    			
    		</div>
    		
    		<div class="publ-type">
    			@foreach ($publication->eventTypes as $eventType)
					{{{$eventType->name}}}
				@endforeach
			
			</div>
			
			<div class="publ-countr">
				@foreach ($publication->affectedCountries as $country)
					{{{$country->name}}}<br>
				@endforeach
			</div>
			
				<hr>
			
			<div class="publ-title">{{{$publication->contents->first()->title}}}</div>
			
				<hr>
			
			<form id="arrow-expand">
				<input class="arrow_white" type="image" src="{{asset('assets/images/arrow_white.png')}}">
			</form>
			<form id="arrow-expand2">
			<input class="arrow_gray" type="image" src="{{asset('assets/images/arrow_gray.png')}}">	
			</form>
			</div>

    @endforeach
@stop

