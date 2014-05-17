@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div id="controlpanel" class="col-md-8 col-md-offset-2">
        <div class="row" id="privileges">
            <ul>
                <li> {{ Lang::get('controlpanel.menu.profile') }}</li>
                <li id="before"> {{ Lang::get('controlpanel.menu.notification') }}</li>
                <li id="active"> {{ Lang::get('controlpanel.menu.publications') }}</li>
                <li> {{ Lang::get('controlpanel.menu.comments') }}</li>
                <li> {{ Lang::get('controlpanel.menu.privileges') }}</li>
            </ul>
            <h1>{{ Lang::get('controlpanel.publications.title') }}</h1>
            
            <table id="publ-list" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>PUBLICATION</th>
                        <th>PUBLISHER</th>
                        <th>AFFECTED COUNTRIES</th>
                        <th>INITIAL DATE</th>
                        <th>FINAL DATE</th>
                        <th>RISK</th>
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
            <!-- FIXME: Add author feature, language up here, title link, location, col-m-12, corrected CSS...-->
            @foreach ($publications as $publication)
                    <tr>
                        <td>{{{$publication['title']}}}</td>
                        <td>tjiagom</td>
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

@stop

