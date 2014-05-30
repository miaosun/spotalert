@extends('layouts.default')

@section('content')

<div class="container-fluid">
    <div id="controlpanel" class="col-md-10 col-md-offset-1">
        <div class="row">
            <ul>
                <li><a href="{{ URL::route('control-panel') }}">{{ Lang::get('controlpanel.menu.profile') }}</a></li>
                <li id="before"><a href="{{ URL::route('user-notifications') }}">{{ Lang::get('controlpanel.menu.notification') }}</a></li>
                @if($user->type != 'normal')
                <li id="active">{{ Lang::get('controlpanel.menu.eyewitnesses') }}</li>
                <li><a href="{{ URL::route('user-publications') }}">{{ Lang::get('controlpanel.menu.publications') }}</a></li>
                <li><a href="{{ URL::route('user-comments') }}">{{ Lang::get('controlpanel.menu.comments') }}</a></li>
                    @if($user->type == 'admin' || $user->type == 'manager')
                    <li><a href="{{ URL::route('user-privileges') }}">{{ Lang::get('controlpanel.menu.privileges') }}</a></li>
                    @endif
                @endif
            </ul>
            <h1>{{ Lang::get('controlpanel.eyewitnesses.title') }}</h1>

            <div class="table-wrapper">
                <table id="eyewitness-list" class="display" cellspacing="0" width="100%" style="    -webkit-box-sizing: border-box;
       -moz-box-sizing: border-box;
            box-sizing: border-box;">
                    <thead>
                    <tr>
                        <th>{{ Lang::get('controlpanel.eyewitnesses.title2') }} <span></span></th>
                        <th>{{ Lang::get('controlpanel.eyewitnesses.description') }} <span></span></th>
                        <th>{{ Lang::get('controlpanel.eyewitnesses.created_at') }} <span></span></th>
                        <th>{{ Lang::get('controlpanel.eyewitnesses.author') }} <span></span></th>
                        <th>{{ Lang::get('controlpanel.eyewitnesses.language') }} <span></span></th>
                        <th>{{ Lang::get('controlpanel.eyewitnesses.affected_countries') }} <span></span></th>
                        <th></th>
                    </tr>
                    </thead>
                    
                    <tbody>
                    @foreach ($eyewitnesses as $eyewit)
                    <tr>
                        <td>{{{$eyewit->title}}}</td>
                        <td class="description">{{{$eyewit->description}}}</td>
                        <td>{{{DateTime::createFromFormat('Y-m-d H:i:s', $eyewit->created_at->__toString())->format('Y-m-d')}}}</td>
                        <td>{{{$eyewit->author->username}}}</td>
                        <td>{{{$eyewit->language->name}}}</td>
                        <td>
                            {{-- */ $var = array(); /* --}}
                            @foreach($eyewit->countries as $country)
                                {{-- */ array_push( $var, $country->name) /* --}}
                            @endforeach
                            {{-- */ sort($var) /* --}}
                            {{{implode(",",$var)}}}
                        </td>
                        <!-- FIXME: Redirect to create-alert/create-guideline -->
                        <td>
                        {{ Form::open(array('route' => 'eyewitness-alert', 'method' => 'post')) }}
                        {{ Form::submit('ALERT') }}
                        {{ Form::token() }} 
                        {{ Form::close() }}
                            
                            {{ Form::open(array('route' => 'eyewitness-guideline', 'method' => 'post')) }}
                        {{ Form::submit('GUIDELINE') }}
                        {{ Form::token() }}
                        {{ Form::close() }}

                        {{ Form::open(array('route' => array('delete-eyewitness',$eyewit->id), 'method' => 'post')) }}
                        {{ Form::submit('REJECT') }}
                        {{ Form::token() }}
                        {{ Form::close() }}
                        </td>
                    </tr>
                    {{-- @endif --}}
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
        $('#eyewitness-list').dataTable( {
            "paging":   false,
            "order": [[2, "desc" ]],
            "info":     false,
            "searching": false,
            "bAutoWidth": false,
            "aoColumns" : [
                { sWidth: '20%' },
                { sWidth: '25%' },
                { sWidth: '15%' },
                { sWidth: '10%' },
                { sWidth: '10%' },
                { sWidth: '10%' },
                { sWidth: '10%' }
            ]
        });
    });
</script>

@stop