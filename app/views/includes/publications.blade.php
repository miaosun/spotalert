@foreach ($publications as $publication)
    	
	<div class="col-md-3 col-sm-10 publication-{{{$publication['type']}}} publ-risk{{{$publication['risk']}}}"
		id="publ-{{ $publication['id'] }}">
		
		<div class="publ_header">
			@if ($publication['type'] == 'alert')


				@if($publication['risk'] >= 1 && $publication['risk'] <=2)
					<div class="ray_low"></div>
				@endif

				@if($publication['risk'] >= 3 && $publication['risk'] <=4)
					<div class="ray_medium"></div>
				@endif

				@if($publication['risk'] >= 5)
					<div class="ray_high"></div>
				@endif


			@else
				<div class="plus"></div>

			@endif

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
		</div>

			<hr>


		<div class="publ_body">
			
				<div class="publ-title">{{{$publication['title']}}}</div>
			
		</div>

			<hr>

		<div class="col-md-12 publ_footer">
			<div class="row">
				<div class="button_edit">
					@if ($publication['risk'] >=5 && $publication['type'] == 'alert')
						<button class="glyphicon glyphicon-edit btn_white"></button>
						<button type="button" class="glyphicon glyphicon-remove btn_white"></button>
					@else
						<button class="glyphicon glyphicon-edit btn_gray"></button>
						<button type="button" class="glyphicon glyphicon-remove btn_gray"></button>
					@endif

				</div>
			</div>

			<div class="row">
				@if ($publication['risk'] >=5 && $publication['type'] == 'alert')
					<button class="glyphicon glyphicon-chevron-down arrow_white"></button>
				@else
					<button class="glyphicon glyphicon-chevron-down arrow_gray"></button>
				@endif
			</div>
		</div>

	</div>

@endforeach