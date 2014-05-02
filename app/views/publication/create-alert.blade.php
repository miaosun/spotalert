@extends('layouts.default')

@section('content')

<div class="content">
    <div id="alert-tabs">
        <div id="languages_tabs">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#alert_english" data-toggle="tab">English</a>
                </li>
                <li>
                    <a href="#addlanguage" data-toggle="tab">+ Add Language</a>
                </li>
            </ul>
        </div>

        <div class="tab-content" >
            <div class="tab-pane fade in active" id="alert_english">
                {{ Form::open(['route'=>'publication-createalert']) }}
                    <h2 id="alert-header">Create alert</h2>
                    <div id="alert-left-half">
                        <div class="form-group">
                            {{ Form::label('alert-title-label', 'Title');
                            echo Form::text('alert-title');}}
                        </div>
                        
                        <div class="form-group">
                            {{ Form::label('alert-description-label', 'Description');
                            echo Form::text('alert-description');}}
                        </div>
                        
                        <div class="form-group">
                            {/*Form::file($name, $attributes = array());*/}
                        </div>
                    </div>
                    <div id="alert-right-half">
                        <div class="form-group">
                            {{Form::label('alert-countries-label', 'Countries Affected');
                            echo Form::text('alert-countries');}}
                        </div>
                        
                        <div class="form-group">
                            {{Form::label('alert-duration-label', 'Duration')}}
                            <div class="inrow">
                                {{ Form::label('alert-durationfrom-label', 'From');
                                echo Form::text('alert-durationfrom');
                                echo Form::label('alert-durationto-label', 'To');
                                echo Form::text('alert-durationto');}}
                            </div>
                        </div>
                        
                        <div class="form-group inrow">
                            {{ Form::label('alert-risk-label', 'Event Risk', ['id'=>'alert-risk-label']);
                            echo Form::selectRange('alert-risk', 1, 5);}}
                        </div>
                        
                        <div class="form-group">
                            {{ Form::label('alert-type-label', 'Event Type');
                            echo Form::select('alert-type', array('T' => 'Tsunami', 'P' => 'Pandemic'));}}
                        </div>
                        
                        <div class="form-group">
                            {{ Form::label('alert-visibility-label', 'Visibility');}}
                            <div class="inrow">
                            {{Form::label('alert-radiopublic-label', 'Public');
                            echo Form::radio('visibility[]', 'Public', true, array('id'=>'public'));
                            echo Form::label('alert-radiohidden-label', 'Hidden');
                            echo Form::radio('visibility[]', 'Hidden', '', array('id'=>'hidden'));}}
                            </div>
                        </div>
                        
                        <div class="form-group">
                            {{ Form::label('alert-guidelines-label', 'Guidelines');
                            echo Form::text('alert-guidelines');}}
                        </div>
                    </div>
                    @if($errors->has())
                    @foreach($errors->all() as $error)
                    <div data-alert class="alert-box warning round">
                        {{$error}}
                        <a href="#" class="close">&times;</a>
                    </div>
                    @endforeach
                    @endif
                    {{  Form::submit('Submit', array('class' => 'alert-submit'));
                        Form::close()}}
            </div>
            <div class="tab-pane" id="addlanguage">

            </div>
        </div>
    </div>
</div>

@stop