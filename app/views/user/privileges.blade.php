@extends('layouts.default')

@section('content')


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
                {{ Form::open(array('route' => 'privileges-delete')) }}
                <input name="del_username" id="delete_user" type="hidden">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('controlpanel.privileges.cancel') }}</button>
                <button type="submit" class="btn btn-danger">{{ Lang::get('controlpanel.privileges.confirm') }}</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

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

            <div class="table-wrapper">
                <table id="privileges-list" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>{{ Lang::get('controlpanel.privileges.department') }}<span></span></th>
                            <th>{{ Lang::get('controlpanel.privileges.name') }}<span></span></th>
                            <th>{{ Lang::get('controlpanel.privileges.type') }}<span></span></th>
                            <th>{{ Lang::get('controlpanel.privileges.location') }}<span></span></th>
                            <th>{{ Lang::get('controlpanel.privileges.member_since') }}<span></span></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($users_privileges as $user_privileges)
                    <tr>
                        {{ Form::open(array('route' => array('update-privileges', $user_privileges['username']))) }}
                        <td id="department">
                            <p style="display:none;">{{$user_privileges['organization']}}</p>
                            {{ Form::text('department', $user_privileges['organization'], array( 'disabled'=>'disabled', 'placeholder'=>'NO ' . Lang::get('controlpanel.privileges.department'))) }}
                            <span class="glyphicon glyphicon-edit edit_department"></span><br>
                        </td>
                        <td>{{$user_privileges['firstname']}} {{$user_privileges['lastname']}}</td>
                        <td id="user_type" style="padding: 0 15px">
                            <p style="display:none;">{{$user_privileges['type']}}</p>
                            @if($user->type == 'admin')
                            {{ Form::select('permissions', array('normal' => 'Normal', 'publisher' => 'Publisher', 'manager' => 'Manager'), $user_privileges['type'], array('class'=>'styled')) }}
                            @else
                            {{ Form::select('permissions', array('normal' => 'Normal', 'publisher' => 'Publisher'), $user_privileges['type'], array('class'=>'styled')) }}
                            @endif
                        <td>{{$user_privileges['city']}}</td>
                        <td>{{$user_privileges['created_at']->format('Y/m/d')}}</td>
                        <td>
                            <button type="submit" class="glyphicon glyphicon-ok aprove"></button>
                            <button type="button" class="glyphicon glyphicon-remove close-button" data-id="{{$user_privileges['username']}}" data-toggle="modal" data-target=".delete-account"></button>
                        </td>
                        {{ Form::close() }}
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
{{ HTML::script('assets/js/controlpanel.js') }}

<script>
    $('#department .edit_department').click(
        function() {
            //$('this #department input').prop('disabled', false);
            $(this).prev().prop('disabled', false);
            $(this).hide().unbind();
        }
    );

    $('#user_type .edit_type').click(
        function() {
            $(this).prev().prop('disabled', false);
            $(this).hide().unbind();
        }
    );

    $(document).on("click", ".close-button", function () {
        var del_username = $(this).data('id');
        $(".delete-account #delete_user").val(del_username);
    });

    $(document).on("click", ".button-delete", function () {
        var del_username = $(this).data('id');
        $(".delete-account #delete_user").val(del_username);
    });

    $('document').ready(function()
    {
        $('#privileges-list').dataTable( {
            "paging":   false,
            "order": [[ 4, "desc" ]],
            "info":     false,
            "searching": false,
            "bAutoWidth": false,
            "aoColumns" : [
                { sWidth: '23%' },
                { sWidth: '20%' },
                { sWidth: '17%' },
                { sWidth: '15%' },
                { sWidth: '15%' },
                { sWidth: '10%' }
            ]
        });
    });
</script>

@stop