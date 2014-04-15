@extends('layouts.default')

@section('content')
	@if(Auth::check())
		<p>Hello, {{ Auth::user()->username }}.</p>
	@else
		<p>You are not signed in.</p>
	@endif
	
@stop