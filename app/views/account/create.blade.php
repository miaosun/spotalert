@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div id="create" class="col-md-8 col-md-offset-2">
        <form action="{{ URL::route('account-create-post') }}" method="post">
            <div class="row">
                <br>
                <h1>REGISTER</h1>
                <div class="col-md-5 col-md-offset-0" id="moveright">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>TERMS OF SERVICE</h5>
                            <textarea rows="13" cols="32" readonly>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p>Do you accept the terms of service?</p>
                            YES {{ Form::radio('accept', 'yes') }}
                            NO {{ Form::radio('accept', 'no') }}
                            @if($errors->has('accept'))
                            <br><span>YOU MUST ACCEPT THE TERMS</span>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="col-md-7 col-md-offset-0">
                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::label('username *',null,array('class' => 'label')) }}
                        </div>
                        <div class="col-md-7 col-md-offset-0">
                            {{ Form::text('username', Input::old('username'), array('placeholder'=>'ADD USERNAME')) }}
                            @if($errors->has('username'))
                            <br><span>{{ $errors->first('username') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::label('password *',null, array('class' => 'label')) }}
                        </div>
                        <div class="col-md-7 col-md-offset-0">
                            {{ Form::password('password', array('placeholder'=>'ADD PASSWORD')) }}
                            @if($errors->has('password'))
                            <br><span>{{ $errors->first('password') }}</span>
                            @endif
                            {{ Form::password('password_again', array('placeholder'=>'RE-ENTER PASSWORD')) }}
                            @if($errors->has('password_again'))
                            <br><span>{{ $errors->first('password_again') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::label('first name',null,array('class' => 'label')) }}
                        </div>
                        <div class="col-md-7 col-md-offset-0">
                            {{ Form::text('firstname', Input::old('firstname') , array('placeholder'=>'ADD FIRST NAME'))
                            }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::label('last name',null,array('class' => 'label')) }}
                        </div>
                        <div class="col-md-7 col-md-offset-0">
                            {{ Form::text('lastname', Input::old('lastname'), array('placeholder'=>'ADD LAST NAME')) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::label('age range *', null, array('class' => 'label')) }}
                        </div>
                        <div class="col-md-7 col-md-offset-0">
                            {{ Form::select('agerange', $age_options, Input::old('agerange')) }}
                            @if($errors->has('agerange'))
                            <br><span>{{ $errors->first('agerange') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::label('email address *', null, array('class' => 'label')) }}
                        </div>
                        <div class="col-md-7 col-md-offset-0">
                            {{ Form::text('email', Input::old('email'), array('placeholder'=>'ADD EMAIL ADDRESS')) }}
                            @if($errors->has('email'))
                            <br><span>{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::label('phone number', null, array('class' => 'label')) }}
                        </div>
                        <div class="col-md-7 col-md-offset-0">
                            {{ Form::text('phonenumber', null, array('placeholder'=>'ADD PHONE NUMBER')) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::label('address', null, array('class' => 'label')) }}
                        </div>
                        <div class="col-md-7 col-md-offset-0">
                            {{ Form::text('address', null, array('placeholder'=>'ADD ADDRESS')) }}
                            {{ Form::text('city', null, array('placeholder'=>'ADD CITY')) }}
                            {{ Form::text('postalCode', null, array('placeholder'=>'ADD POSTAL CODE')) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::label('residence *', null, array('class' => 'label')) }}
                        </div>
                        <div class="col-md-7 col-md-offset-0">
                            {{ Form::select('residence', $country_options , Input::old('residence')) }}
                            @if($errors->has('residence'))
                            <br><span>{{ $errors->first('residence') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::label('nationality *', null, array('class' => 'label')) }}
                        </div>
                        <div class="col-md-7 col-md-offset-0">
                            {{ Form::select('nationality', $country_options , Input::old('nationality')) }}
                            @if($errors->has('nationality'))
                            <br><span>{{ $errors->first('nationality') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4" id="mand_field">
                            <br>{{ Form::label('* Mandatory field', null, array('class' => 'label')) }}
                        </div>
                        <div class="col-md-6 pull-right">
                            {{ Form::submit('REGISTER') }}
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::token() }}
            {{ Form::close() }}
    </div>
</div>
@stop
