@extends('layouts.default')

@section('content')
{{ isset($errors) ? $errors : "sem_erros <br>" }}

<div class="container-fluid">
    <div id="controlpanel" class="col-md-8 col-md-offset-2">
        <div class="row" id="notifications">
            <ul>
                <!-- FIXME change this for publication before to hide left curve active to selected -->
                <li><a href="{{ URL::route('control-panel') }}">{{ Lang::get('controlpanel.menu.profile') }}</a></li>
                <li><a href="{{ URL::route('user-notifications') }}">{{ Lang::get('controlpanel.menu.notification') }}</a></li>
                <li id="before"><a href="{{ URL::route('user-publications') }}">{{ Lang::get('controlpanel.menu.publications') }}</a></li>
                <li id="active"><a href="">{{ Lang::get('controlpanel.menu.comments') }}</a></li>
                <li><a href="{{ URL::route('user-privileges') }}">{{ Lang::get('controlpanel.menu.privileges') }}</a></li>
            </ul>
            <h1>{{ Lang::get('controlpanel.comments.title') }}</h1>

            <div class="row">
                <div class="col-md-12 col-md-offset-0">

                </div>
            </div>

        </div>
    </div>
</div>

{{ HTML::script('scripts/controlpanel.js') }}
{{ HTML::style('http://cdn.datatables.net/1.10.0/css/jquery.dataTables.css'); }}
@stop