@extends('layouts.default')

@section('content')
	<form action="{{ URL::route('account-sign-in-post') }}" method="post">
		
		<div class="field">
			Email: <input type="text" name="email" {{ (Input::old('email')) ? ' value="' . Input::old('email') . '"' : '' }}>
			@if($errors->has('email'))
				{{ $errors->first('email') }}
			@endif
		</div>

		<div class="field">
			Password: <input type="text" name="password">
			@if($errors->has('password'))
				{{ $errors->first('password') }}
			@endif
		</div>

		<div class="filed">
			<input type="checkbox" name="remember" id="remember">
			<label for="remember">
				Remember me
			</label>
		</div>

		<input type="submit" value="Sign in">
		{{ Form::token() }}
	</form>
@stop