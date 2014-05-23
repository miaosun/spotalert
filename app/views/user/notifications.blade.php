@extends('layouts.default')

@section('content')

<div class="container-fluid">
    <div id="controlpanel" class="col-md-8 col-md-offset-2">
        <div class="row" id="notifications">
            <ul>
                <li id="before"><a href="{{ URL::route('control-panel') }}">{{ Lang::get('controlpanel.menu.profile') }}</a></li>
                <li id="active">{{ Lang::get('controlpanel.menu.notification') }}</li>
                <li><a href="{{ URL::route('user-publications') }}">{{ Lang::get('controlpanel.menu.publications') }}</a></li>
                <li><a href="{{ URL::route('user-comments') }}">{{ Lang::get('controlpanel.menu.comments') }}</a></li>
                <li><a href="{{ URL::route('user-privileges') }}">{{ Lang::get('controlpanel.menu.privileges') }}</a></li>
            </ul>
            <h1>{{ Lang::get('controlpanel.notifications.title') }}</h1>

            <div class="row">
                {{ Form::open(array('route' => 'country-risk-notification')) }}
                <div class="col-md-12 col-md-offset-0">
                    <div class="col-md-2">
                        <h3>{{ Lang::get('controlpanel.notifications.select') }}</h3>
                    </div>
                    <div class="col-md-3 col-md-offset-0 resid-drop">
                        {{ Form::select('country', $country_options , Input::old('country')) }}
                        @if($errors->has('country'))
                        <br><span>{{ $errors->first('region') }}</span>
                        @endif
                    </div>
                    <div class="col-md-3 col-md-offset-0 resid-drop">
                        {{ Form::select('minimum_risk', array('placeholder' => Lang::get('controlpanel.notifications.minimum_risk'), '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'), 'placeholder') }}
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
            <div class="table-wrapper">
                <table id="notifiction-list" class="display" cellspacing="0" width="100%">
                    <tbody>
                    @foreach ($notification_settings as $notification_setting)
                    <tr>
                        <td>{{ $notification_setting['country']['name'] }}</td>
                        <td>{{ $notification_setting['risk'] }}</td>
                        <td>X</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row">
                {{ Form::open(array('route' => 'publication-notification')) }}
                <div class="col-md-12 col-md-offset-0">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 col-md-offset-0 resid-drop">
                        {{ Form::select('publication', $publication_options , Input::old('publication')) }}
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

            <div class="table-wrapper">
                <table id="notifiction-list" class="display" cellspacing="0" width="100%">
                    <tbody>
                    @foreach ($user_publications as $user_publication)
                    <tr>
                        <td>{{ $user_publication->title }}</td>
                        <td>X</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    {{ Form::close() }}
</div>

@stop