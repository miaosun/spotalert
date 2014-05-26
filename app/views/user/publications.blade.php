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
                            <th>PUBLICATION <span></span></th>
                            <th>AUTHOR <span></span></th>
                            <th>AFFECTED COUNTRIES <span></span></th>
                            <th>INITIAL DATE <span></span></th>
                            <th>FINAL DATE <span></span></th>
                            <th>RISK <span></span></th>
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
                            <td>{{{$publication['title']}}}</td>
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

