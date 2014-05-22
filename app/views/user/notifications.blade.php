@extends('layouts.default')

@section('content')
{{ isset($errors) ? $errors : "sem_erros <br>" }}

<div class="container-fluid">
    <div id="controlpanel" class="col-md-8 col-md-offset-2">
        <div class="row" id="notifications">
            <ul>
                <!-- FIXME change this for publication before to hide left curve active to selected -->
                <li id="before"><a href="{{ URL::route('control-panel') }}">{{ Lang::get('controlpanel.menu.profile') }}</a></li>
                <li id="active">{{ Lang::get('controlpanel.menu.notification') }}</li>
                <li><a href="{{ URL::route('user-publications') }}">{{ Lang::get('controlpanel.menu.publications') }}</a></li>
                <li><a href="{{ URL::route('user-comments') }}">{{ Lang::get('controlpanel.menu.comments') }}</a></li>
                <li><a href="{{ URL::route('user-privileges') }}">{{ Lang::get('controlpanel.menu.privileges') }}</a></li>
            </ul>
            <h1>{{ Lang::get('controlpanel.notifications.title') }}</h1>

            <div class="row">
                <div class="col-md-12 col-md-offset-0">
                    <div class="col-md-2">
                        <h3>{{ Lang::get('controlpanel.notifications.select') }}</h3>
                    </div>
                    <div class="col-md-3 col-md-offset-0 resid-drop">
                        {{ Form::select('region', $country_options , Input::old('region')) }}
                        @if($errors->has('region'))
                        <br><span>{{ $errors->first('region') }}</span>
                        @endif
                    </div>
                    <div class="col-md-3 col-md-offset-0 resid-drop">
                        {{ Form::select('region', $country_options , Input::old('region')) }}
                        @if($errors->has('region'))
                        <br><span>{{ $errors->first('region') }}</span>
                        @endif
                    </div>
                    <div class="col-md-2 col-md-offset-0">
                        {{ Form::submit(Lang::get('controlpanel.notifications.add')) }}
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{ Form::close() }}
</div>

{{ HTML::script('scripts/controlpanel.js') }}
{{ HTML::style('http://cdn.datatables.net/1.10.0/css/jquery.dataTables.css'); }}
@stop