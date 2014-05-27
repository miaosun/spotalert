@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div id="eyewitness" class="col-md-8 col-sm-8 col-md-offset-2 general_panel">
        <form action="{{ URL::route('create-eyewitness') }}" method="post" enctype="multipart/form-data">
            <div class="row">
                <br>
                <h1>{{Lang::get('eyewitness.title')}}</h1>
                <div class="col-md-5 col-sm-5 col-md-offset-0" id="moveright">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h5>{{Lang::get('eyewitness.fields.title')}} <span>{{Lang::get('eyewitness.fields.max_size')}}</span></h5>
                            {{ Form::textarea('title', '', array('id'=>'title', 'placeholder'=>Lang::get('eyewitness.placeholders.title'))) }}
                            @if($errors->has('title'))
                            <br><span>{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h5>{{Lang::get('eyewitness.fields.description')}}</h5>
                            {{ Form::textarea('description', '', array('placeholder'=>Lang::get('eyewitness.placeholders.description'))) }}
                            @if($errors->has('description'))
                            <br><span>{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h5>{{Lang::get('eyewitness.fields.images')}}</h5>
                            {{ Form::file('images[]',array('multiple')) }}
                            @if($errors->has('file'))
                            <br><span>{{ $errors->first('file') }}</span>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-sm-6 col-sm-offset-1 col-md-offset-1">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h5>{{Lang::get('eyewitness.fields.affected_countries')}}</h5>
                            {{Form::select('affected-countries[]', $countries, null,  array('class' => 'chosen-select', 'multiple', 'data-placeholder' => Lang::get('eyewitness.placeholders.countries')))}}
                            @if($errors->has('affected-countries'))
                            <br><span>{{ $errors->first('affected-countries') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row" id="lang-drop">
                        <div class="col-md-4">
                            {{ Form::label(Lang::get('eyewitness.fields.language') . '*:', null, array('class' => 'label')) }}
                        </div>
                        <div class="col-md-7 col-md-offset-0">
                            {{ Form::select('language', $languages ) }}
                            @if($errors->has('language'))
                            <br><span>{{ $errors->first('language') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row last-row">
                        <div class="col-md-4" id="mand_field">
                            <br>{{ Form::label('*'.Lang::get('eyewitness.mandatory'), null, array('class' => 'label')) }}
                        </div>
                        <div class="col-md-6 pull-right">
                            {{ Form::submit(Lang::get('eyewitness.submit')) }}
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::token() }}
            {{ Form::close() }}
    </div>
</div>
{{ HTML::style('assets/css/chosen.css'); }}
{{ HTML::script('assets/js/chosen.jquery.min.js') }}

<script>
$('document').ready(function() 
{
    $('.chosen-select').chosen(
        { 
            no_results_text: 'Oops, nothing found!',
            width: "100%"
        });
});
</script>

@stop
