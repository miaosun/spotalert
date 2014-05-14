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
                {{ Form::open(['url'=>'/publication/createalert']) }}
                    <h2 id="alert-header">Create alert</h2>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('alert-title-label', 'Title');
                            echo Form::text('alert-title');}}
                        </div>
                        
                        <div class="form-group">
                            {{ Form::label('alert-description-label', 'Description');
                            echo Form::textarea('alert-description');}}
                        </div>
                        
                        <div class="form-group">
                            {/*Form::file($name, $attributes = array());*/}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('alert-countries-label', 'Countries Affected');
                            echo Form::select('alert-countries[]', $country_options, null,  array('class' => 'chosen-select', 'multiple', 'data-placeholder' => 'Pick at least one country'))}}
                        </div>
                        
                        <div class="form-group">
                            {{Form::label('alert-duration-label', 'Duration')}}
                            <div class="inrow">
                                {{ Form::label('alert-durationfrom-label', 'From');
                                echo Form::input('date', 'alert-durationfrom');
                                echo Form::label('alert-durationto-label', 'To');
                                echo Form::input('date', 'alert-durationto');}}
                            </div>
                        </div>
                        
                        <div class="form-group inrow">
                            {{ Form::label('alert-risk-label', 'Event Risk', ['id'=>'alert-risk-label']);
                            echo Form::selectRange('alert-risk', 1, 5);}}
                        </div>
                        
                        <div class="form-group">
                            {{ Form::label('alert-types-label', 'Event Type');
                            echo Form::select('alert-types[]', $event_type_options, null,  array('class' => 'chosen-select', 'multiple', 'data-placeholder' => 'Pick at least one type of event'))}}
                        </div>
                        
                        <div class="form-group">
                            {{ Form::label('alert-visibility-label', 'Visibility');}}
                            <div class="inrow">
                            {{Form::label('alert-radiopublic-label', 'Public');
                            echo Form::radio('alert-visibility', 1, false);
                            echo Form::label('alert-radiohidden-label', 'Hidden');
                            echo Form::radio('alert-visibility', 0, true);}}
                            </div>
                        </div>
                        
                        <div class="form-group">
                            {{ Form::label('alert-guidelines-label', 'Guidelines');
                            echo Form::select('alert-guidelines[]', $guideline_options, null,  array('class' => 'chosen-select', 'multiple', 'data-placeholder' => 'Pick at least one guideline'))}}
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
{{ HTML::script('assets/js/chosen.jquery.min.js'); }}
<script type="text/javascript">
    var config = {
      '.chosen-select'           : {no_results_text:'Oops, nothing found!'},
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>
</script>

@stop