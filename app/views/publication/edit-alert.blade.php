@extends('layouts.default')

@section('content')

<?php 
    $all_contents = $contents;
    $contents = array_slice($contents,1);
    $idp = $publication['id'];
?>

<div class="content">
    {{ Form::open(['url' => '/publication/editalert']) }}
    <div id="alert-tabs">
        <div id="languages_tabs">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a id="alert_english_tab" href="#alert_english" data-toggle="tab">English</a>
                </li>
                @foreach ($contents as $content)
                    <li>
                        <a id="alert_tab_{{$content['language_id']}}" href="#alert_{{$content['language_id']}}" data-toggle='tab'>{{ $language_options[$content['language_id']]}}</a>
                        <span id='rm-language' class='glyphicon glyphicon-remove'></span>
                    </li>
                    <?php
                        $lang_index =  array_search($language_options[$content['language_id']], $language_options);
                        unset($language_options[$lang_index]);
                    ?>
                @endforeach
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
                <h2 id="alert-header">Edit alert</h2>
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('alert-title-label', 'Title');
                            echo Form::text('alert-title', $all_contents[0]['title']);}}
                    </div>

                    <div class="form-group">
                        {{ Form::label('alert-description-label', 'Description');
                        echo Form::textarea('alert-description', $all_contents[0]['content'])}}
                    </div>

                    <div class="form-group">
                        {/*Form::file($name, $attributes = array());*/}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{Form::label('alert-countries-label', 'Countries Affected');
                        echo Form::select('alert-countries[]', $country_options, $countries,  array('class' => 'chosen-select', 'multiple', 'data-placeholder' => 'Pick at least one country'))}} 
                    </div>

                    <div class="form-group">
                        {{Form::label('alert-duration-label', 'Duration')}}
                        <div class="inrow">
                            {{ Form::label('alert-durationfrom-label', 'From');
                            echo Form::input('text', 'alert-durationfrom', $publication->initial_date, array('class'=>'datepicker'));
                            echo Form::label('alert-durationto-label', 'To');
                            echo Form::input('text', 'alert-durationto', $publication->final_date, array('class'=>'datepicker'));}}
                        </div>
                    </div>

                    <div class="form-group inrow">
                        {{ Form::label('alert-risk-label', 'Event Risk', ['id'=>'alert-risk-label']);
                        echo Form::selectRange('alert-risk', 1, 5, $publication->risk);}}
                    </div>

                    <div class="form-group">
                        {{ Form::label('alert-types-label', 'Event Type');
                        echo Form::select('alert-types[]', $event_type_options, $types,  array('class' => 'chosen-select', 'multiple', 'data-placeholder' => 'Pick at least one type of event'))}}
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
                        echo Form::select('alert-guidelines[]', $guideline_options, $guidelines,  array('class' => 'chosen-select', 'multiple', 'data-placeholder' => 'Pick at least one guideline'))}}
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
            @foreach($contents as $content)
                <div class="tab-pane fade in" id="alert_{{$content['language_id']}}">
                    <div class="form-group">
                        <label for="alert-title-label">Title</label>
                        <input name="alert-title{{$content['language_id']}}" type="text" value="{{$content['title']}}">
                    </div>
                    <div class="form-group">
                        <label for="alert-description-label">Description</label>
                        <textarea name="alert-description{{$content['language_id']}}" cols="50" rows="10">{{$content['content']}}</textarea>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <input type="hidden" name="alert-languages" display="none">
    <input type="hidden" name="alert-id" display="none" value="{{$idp}}">
    {{  Form::submit('Submit', array('class' => 'alert-submit'));
    Form::close()}}
</div>
{{ HTML::style('assets/css/chosen.css'); }}
{{ HTML::script('assets/js/createalert.js') }}
{{ HTML::script('assets/js/chosen.jquery.min.js'); }}
{{ HTML::script('assets/js/bootstrap-datepicker.js'); }}
{{ HTML::style('assets/css/datepicker.css'); }}
<script type="text/javascript">
    var config = {
        '.chosen-select'           : {no_results_text:'Oops, nothing found!'},
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
    
    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true
    });

    //languages
    <?php
        $js_languages = json_encode($language_options);
        $js_contents = [];
        foreach($contents as $content){
            array_push($js_contents,$content['id']);
        }
        $js_contents = json_encode($js_contents);
        echo "var language_options = ". $js_languages . ";\n";
        echo "var contents = " . $js_contents . ";\n";
    
    ?>
    $.each(language_options, function(index, value){

        if(value == "English" || value == "undefined")
        {
            delete language_options[index];
        }     

    });
    function updatelangselect(){
        
        $('#languages-select').empty();
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