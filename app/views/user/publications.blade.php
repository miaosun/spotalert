@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div id="controlpanel" class="col-md-10 col-md-offset-1">
        <div class="row" id="publications-up">
            <ul>
                <li><a href="{{ URL::route('control-panel') }}">{{ Lang::get('controlpanel.menu.profile') }}</a></li>
                <li><a href="{{ URL::route('user-notifications') }}">{{ Lang::get('controlpanel.menu.notification') }}</a></li>
                @if($user->type != 'normal')
                <li id="before"><a href="{{ URL::route('user-eyewitnesses') }}">{{ Lang::get('controlpanel.menu.eyewitnesses') }}</a></li>
                <li id="active"> {{ Lang::get('controlpanel.menu.publications') }}</li>
                <li><a href="{{ URL::route('user-comments') }}">{{ Lang::get('controlpanel.menu.comments') }}</a></li>
                @if($user->type == 'admin' || $user->type == 'manager')
                <li><a href="{{ URL::route('user-privileges') }}">{{ Lang::get('controlpanel.menu.privileges') }}</a></li>
                @endif
                @endif
            </ul>
            <h1>{{ Lang::get('controlpanel.publications.title') }}</h1>
        
            <div class="table-wrapper">
                <table id="publ-list" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>{{ Lang::get('controlpanel.publications.publication') }} <span></span></th>
                            <th>{{ Lang::get('controlpanel.publications.author') }} <span></span></th>
                            <th>{{ Lang::get('controlpanel.publications.affected_countries') }} <span></span></th>
                            <th>{{ Lang::get('controlpanel.publications.initial_date') }} <span></span></th>
                            <th>{{ Lang::get('controlpanel.publications.final_date') }} <span></span></th>
                            <th>{{ Lang::get('controlpanel.publications.risk') }} <span></span></th>
                        </tr>
                    </thead>
             
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
             
                    <tbody>
                @foreach ($publications as $publication)
                    @if(sort($publication['affected_countries']))
                    @endif
                        <tr>
                            @if($publication['type'] == 'alert')
                            <td><a href="/publication/edit-alert/{{{$publication['id']}}}">{{{$publication['title']}}}</a></td>
                            @elseif($publication['type'] == 'guideline')
                            <td><a href="/publication/edit-guideline/{{{$publication['id']}}}">{{{$publication['title']}}}</a></td>
                            @endif
                            <td>{{{$publication['author']}}}</td>
                            <td>{{{implode(",",$publication['affected_countries'])}}}</td>
                            <td>{{{$publication['initial_date']}}}</td>
                            <td>{{{$publication['final_date']}}}</td>
                            <td>{{{$publication['risk']}}}</td>
                        </tr>
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
$('document').ready(function() 
{
    $('#publ-list').dataTable( {
        "paging":   false,
        "order": [[ 4, "desc" ]],
        "info":     false,
        "searching": false
    });
});
</script>

@stop

