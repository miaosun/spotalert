@extends('layouts.default')

@section('content')
{{ isset($msg) ? $msg : '' }}
<div class="container-fluid">
	<div id="controlpanel" class="col-md-8 col-md-offset-2"> 
		<div class="row">
			<ul>
				<!-- FIXME change this for publication before to hide left curve active to selected -->
				<li id="before"> {{ Lang::get('controlpanel.menu.profile') }} </li>
				<li id="active"> {{ Lang::get('controlpanel.menu.notification') }} </li>
				<li> {{ Lang::get('controlpanel.menu.publications') }} </li>
				<li> {{ Lang::get('controlpanel.menu.comments') }} </li>
				<li> {{ Lang::get('controlpanel.menu.privileges') }} </li>
			</ul>
			<h1>{{ Lang::get('controlpanel.profile.title') }}</h1>
			{{ Form::open(array('route' => 'update-profile', 'file' => 'true')) }}  					
			<div class="col-md-4 col-md-offset-1">
				<div class="row">
					{{ HTML::image('assets/images/user/unknown.jpg', $alt="Lang::get('controlpanel.profile.altpic')", $attributes = array('width' => '200px', 'height' => '200px')) }}
					<div class="fileupload col-md-10">
						{{ Form::text('uploadfile',Lang::get('controlpanel.profile.addpic'),array('disabled' => 'disabled', 'class'=>'col-md-10')) }}
    					<span class="col-md-2">&#043;</span>
    					{{ Form::file('uploadbtn',array('class' => 'upload')) }} 
					</div>
					<script type="text/javascript">
						document.getElementById("uploadbtn").onchange = function () {
    					document.getElementById("uploadfile").value = this.value;
						};
					</script> 
				</div>
				<div class="row">
					<div class="col-md-12">
						<h2> {{ Lang::get('controlpanel.profile.password.title') }} </h2>
						{{ Form::label('newpassword',Lang::get('controlpanel.profile.password.new'), array('class' => 'label')) }}
						{{ Form::password('newpassword') }}
						{{ Form::label('confirmpassword',Lang::get('controlpanel.profile.password.confirm'), array('class' => 'label')) }}
						{{ Form::password('confirmpassword') }}
						
						{{ Form::submit(Lang::get('controlpanel.profile.okbutton')) }}
					</div>
				</div>
			</div>
			<div class="col-md-6 col-md-offset-1">
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('username',Lang::get('controlpanel.profile.username'), array('class' => 'label')) }}
					</div>
					<div class="col-md-7 col-md-offset-1">
						{{ Form::text('username') }}
					</div>
				</div>	
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('name',Lang::get('controlpanel.profile.name'), array('class' => 'label')) }}
					</div>
					<div class="col-md-7 col-md-offset-1">
						{{ Form::text('firstname') }}
						{{ Form::text('lastname') }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('residence',Lang::get('controlpanel.profile.residence'), array('class' => 'label')) }}
					</div>
					<div class="col-md-7 col-md-offset-1">
						{{ Form::text('residence') }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('nationality',Lang::get('controlpanel.profile.nationality'), array('class' => 'label')) }}
					</div>
					<div class="col-md-7 col-md-offset-1">
						{{ Form::text('nationality') }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('agerange',Lang::get('controlpanel.profile.agerange'), array('class' => 'label')) }}
					</div>
					<div class="col-md-7 col-md-offset-1">
						{{ Form::text('agerange') }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('email',Lang::get('controlpanel.profile.email'), array('class' => 'label')) }}
					</div>
					<div class="col-md-7 col-md-offset-1">
						{{ Form::text('email') }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('phone',Lang::get('controlpanel.profile.phone'), array('class' => 'label')) }}
					</div>
					<div class="col-md-7 col-md-offset-1">
						{{ Form::text('phone') }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('address',Lang::get('controlpanel.profile.address'), array('class' => 'label')) }}
					</div>
					<div class="col-md-7 col-md-offset-1">
						{{ Form::text('address') }}
						{{ Form::text('city') }}
						{{ Form::text('postalcode') }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('date',Lang::get('controlpanel.profile.date'), array('class' => 'label')) }}
					</div>
					<div class="col-md-7 col-md-offset-1">
						{{ Form::text('date') }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('organization',Lang::get('controlpanel.profile.organization'), array('class' => 'label')) }}
					</div>
					<div class="col-md-7 col-md-offset-1">
						{{ Form::text('organization') }}
					</div>
				</div>
			</div>
		</div>
		{{ Form::close() }}
	</div>
</div>
@stop