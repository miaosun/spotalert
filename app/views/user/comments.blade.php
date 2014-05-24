@extends('layouts.default')

@section('content')
{{ isset($errors) ? $errors : "sem_erros <br>" }}

<div class="container-fluid">
    <div id="controlpanel" class="col-md-8 col-md-offset-2">
        <div class="row" id="notifications">
            <ul>
                <li><a href="{{ URL::route('control-panel') }}">{{ Lang::get('controlpanel.menu.profile') }}</a></li>
                <li><a href="{{ URL::route('user-notifications') }}">{{ Lang::get('controlpanel.menu.notification') }}</a></li>
                @if($user->type != 'normal')
                <li id="before"><a href="{{ URL::route('user-publications') }}">{{ Lang::get('controlpanel.menu.publications') }}</a></li>
                <li id="active"><a href="">{{ Lang::get('controlpanel.menu.comments') }}</a></li>
                    @if($user->type == 'publisher')
                    <li></li>
                    @elseif($user->type == 'admin' || $user->type == 'manager')
                    <li><a href="{{ URL::route('user-privileges') }}">{{ Lang::get('controlpanel.menu.privileges') }}</a></li>
                    @endif
                @endif
            </ul>
            <h1>{{ Lang::get('controlpanel.comments.title') }}</h1>

            <div class="table-wrapper">
                <table id="publ-list" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>{{ Lang::get('controlpanel.comments.publication') }} <span></span></th>
                        <th>{{ Lang::get('controlpanel.comments.comment') }} <span></span></th>
                        <th>{{ Lang::get('controlpanel.comments.name') }} <span></span></th>
                        <th>{{ Lang::get('controlpanel.comments.date') }} <span></span></th>
                        <th>RISK <span></span></th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($publications as $publication)
                    <tr>
                        <td>{{{$publication->title}}}</td>
                        <td>{{{$publication->content}}}</td>
                        <td>{{{$publication->username}}}</td>
                        <td>{{{$publication->initial_date}}}</td>
                        <td>{{{$publication->risk}}}</td>
                        <td>Y X</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

{{ HTML::script('scripts/controlpanel.js') }}
{{ HTML::style('http://cdn.datatables.net/1.10.0/css/jquery.dataTables.css'); }}
@stop