@extends('layouts.default')

@section('content')

@if($selected)
<div class="modal fade delete-account" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="mySmallModalLabel">Are you sure?</h4>
            </div>
            <div class="modal-body">
                <p>{{ Lang::get('controlpanel.privileges.warning') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('controlpanel.privileges.cancel') }}</button>
                <a href="{{ URL::route('privileges-delete', $selectedUser->username)}}" class="btn btn-danger btn-primary">{{ Lang::get('controlpanel.privileges.confirm') }}</a>
            </div>
        </div>
    </div>
</div>
@endif
<div class="container-fluid">
    <div id="controlpanel" class="col-md-10 col-md-offset-1">
        <div class="row" id="privileges">
            <ul>
                <li><a href="{{ URL::route('control-panel') }}">{{ Lang::get('controlpanel.menu.profile') }}</a></li>
                <li><a href="{{ URL::route('user-notifications') }}">{{ Lang::get('controlpanel.menu.notification') }}</a></li>
                <li><a href="{{ URL::route('user-eyewitnesses') }}">{{ Lang::get('controlpanel.menu.eyewitnesses') }}</a></li>
                <li><a href="{{ URL::route('user-publications') }}">{{ Lang::get('controlpanel.menu.publications') }}</a></li>
                @if($user->type == 'admin' || $user->type == 'manager')
                    <li id="before"><a href="{{ URL::route('user-comments') }}">{{ Lang::get('controlpanel.menu.comments') }}</a></li>
                    <li id="active"> {{ Lang::get('controlpanel.menu.privileges') }}</li>
                @else
                    <li><a href="{{ URL::route('user-comments') }}">{{ Lang::get('controlpanel.menu.comments') }}</a></li>
                @endif

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
                    @if($selected)
                    {{ Form::open(array('route' => array('update-privileges', $selectedUser->username))) }}
                    @else
                    {{ Form::open(array('route' => array('update-privileges', $user->username))) }}
                    @endif
                    <div class="col-md-4" id='department'>
                        @if($selected)
                        {{ Form::text('department', $selectedUser->organization, array( 'disabled'=>'disabled', 'placeholder'=>Lang::get('controlpanel.privileges.department'))) }}
                        <span class="glyphicon glyphicon-edit edit_button"></span><br>
                            @if($user->type == 'admin')
                            {{ Form::select('permissions', array('normal' => 'Normal', 'publisher' => 'Publisher', 'manager' => 'Manager'), $selectedUser->type, array('class'=>'styled')) }}
                            @elseif($user->type == 'manager')
                            {{ Form::select('permissions', array( 'normal' => 'Normal', 'publisher' => 'Publisher'), $selectedUser->type, array('class'=>'styled')) }}
                            @endif
                        @else
                        {{ Form::text('department', null, array( 'disabled'=>'disabled', 'placeholder'=>Lang::get('controlpanel.privileges.department'))) }}
                        <span class="glyphicon glyphicon-edit"></span><br>
                        {{ Form::text('permissions', null, array('disabled'=>'disabled','placeholder'=>Lang::get('controlpanel.privileges.permissions'))) }}
                        <span class="caret"></span>
                        @endif
                    </div>
                </div>
                <div class="col-md-2 col-md-offset-7">
                    {{ Form::submit(Lang::get('controlpanel.privileges.add')) }}
                </div>
                @if($selected && $user->type == 'admin')
                <div class="col-md-2 col-md-offset-0" id="delete">
                    <button type="button" class="btn btn-warning btn-danger" data-toggle="modal" data-target=".delete-account">
                        {{ Lang::get('controlpanel.privileges.deleteuser') }}
                    </button>
                </div>
                @endif
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

        if("{{$selected}}" == 0)
        {
            $.getJSON( "api/usernames", function( data ) {
                $( "#username" ).autocomplete({
                    source: data
                });
            });

            $.getJSON( "api/emails", function( data ) {
                $( "#email" ).autocomplete({
                    source: data
                });
            });
        }

    });
</script>

@stop