@extends('layouts.default')

@section('content')
	<p>{{ $user->username }} ({{ $user->email }})</p>
@stop