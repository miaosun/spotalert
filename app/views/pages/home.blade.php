@extends('layouts.default')

@section('content')
	<p> Teste de pull automático por parte do servidor v1.0</p>
	@if(Auth::check())
		<p>Hello, {{ Auth::user()->username }}.</p>
	@else
		<p>You are not signed in.</p>
	@endif
	
@stop