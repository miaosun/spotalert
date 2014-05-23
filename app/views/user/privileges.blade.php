@extends('layouts.default')

@section('content')
{{ isset($errors) ? $errors : "sem_erros <br>" }}

<div class="container-fluid">
    <div id="controlpanel" class="col-md-8 col-md-offset-2">
        <div class="row" id="privileges">
            <ul>
                <li><a href="{{ URL::route('control-panel') }}">{{ Lang::get('controlpanel.menu.profile') }}</a></li>
                <li><a href="{{ URL::route('user-notifications') }}">{{ Lang::get('controlpanel.menu.notification') }}</a></li>
                <li><a href="{{ URL::route('user-publications') }}">{{ Lang::get('controlpanel.menu.publications') }}</a></li>
                <li id="before"><a href="{{ URL::route('user-comments') }}">{{ Lang::get('controlpanel.menu.comments') }}</a></li>
                <li id="active"> {{ Lang::get('controlpanel.menu.privileges') }}</li>
            </ul>
            <h1>{{ Lang::get('controlpanel.privileges.title') }}</h1>

            <div class="row">
                <div class="col-md-12 col-md-offset-0">
                    <div class="col-md-3">
                        <h3>{{ Lang::get('controlpanel.privileges.add_publishers').'/' }}</h3>
                        <h3>{{ Lang::get('controlpanel.privileges.managers').'/' }}</h3>
                    </div>
                    {{ Form::open(array('route' => 'selectedUser-privileges')) }}
                    <div class="col-md-4">
                        @if($selected)
                        {{ Form::text('username',$selectedUser->username, array('id'=>'username', 'placeholder'=>Lang::get('controlpanel.privileges.name'))) }}
                        @else
                        {{ Form::text('username',null, array('id'=>'username', 'placeholder'=>Lang::get('controlpanel.privileges.name'))) }}
                        @endif
                        <button type="submit" class="glyphicon glyphicon-search" id="username"></button>
                        @if($selected)
                        {{ Form::text('email', $selectedUser->email, array('id'=>'email','placeholder'=>Lang::get('controlpanel.privileges.email'))) }}
                        @else
                        {{ Form::text('email', null, array('id'=>'email','placeholder'=>Lang::get('controlpanel.privileges.email'))) }}
                        @endif
                        <button type="submit" class="glyphicon glyphicon-search" id="username"></button>
                    </div>
                    {{ Form::close() }}
                    {{ Form::open(array('route' => 'update-privileges')) }}
                    <div class="col-md-4" id='department'>
                        @if($selected)
                        {{ Form::text('department', $selectedUser->organization, array( 'disabled'=>'disabled', 'placeholder'=>Lang::get('controlpanel.privileges.department'))) }}
                        <span class="glyphicon glyphicon-edit edit_button"></span>
                        {{ Form::select('permissions', array('placeholder' => Lang::get('controlpanel.privileges.permissions'), 'n' => 'Normal', 'p' => 'Publisher', 'm' => 'Manager'), 'placeholder') }}
                        @else
                        {{ Form::text('department', null, array( 'disabled'=>'disabled', 'placeholder'=>Lang::get('controlpanel.privileges.department'))) }}
                        <span class="glyphicon glyphicon-edit"></span>
                        {{ Form::text('permissions', null, array('disabled'=>'disabled','placeholder'=>Lang::get('controlpanel.privileges.permissions'))) }}
                        <span class="caret"></span>
                        @endif
                    </div>
                </div>
                <div class="col-md-2 col-md-offset-8">
                    {{ Form::submit(Lang::get('controlpanel.privileges.add')) }}
                </div>
                {{ Form::close() }}
            </div>
            <div class="table-wrapper">
                <table id="privileges-list" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>{{ Lang::get('controlpanel.privileges.department') }}<span></span></th>
                            <th>{{ Lang::get('controlpanel.privileges.name') }}<span></span></th>
                            <th>{{ Lang::get('controlpanel.privileges.location') }}<span></span></th>
                            <th>{{ Lang::get('controlpanel.privileges.member_since') }}<span></span></th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>

                    <tbody>
                    @foreach ($users_with_permissions as $user_with_permission)
                    <tr>
                        <td>{{$user_with_permission['organization']}}</td>
                        <td>{{$user_with_permission['firstname']}} {{$user_with_permission['lastname']}}</td>
                        <td>{{$user_with_permission['city']}}</td>
                        <td>{{$user_with_permission['created_at']}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>

{{ HTML::script('assets/js/jquery.dataTables.js') }}

<script>
    $('document').ready(function()
    {
        $('#privileges-list').dataTable( {
            "paging":   false,
            "order": [[ 3, "desc" ]],
            "info":     false,
            "searching": false
        });
    });
</script>

@stop