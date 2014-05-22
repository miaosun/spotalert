@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div id="controlpanel" class="col-md-10 col-md-offset-1">
        <div class="row" id="privileges">
            <ul>
                <li> {{ Lang::get('controlpanel.menu.profile') }}</li>
                <li id="before"> {{ Lang::get('controlpanel.menu.notification') }}</li>
                <li id="active"> {{ Lang::get('controlpanel.menu.publications') }}</li>
                <li> {{ Lang::get('controlpanel.menu.comments') }}</li>
                <li> {{ Lang::get('controlpanel.menu.privileges') }}</li>
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

@stop

