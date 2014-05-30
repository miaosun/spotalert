@extends('layouts.default')

@section('content')

<div class="container-fluid">
	<div id="controlpanel" class="col-md-10 col-md-offset-1"> 
		<div class="row">
			<ul>
				<li id="active"> {{ Lang::get('controlpanel.menu.profile') }} </li>
				<li><a href="{{ URL::route('user-notifications') }}">{{ Lang::get('controlpanel.menu.notification') }}</a></li>
				@if($user->type != 'normal')
				<li><a href="{{ URL::route('user-eyewitnesses') }}">{{ Lang::get('controlpanel.menu.eyewitnesses') }}</a></li>
                <li><a href="{{ URL::route('user-publications') }}">{{ Lang::get('controlpanel.menu.publications') }}</a></li>
				<li><a href="{{ URL::route('user-comments') }}">{{ Lang::get('controlpanel.menu.comments') }}</a></li>
                @if($user->type == 'admin' || $user->type == 'manager')
                <li><a href="{{ URL::route('user-privileges') }}">{{ Lang::get('controlpanel.menu.privileges') }}</a></li>
                @endif
                @endif
			</ul>
			<h1>{{ Lang::get('controlpanel.profile.title') }}</h1>
			{{ Form::open(array('route' => 'update-profile', 'file' => 'true')) }}
			<div class="col-md-4 col-md-offset-1">
				<div class="row">
                    <div class="col-md-12">
						<div class="col-md-10 custom-upload">
							{{ /* FIXME FROM HARCODED */ HTML::image('assets/images/user/2.jpg', $alt="Lang::get('controlpanel.profile.altpic')", $attributes = array('width' => '200px', 'height' => '200px')) }}
	                        {{ Form::file('uploadfile',array('class' => 'upload')) }}
	                        <div class="fake-file dotline">
	                            {{ Form::text('displayfile',Lang::get('controlpanel.profile.addpic'),array('id'=>'displayfile','disabled' => 'disabled')) }} 
	                            <span>&#43;</span>
	                        </div>
	                    </div>
                	</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<h2> {{ Lang::get('controlpanel.profile.password.title') }} </h2>
						
						{{ Form::label('newpassword',Lang::get('controlpanel.profile.password.new'), array('class' => 'label')) }}
						{{ Form::password('newpassword') }}
                        @if($errors->has('newpassword'))
                        <br><span>{{ $errors->first('newpassword') }}</span>
                        @endif

						{{ Form::label('newmpassword_confirmation',Lang::get('controlpanel.profile.password.confirm'), array('class' => 'label')) }}
						{{ Form::password('newpassword_confirmation') }}
                        @if($errors->has('newpassword_confirmation'))
                        <br><span>{{ $errors->first('newpassword_confirmation') }}</span>
                        @endif
						{{ Form::submit(Lang::get('controlpanel.profile.okbutton')) }}
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('username',Lang::get('controlpanel.profile.username'), array('class' => 'label')) }}
					</div>
					<div class="col-md-7 col-md-offset-1">
                        <div class="dotline" id="username">
						  {{ Form::text('username',$user->username,array('disabled' => 'disabled','placeholder'=>'Insert Username')) }}
					       <span class="glyphicon glyphicon-edit editbutton"></span>
                        </div>
                        @if($errors->has('username'))
                        <br><span>{{ $errors->first('username') }}</span>
                        @endif
                    </div>
				</div>	
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('name',Lang::get('controlpanel.profile.name'), array('class' => 'label')) }}
					</div>
					<div class="col-md-7 col-md-offset-1">
                        <div class="dotline" id="firstname">
						  {{ Form::text('firstname',$user->firstname,array('disabled' => 'disabled','placeholder'=>'Insert firstname')) }}
						  <span class="glyphicon glyphicon-edit editbutton"></span>
                        </div>
                        @if($errors->has('firstname'))
                        <br><span>{{ $errors->first('firstname') }}</span>
                        @endif
                        <div class="dotline" id="lastname">
                            {{ Form::text('lastname',$user->lastname,array('disabled' => 'disabled','placeholder'=>'Insert secondname')) }}
					       <span class="glyphicon glyphicon-edit editbutton"></span>
                        </div>
                        @if($errors->has('lastname'))
                        <br><span>{{ $errors->first('lastname') }}</span>
                        @endif
                    </div>
				</div>
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('residence',Lang::get('controlpanel.profile.residence'), array('class' => 'label')) }}
					</div>
					<div class="col-md-7 col-md-offset-1">
						<div class="dotline" id="residence">
                            {{ Form::text('residence',$user->residence->name,array('disabled' => 'disabled','placeholder'=>'pick residence')) }}
                            <span class="glyphicon glyphicon-edit editbutton"></span>
					   </div>
                        @if($errors->has('residence'))
                        <br><span>{{ $errors->first('residence') }}</span>
                        @endif
                    </div>
				</div>
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('nationality',Lang::get('controlpanel.profile.nationality'), array('class' => 'label')) }}
					</div>
					<div class="col-md-7 col-md-offset-1">
						<div class="dotline" id="nationality">
                            {{ Form::text('nationality',$user->nationality->name,array('disabled' => 'disabled','placeholder'=>'pick nationality')) }}
                            <span class="glyphicon glyphicon-edit editbutton"></span>
                        </div>
                        @if($errors->has('nationality'))
                        <br><span>{{ $errors->first('nationality') }}</span>
                        @endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('agerange',Lang::get('controlpanel.profile.agerange'), array('class' => 'label')) }}
					</div>
					<div class="col-md-7 col-md-offset-1">
                        <div class="dotline" id="agerange">
                            {{ Form::text('agerange',$user->age->stepname,array('disabled' => 'disabled','placeholder'=>'Choose age range')) }}
                            <span class="glyphicon glyphicon-edit editbutton"></span>
                        </div>
                        @if($errors->has('agerange'))
                        <br><span>{{ $errors->first('agerange') }}</span>
                        @endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('email',Lang::get('controlpanel.profile.email'), array('class' => 'label')) }}
					</div>
					<div class="col-md-7 col-md-offset-1" >
                        <div class="dotline" id="email">
						  {{ Form::text('email',$user->email,array('disabled' => 'disabled','placeholder'=>'Insert valid email')) }}
					       <span class="glyphicon glyphicon-edit editbutton"></span>
                        </div>
                        @if($errors->has('email'))
                        <br><span>{{ $errors->first('email') }}</span>
                        @endif
                    </div>
				</div>
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('phone',Lang::get('controlpanel.profile.phone'), array('class' => 'label')) }}
					</div>
					<div class="col-md-7 col-md-offset-1" >
						<div class="dotline" id="phonenumber">
                            {{ Form::text('phonenumber',$user->phonenumber,array('disabled' => 'disabled','placeholder'=>'Insert Phonenumber')) }}
                            <span class="glyphicon glyphicon-edit editbutton"></span>
                        </div>
                        @if($errors->has('phonenumber'))
                        <br><span>{{ $errors->first('phonenumber') }}</span>
                        @endif
                    </div>
				</div>
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('address',Lang::get('controlpanel.profile.address'), array('class' => 'label')) }}
					</div>
					<div class="col-md-7 col-md-offset-1">
                        <div class="dotline" id="address">
						  {{ Form::text('address',$user->address,array('disabled' => 'disabled','placeholder'=>'Insert Address')) }}
                            <span class="glyphicon glyphicon-edit editbutton"></span>
                        </div>
                        @if($errors->has('address'))
                        <br><span>{{ $errors->first('address') }}</span>
                        @endif
                        <div class="dotline" id="city">
						  {{ Form::text('city',$user->city,array('disabled' => 'disabled','placeholder'=>'Insert city')) }}
                            <span class="glyphicon glyphicon-edit editbutton"></span>
                        </div>
                        @if($errors->has('city'))
                        <br><span>{{ $errors->first('city') }}</span>
                        @endif
                        <div class="dotline" id="postalcode">
						  {{ Form::text('postalCode',$user->postalCode,array('disabled' => 'disabled','placeholder'=>'Insert postalCode')) }}
                            <span class="glyphicon glyphicon-edit editbutton"></span>
                        </div>
                        @if($errors->has('postalCode'))
                        <br><span>{{ $errors->first('postalCode') }}</span>
                        @endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('date',Lang::get('controlpanel.profile.date'), array('class' => 'label')) }}
					</div>
					<div class="col-md-7 col-md-offset-1">
						<div class="dotline" id="date">
                            {{ Form::text('date',$user->date,array('disabled' => 'disabled')) }}
                        </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('organization',Lang::get('controlpanel.profile.organization'), array('class' => 'label')) }}
					</div>
					<div class="col-md-7 col-md-offset-1">
                        <div class="dotline" id="organization">
                            {{ Form::text('organization',$user->organization,array('disabled' => 'disabled')) }}
                        </div>
					</div>
				</div>
			</div>
		</div>
		{{ Form::close() }}
	</div>
</div>

<style>
#controlpanel li {
@if($user->type == 'normal')
    width: 49%;
@elseif($user->type == 'publisher')
	width: 19%;
@endif
}
</style>

{{ HTML::script('scripts/controlpanel.js') }}
@stop