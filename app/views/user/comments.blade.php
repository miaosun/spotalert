@extends('layouts.default')

@section('content')
{{ isset($errors) ? $errors : "sem_erros <br>" }}

<div class="container-fluid">
    <div id="controlpanel" class="col-md-10 col-md-offset-1">
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
                <table id="comments-list" class="display" cellspacing="0" width="100%">
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
                    @foreach ($comments as $comment)
                    @if($comment->approved == false)
                    <tr>
                        <td>{{{$comment->publication->contents->first()->title}}}</td>
                        <td>{{{$comment->content}}}</td>
                        <td>{{{$comment->author->username}}}</td>
                        <td>{{{$comment->created_at}}}</td>
                        <td>{{{$comment->publication->risk}}}</td>
                        <td><a href="{{ URL::route('comment-approved', $comment->id) }}">Y</a> <a href="{{ URL::route('comment-deleted', $comment->id) }}">X</a></td>
                    </tr>
                    @endif
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

{{ HTML::script('assets/js/jquery.dataTables.js') }}

<script>
    $('document').ready(function()
    {
        $('#comments-list').dataTable( {
            "paging":   false,
            "order": [[4, "desc" ]],
            "info":     false,
            "searching": false,
            "bAutoWidth": false,
            "aoColumns" : [
                { sWidth: '20%' },
                { sWidth: '30%' },
                { sWidth: '15%' },
                { sWidth: '15%' },
                { sWidth: '10%' },
                { sWidth: '10%' }
            ]
        });
    });
</script>

@stop