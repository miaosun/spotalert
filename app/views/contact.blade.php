@extends('layouts.default')

@section('content')
<div class="container-fluid">
	<div id="contact" class="col-md-4 col-md-offset-4 general_panel"> 
		<div class="row">
			<br>
			<h1>{{ Lang::get('home.contact.title') }}</h1>
			{{ Form::open(array('route' => 'send-contact', 'method' => 'post')) }}

			
				<div class="row">
	                <div class="col-md-4">
	                    {{ Form::label(Lang::get('home.contact.name-label').'*:',null,array('class' => 'label')) }}
	                </div>
	                <div class="col-md-7 col-md-offset-0">
	                    {{ Form::text('name', '', array('placeholder'=>Lang::get('home.contact.name-placeholder'))) }}
	                    @if($errors->has('name'))
                            <br><span class="error_msg">{{ $errors->first('name') }}</span>
                        @endif
	                </div>
	            </div>
	            <div class="row">
	                <div class="col-md-4">
	                    {{ Form::label(Lang::get('home.contact.email-label').'*:',null,array('class' => 'label')) }}
	                </div>
	                <div class="col-md-7 col-md-offset-0">
	                    {{ Form::text('email', '', array('placeholder'=>Lang::get('home.contact.email-placeholder'))) }}
	                    @if($errors->has('email'))
                            <br><span class="error_msg">{{ $errors->first('email') }}</span>
                        @endif
	                </div>
	            </div>
	            <div class="row">
	            	<div class="col-md-12">
	            		{{ Form::label(Lang::get('home.contact.msg-label').'*:',null,array('class' => 'label')) }}
	            	</div>
	            </div>
	            <div class="row">
	            	<div class="col-md-12">
	            		{{ Form::textarea('content', '', array('placeholder'=>Lang::get('home.contact.msg-placeholder'))) }}
	            		@if($errors->has('content'))
                            <br><span class="error_msg contact_error">{{ $errors->first('content') }}</span>
                        @endif
	            	</div>
	            </div>

	            <div class="row">
	            	<div class="col-md-6">
	            		{{ Form::submit(Lang::get('home.contact.send')) }}
	            	</div>
	        	</div>

		</div>
		{{ Form::token() }}
		{{ Form::close() }}
	</div>
</div>


@stop