@extends('layouts.default')

@section('content')
	<p> Teste de Git pull automático por parte do servidor v1.1</p>
	@if(Auth::check())
		<p>Hello, {{ Auth::user()->username }}.</p>
	@else
		<p>You are not signed in.</p>
	@endif
	
@stop