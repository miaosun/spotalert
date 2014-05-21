@extends('layouts.default')

@section('content')

<div class="content">
    {{ Form::open(['url'=>'/publication/createalert']) }}
    <div id="alert-tabs">
        <div id="languages_tabs">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a id="alert_english_tab" href="#alert_english" data-toggle="tab">English</a>
                </li>
                <li>
                    <a id="addlanguage_tab" href="#addlanguage" data-toggle="tab">+ Add Language</a>
                </li>
            </ul>
        <div class="modal fade add-language-modal" tabindex="-1" role="dialog" aria-labelledby="AddLanguage" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add Language</h4>
                    </div>
                    <div class="modal-body">
                        <select id="languages-select"></select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="choose_language_button">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade rm-language-modal" tabindex="-1" role="dialog" aria-labelledby="RemoveLanguage" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Remove Language</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to remove this language? All the information will be lost.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="rm_language_button">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="tab-content" >
            <div class="tab-pane fade in active" id="alert_english">
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
            </div>
        </div>
    </div>
    <input type="hidden" name="alert-languages" display="none">
    {{  Form::submit('Submit', array('class' => 'alert-submit'));
                        Form::close()}}
</div>
{{ HTML::script('assets/js/createalert.js') }}
{{ HTML::script('assets/js/chosen.jquery.min.js'); }}
<script type="text/javascript">
    var config = {
      '.chosen-select'           : {no_results_text:'Oops, nothing found!'},
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
    
    //languages
    
    <?php
        $js_languages = json_encode($language_options);
        echo "var language_options = ". $js_languages . ";\n";
    ?>
    $.each(language_options, function(index, value){

        if(value == "English")
        {
            delete language_options[index];
        }     

    });
    function updatelangselect(){
        
        var sel = document.getElementById('languages-select');
        $.each(language_options, function(i, val) {
            var opt = document.createElement('option');
            opt.innerHTML = val;
            opt.value = i;
            sel.appendChild(opt);
        });
        if ($('#languages-select').is(':empty')){
                $("#addlanguage_tab").css("display", "none");
            }
        else $("#addlanguage_tab").css("display", "");
    }
    
    updatelangselect();
        
</script>

@stop