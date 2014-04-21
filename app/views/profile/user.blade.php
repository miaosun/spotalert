@extends('layouts.default')

@section('content')
	<p>{{ e($user->username) }} ({{ e($user->email) }})</p>
@stop