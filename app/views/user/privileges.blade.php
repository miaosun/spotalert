@extends('layouts.default')

@section('content')
{{ isset($errors) ? $errors : "sem_erros <br>" }}

<div class="container-fluid">
    <div id="controlpanel" class="col-md-8 col-md-offset-2">
        <div class="row" id="privileges">
            <ul>
                <!-- FIXME change this for publication before to hide left curve active to selected -->
                <li> {{ Lang::get('controlpanel.menu.profile') }}</li>
                <li> {{ Lang::get('controlpanel.menu.notification') }}</li>
                <li> {{ Lang::get('controlpanel.menu.publications') }}</li>
                <li id="before"> {{ Lang::get('controlpanel.menu.comments') }}</li>
                <li id="active"> {{ Lang::get('controlpanel.menu.privileges') }}</li>
            </ul>
            <h1>{{ Lang::get('controlpanel.privileges.title') }}</h1>
            <div class="row">
                <div class="col-md-12 col-md-offset-0">
                    <div class="col-md-3">
                        <h3>{{ Lang::get('controlpanel.privileges.add_publishers').'/' }}</h3>
                    </div>
                    <div class="col-md-4">
                        {{ Form::text('username',null, array('id'=>'username', 'placeholder'=>Lang::get('controlpanel.privileges.name'))) }}
                        <span class="glyphicon glyphicon-search"></span>
                    </div>
                    <div class="col-md-4">
                        {{ Form::text('department', null,
                        array('placeholder'=>Lang::get('controlpanel.privileges.department'))) }}
                        <span class="glyphicon glyphicon-edit edit_button"></span>
                    </div>
                </div>
                <div class="col-md-12 col-md-offset-0">
                    <div class="col-md-3">
                        <h3>{{ Lang::get('controlpanel.privileges.managers').'/' }}</h3>
                    </div>
                    <div class="col-md-4">
                        {{ Form::text('email', null,
                        array('placeholder'=>Lang::get('controlpanel.privileges.email'))) }}
                        <span class="glyphicon glyphicon-search"></span>
                    </div>
                    <div class="col-md-4">
                        {{ Form::text('permissions', null,
                        array('placeholder'=>Lang::get('controlpanel.privileges.permissions'))) }}
                        <span class="glyphicon glyphicon-search"></span>
                    </div>
                </div>
                <div class="col-md-2 col-md-offset-8">
                    {{ Form::submit(Lang::get('controlpanel.profile.okbutton')) }}
                </div>
            </div>
            <div class="row">

            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>


{{ HTML::script('scripts/controlpanel.js') }}
@stop