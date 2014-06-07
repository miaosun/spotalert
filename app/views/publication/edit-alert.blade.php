@extends('layouts.default')

@section('content')

<?php 
    $all_contents = $contents;
    $contents = array_slice($contents,1);
    $idp = $publication['id'];
?>


<div class="container-fluid">
    <div id="create-alert" class="col-md-8 col-sm-8 col-md-offset-2 general_panel">
        {{ Form::open(['url'=>'/publication/editalert','files'=>'true']) }}
        <div id="alert-tabs">
            <div id="languages_tabs">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a id="alert_english_tab" href="#alert_english" data-toggle="tab">English</a>
                    </li>
                    @foreach ($contents as $content)
                    <li>
                        <a id="alert_tab_{{$content['language_id']}}" href="#alert_{{$content['language_id']}}" data-toggle='tab'>{{$language_options[$content['language_id']]}}<span id='rm-language' class='glyphicon glyphicon-remove' style='padding-left: 5px'></span></a>
                    </li>
                    <?php
                        $lang_index = array_search($language_options[$content['language_id']], $language_options);
                        unset($language_options[$lang_index]);
                    ?>
                    @endforeach
                    <li>
                        <a id="addlanguage_tab" href="#addlanguage" data-toggle="tab">+ {{Lang::get('create-alert.addtab')}}</a>
                    </li>
                </ul>
                <div class="modal fade add-language-modal" tabindex="-1" role="dialog" aria-labelledby="AddLanguage" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content"> 
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">{{Lang::get('create-alert.addtab')}}</h4>
                            </div>
                            <div class="modal-body">
                                <select id="languages-select"></select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('create-alert.modals.cancel')}}</button>
                                <button type="button" class="btn btn-primary" id="choose_language_button">{{Lang::get('create-alert.modals.confirm')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade rm-language-modal" tabindex="-1" role="dialog" aria-labelledby="RemoveLanguage" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">{{Lang::get('create-alert.modals.removelang')}}</h4>
                            </div>
                            <div class="modal-body">
                                <p>{{Lang::get('create-alert.modals.removemsg')}}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('create-alert.modals.cancel')}}</button>
                                <button type="button" class="btn btn-primary" id="rm_language_button">{{Lang::get('create-alert.modals.confirm')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row tab-content" >
                <div class="tab-pane fade in active" id="alert_english">
                    <h1>{{Lang::get('create-alert.edit_alert')}}</h1>
                    <div class="col-md-5 col-sm-5 col-md-offset-0" id="moveright">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h5>{{Lang::get('create-alert.fields.title')}} <span>{{Lang::get('create-alert.fields.max_size')}}</span></h5>
                                {{ Form::textarea('alert-title', $all_contents[0]['title'], array('id'=>'title', 'placeholder'=>Lang::get('create-alert.placeholders.title'))) }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h5>{{Lang::get('create-alert.fields.description')}}</h5>
                                {{ Form::textarea('alert-description', $all_contents[0]['content'], array('placeholder'=>Lang::get('create-alert.placeholders.description'))) }}
                            </div>
                        </div>
                        
                        @if(!empty($imagesupl))
                        <div id="uploaded" class="row pub">
                            <div class="col-md-12 col-sm-12">
                                <h5>{{Lang::get('create-alert.fields.already_uploaded')}}</h5>
                                <ul id="gallery">
                                @foreach($imagesupl as $image)
                                    <li>
                                       <?php
                                            $info = new SplFileInfo($image);
                                            $imagename = $info->getFilename();
                                        ?>
                                        <a href="{{"../../assets/images/publications/".$publication->id."/".$imagename }}" target="_blank">{{HTML::image("assets/images/publications/".$publication->id."/".$imagename, null, array('class' => $publication->id))}}</a>
                                        <span class="imgremove glyphicon glyphicon-remove"></span>
                                    </li>
                                @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h5>{{Lang::get('create-alert.fields.images')}}</h5>
                                {{ Form::file('alert-images[]',array('multiple', 'class' => 'multi')) }}
                                @if($errors->has('file'))
                                <br><span class="error_msg">{{ $errors->first('file') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-sm-6 col-sm-offset-1 col-md-offset-1">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h5>{{Lang::get('create-alert.fields.affected_countries')}}</h5>
                                {{ Form::select('alert-countries[]', $country_options, $countries,  array('class' => 'chosen-select', 'multiple', 'data-placeholder' => Lang::get('create-alert.placeholders.countries')))}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h5>{{Lang::get('create-alert.fields.duration')}}</h5>
                                <div class="inrow">
                                    <span>{{Lang::get('create-alert.labels.from')}}</span>
                                    {{Form::input('text', 'alert-durationfrom', $publication->initial_date, array('class'=>'datepicker'))}} 
                                    <span>{{Lang::get('create-alert.labels.to')}}</span>
                                    {{Form::input('text', 'alert-durationto', $publication->final_date, array('class'=>'datepicker'))}}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 inrow">
                                <h5 style="float: left">{{Lang::get('create-alert.fields.eventrisk')}}</h5>
                                <span>{{ Form::selectRange('alert-risk', 1, 5, $publication->risk);}}</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h5>{{Lang::get('create-alert.fields.eventtype')}}</h5>
                                {{ Form::select('alert-types[]', $event_type_options, $types,  array('class' => 'chosen-select', 'multiple', 'data-placeholder' => Lang::get('create-alert.placeholders.types')))}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h5>{{Lang::get('create-alert.fields.visibility')}}</h5>
                                <div class="inrow visibility">
                                    {{ Form::radio('alert-visibility', 1, false, array('id'=>'public-o', 'style' => 'display:none;')) }}
                                    {{ Form::radio('alert-visibility', 0, true, array('id'=>'hidden-o', 'style' => 'display:none;')) }}
                                    <div class="col-md-5 col-sm-5 radiobutton"><div class="col-md-8 option">{{Lang::get('create-alert.labels.public')}}</div><div class="col-md-3 glyphicon public-o"></div></div>
                                    <div class="col-md-5 col-sm-5 col-md-offset-1 radiobutton"><div class="col-md-8 option">{{Lang::get('create-alert.labels.hidden')}}</div><div class="col-md-3 glyphicon hidden-o glyphicon-remove"></div></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h5>{{Lang::get('create-alert.fields.guidelines')}}</h5>
                                {{ Form::select('alert-guidelines[]', $guideline_options, $guidelines,  array('class' => 'chosen-select', 'multiple', 'data-placeholder' => Lang::get('create-alert.placeholders.guidelines')))}}
                            </div>
                        </div>
                        <input type="hidden" name="alert-languages" display="none">
                        <input type="hidden" name="alert-id" value="{{$publication->id}}">
                        <div class="row last-row">
                            <div class="col-md-4" id="mand_field">
                                <br>{{ Lang::get('create-alert.mandatory') }}
                            </div>
                            <div class="col-md-6 pull-right">
                                <button id="activate_publication" class="actbuttons">{{Lang::get('create-alert.activate')}}</button>
                                <button id="deactivate_publication" class="actbuttons">{{Lang::get('create-alert.deactivate')}}</button>
                                {{  Form::submit(Lang::get('create-alert.submit'), array('class' => 'alert-submit'));
                                Form::close()}}
                            </div>
                        </div>
                    </div>
                </div>
                @foreach($contents as $content)
                <div class="tab-pane fade in " id="alert_{{$content['language_id']}}">
                    <h1>EDIT ALERT</h1>
                    <div class="col-md-5 col-sm-5 col-md-offset-0" id="moveright"><div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h5>Title* <span>(maximum of 50 characters)</span></h5>
                            <textarea placeholder="Write your title here" name="alert-title{{$content['language_id']}}">{{$content['title']}}</textarea>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <h5>Description*</h5>
                            <textarea placeholder="Write your title here" name="alert-description{{$content['language_id']}}" cols="50" rows="10">{{$content['content']}}</textarea>
                        </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
{{ HTML::style('assets/css/chosen.css'); }}
{{ HTML::script('assets/js/createalert.js') }}
{{ HTML::script('assets/js/chosen.jquery.min.js'); }}
{{ HTML::script('assets/js/bootstrap-datepicker.js'); }}
{{ HTML::style('assets/css/datepicker.css'); }}
{{ HTML::script('assets/js/jquery.MultiFile.js') }}
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