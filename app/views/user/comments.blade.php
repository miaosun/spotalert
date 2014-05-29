@extends('layouts.default')

@section('content')

<div class="container-fluid">
    <div id="controlpanel" class="col-md-10 col-md-offset-1">
        <div class="row" id="comments">
            <ul>
                <li><a href="{{ URL::route('control-panel') }}">{{ Lang::get('controlpanel.menu.profile') }}</a></li>
                <li><a href="{{ URL::route('user-notifications') }}">{{ Lang::get('controlpanel.menu.notification') }}</a></li>
                @if($user->type != 'normal')
                <li><a href="{{ URL::route('user-eyewitnesses') }}">{{ Lang::get('controlpanel.menu.eyewitnesses') }}</a></li>
                <li id="before"><a href="{{ URL::route('user-publications') }}">{{ Lang::get('controlpanel.menu.publications') }}</a></li>
                <li id="active"><a href="">{{ Lang::get('controlpanel.menu.comments') }}</a></li>
                    @if($user->type == 'admin' || $user->type == 'manager')
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
                        <th>{{ Lang::get('controlpanel.comments.risk') }} <span></span></th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($comments as $comment)
                    @if($comment->approved == false)
                    <tr>
                        <td>{{{$comment->publication->contents->first()->title}}}</td>
                        <td class="readcomment">
                            <div class="comment-readmore">{{{$comment->content}}}</div>
                            <a href="#" class="readmore" style="color:red;">{{ Lang::get('controlpanel.comments.readmore') }}</a>
                        </td>
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

<style>
#controlpanel li {
@if($user->type == 'publisher')
    width: 19%;
@endif
}
</style>

{{ HTML::script('assets/js/jquery.dataTables.js') }}

<script>

    $.fn.overflown=function(){var e=this[0];return e.scrollHeight>e.clientHeight||e.scrollWidth>e.clientWidth;}
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

        $('.comment-readmore').each(function()
        {
            if(!$(this).overflown())
                $(this).siblings().css('display', 'none');
        });


        $('.readcomment').on('click', '.readmore', function() {
            $(this).siblings().css('max-height', '100%');
            $(this).toggleClass('readmore readless').html('{{ Lang::get('controlpanel.comments.readless') }}');
        });

        $('.readcomment').on('click', '.readless', function() {
            $(this).siblings().css( "max-height", "90px" );
            $(this).toggleClass('readless readmore').html('{{ Lang::get('controlpanel.comments.readmore') }}');
        });

    });
</script>

@stop