@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div id="create-alert" class="col-md-8 col-sm-8 col-md-offset-2 general_panel">
        {{ Form::open(['url'=>'/publication/createguideline']) }}
        <div id="alert-tabs">
            <div id="languages_tabs">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a id="alert_english_tab" href="#alert_english" data-toggle="tab">English</a>
                    </li>
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
                    <h1>{{Lang::get('create-alert.create_guideline')}}</h1>
                    <div class="col-md-5 col-sm-5 col-md-offset-0" id="moveright">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h5>{{Lang::get('create-alert.fields.title')}} <span>{{Lang::get('create-alert.fields.max_size')}}</span></h5>
                                {{ Form::textarea('guideline-title', '', array('id'=>'title', 'placeholder'=>Lang::get('create-alert.placeholders.title'))) }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h5>{{Lang::get('create-alert.fields.description')}}</h5>
                                {{ Form::textarea('guideline-description', '', array('placeholder'=>Lang::get('create-alert.placeholders.description'))) }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h5>{{Lang::get('create-alert.fields.images')}}</h5>
                                {{ Form::file('guideline-images[]',array('multiple')) }}
                                @if($errors->has('file'))
                                <br><span>{{ $errors->first('file') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-sm-6 col-sm-offset-1 col-md-offset-1">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h5>{{Lang::get('create-alert.fields.affected_countries')}}</h5>
                                {{ Form::select('guideline-countries[]', $country_options, null,  array('class' => 'chosen-select', 'multiple', 'data-placeholder' => Lang::get('create-alert.placeholders.countries')))}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h5>{{Lang::get('create-alert.fields.duration')}}</h5>
                                <div class="inrow">
                                    <span>{{Lang::get('create-alert.labels.from')}}</span>
                                    {{Form::input('text', 'guideline-durationfrom', null, array('class'=>'datepicker'))}} 
                                    <span>{{Lang::get('create-alert.labels.from')}}</span>
                                    {{Form::input('text', 'guideline-durationto', null, array('class'=>'datepicker'))}}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 inrow">
                                <h5 style="float: left">{{Lang::get('create-alert.fields.eventrisk')}}</h5>
                                <span>{{ Form::selectRange('guideline-risk', 1, 5);}}</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h5>{{Lang::get('create-alert.fields.eventtype')}}</h5>
                                {{ Form::select('guideline-types[]', $event_type_options, null,  array('class' => 'chosen-select', 'multiple', 'data-placeholder' => Lang::get('create-alert.placeholders.types')))}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h5>{{Lang::get('create-alert.fields.visibility')}}</h5>
                                <div class="inrow">
                                    <span>{{Lang::get('create-alert.labels.public')}}</span>
                                    {{ Form::radio('guideline-visibility', 1, false)}}
                                    <span>{{Lang::get('create-alert.labels.hidden')}}</span>
                                    {{Form::radio('guideline-visibility', 0, true);}}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h5>{{Lang::get('create-alert.fields.alerts')}}</h5>
                                {{ Form::select('guideline-alerts[]', $alert_options, null,  array('class' => 'chosen-select', 'multiple', 'data-placeholder' => Lang::get('create-alert.placeholders.alerts')))}}
                            </div>
                        </div>
                        <input type="hidden" name="alert-languages" display="none">
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
            </div>
        </div>
    </div>
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