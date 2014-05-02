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
            <div class="tab-pane fade in active" id="guideline_english">
                {{ Form::open(['route'=>'publication-createguideline']) }}
                    <h2 id="alert-header">Create guideline</h2>
                    <div id="alert-left-half">
                        <div class="form-group">
                            {{ Form::label('guideline-title-label', 'Title');
                            echo Form::text('guideline-title');}}
                        </div>
                        
                        <div class="form-group">
                            {{ Form::label('guideline-description-label', 'Description');
                            echo Form::text('guideline-description');}}
                        </div>
                        
                        <div class="form-group">
                            {/*Form::file($name, $attributes = array());*/}
                        </div>
                    </div>
                    <div id="alert-right-half">
                        <div class="form-group row">
                            {{ Form::label('guideline-risk-label', 'Event Risk');
                            echo Form::selectRange('guideline-risk', 1, 5);}}
                        </div>
                        
                        <div class="form-group">
                            {{ Form::label('guideline-type-label', 'Event Type');
                            echo Form::select('guideline-type', array('T' => 'Tsunami', 'P' => 'Pandemic'));}}
                        </div>
                        
                        <div class="form-group">
                            {{ Form::label('guideline-visibility-label', 'Visibility');
                            echo Form::label('guideline-radiopublic-label', 'Public');
                            echo Form::radio('visibility[]', 'Public', true, array('id'=>'public'));
                            echo Form::label('guideline-radiohidden-label', 'Hidden');
                            echo Form::radio('visibility[]', 'Hidden', '', array('id'=>'hidden'));}}
                        </div>
                        
                        <div class="form-group">
                            {{ Form::label('guideline-alerts-label', 'Associate Alerts');
                            echo Form::text('guideline-alerts');}}
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
                    {{  Form::submit('Submit', array('class' => 'guideline-submit'));
                        Form::close()}}
            </div>
            <div class="tab-pane" id="addlanguage">

            </div>
        </div>
    </div>
</div>

@stop