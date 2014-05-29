@extends('layouts.default')

@section('content')

<div class="container-fluid">
    <div id="controlpanel" class="col-md-10 col-md-offset-1">
        <div class="row" id="notifications">
            <ul>
                <li id="before"><a href="{{ URL::route('control-panel') }}">{{ Lang::get('controlpanel.menu.profile') }}</a></li>
                <li id="active">{{ Lang::get('controlpanel.menu.notification') }}</li>
                @if($user->type != 'normal')
                <li><a href="{{ URL::route('user-eyewitnesses') }}">{{ Lang::get('controlpanel.menu.eyewitnesses') }}</a></li>
                <li><a href="{{ URL::route('user-publications') }}">{{ Lang::get('controlpanel.menu.publications') }}</a></li>
                <li><a href="{{ URL::route('user-comments') }}">{{ Lang::get('controlpanel.menu.comments') }}</a></li>
                @if($user->type == 'admin' || $user->type == 'manager')
                <li><a href="{{ URL::route('user-privileges') }}">{{ Lang::get('controlpanel.menu.privileges') }}</a></li>
                @endif
                @endif

            </ul>
            <h1>{{ Lang::get('controlpanel.notifications.title') }}</h1>

            <div class="row">
                {{ Form::open(array('route' => 'country-risk-notification')) }}
                <div class="col-md-12 col-md-offset-0">
                    <div class="col-md-2">
                        <h3>{{ Lang::get('controlpanel.notifications.select') }}</h3>
                    </div>
                    <div class="col-md-3 col-md-offset-0 resid-drop">
                        {{ Form::select('country', $country_options , Input::old('country'), array('class' => 'styled')) }}
                        @if($errors->has('country'))
                        <br><span>{{ $errors->first('region') }}</span>
                        @endif
                    </div>
                    <div class="col-md-3 col-md-offset-0 resid-drop">
                        {{ Form::select('minimum_risk', array('placeholder' => Lang::get('controlpanel.notifications.minimum_risk'), '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'), null, array('class' => 'styled')) }}
                        @if($errors->has('region'))
                        <br><span>{{ $errors->first('region') }}</span>
                        @endif
                    </div>
                    <div class="col-md-2 col-md-offset-0">
                        {{ Form::submit(Lang::get('controlpanel.notifications.add')) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>

            @foreach ($notification_settings as $notification_setting)
            <div class="col-md-12 country_risk">
                <div class="col-md-4 col-md-offset-2">
                    {{ $notification_setting['country']['name'] }}
                </div>
                <div class="col-md-3">
                    {{ $notification_setting['risk'] }}
                </div>
                <div class="col-md-3" id="delete">
                    <a href="{{ URL::route('notification-delete', $notification_setting['id'])}}">X</a>
                </div>
            </div>
            @endforeach

            <div class="row">
                {{ Form::open(array('route' => 'publication-notification')) }}
                <div class="col-md-12 col-md-offset-0">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 col-md-offset-0 resid-drop">
                        {{ Form::select('publication', $publication_options , Input::old('publication'), array('class' => 'styled')) }}
                        @if($errors->has('publication'))
                        <br><span>{{ $errors->first('publication') }}</span>
                        @endif
                    </div>
                    <div class="col-md-3 col-md-offset-0"></div>
                    <div class="col-md-2 col-md-offset-0">
                        {{ Form::submit(Lang::get('controlpanel.notifications.add')) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>

            @foreach ($user_publications as $user_publication)
            <div class="col-md-12 country_risk">
                <div class="col-md-7 col-md-offset-2">
                    {{ $user_publication->contents->first()->title }}
                </div>
                <div class="col-md-3" id="delete">
                    <a href="{{ URL::route('publication-delete', $user_publication->id)}}">X</a>
                </div>
            </div>
            @endforeach
        </div>
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

@stop