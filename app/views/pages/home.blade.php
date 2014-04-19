@extends('layouts.default')

@section('content')
    @foreach ($publications as $publication)
    	<div class="publication-{{{$publication->type}}}" id="publ-{{ $publication->id }}" style="border-style:solid;border-width:1px;">
    		<div class="publ-title">{{{$publication->contents->first()->title}}}</div>
    		<div class="publ-risk">{{{$publication->risk}}}</div>
    		<div class="publ-type">
    			@foreach ($publication->eventTypes as $eventType)
					{{{$eventType->name}}}
				@endforeach
			</div>
			<div class="publ-countr">
				@foreach ($publication->affectedCountries as $country)
					{{{$country->name}}}
				@endforeach
			</div>
    	</div>
    @endforeach
@stop