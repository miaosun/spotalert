@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div id="create" class="col-md-8 col-sm-8 col-md-offset-2">
        <form action="{{ URL::route('account-create-post') }}" method="post">
            <div class="row">
                <br>
                <h1>{{Lang::get('register.register')}}</h1>
                <div class="col-md-5 col-sm-5 col-md-offset-0" id="moveright">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h5>{{Lang::get('register.terms.terms_of_service')}}</h5>
                            <textarea rows="13" cols="32" readonly>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 terms-service">
                            <p>{{Lang::get('register.terms.do_you_accept')}}</p>
                            {{ Form::radio('accept', 'yes', '', array('id'=>'yes', 'style' => 'display:none;')) }}
                            {{ Form::radio('accept', 'no', '',array('id'=>'no', 'style' => 'display:none;')) }}
                            <div class="col-md-5 col-sm-5 radiobutton"><div class="col-md-9 option">{{Lang::get('register.terms.yes')}}</div><div class="col-md-3 glyphicon yes"></div></div>
                            <div class="col-md-5 col-sm-5 col-md-offset-1 radiobutton"><div class="col-md-9 option">{{Lang::get('register.terms.no')}}</div><div class="col-md-3 glyphicon no"></div></div>
                            @if($errors->has('accept'))
                            <br><span class="col-md-12 error_msg">{{ $errors->first('accept') }}</span>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="col-md-7 col-sm-7 col-md-offset-0">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">

                            {{ Form::label(Lang::get('register.field.username') . '*',null,array('class' => 'label')) }}
                        </div>
                        <div class="col-md-7 col-md-offset-0">
                            {{ Form::text('username', Input::old('username'), array('placeholder'=>Lang::get('register.placeholder.username'))) }}
                            @if($errors->has('username'))
                            <br><span class="error_msg">{{ $errors->first('username') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            {{ Form::label(Lang::get('register.field.password').'*',null, array('class' => 'label')) }}
                        </div>
                        <div class="col-md-7 col-sm-7 col-md-offset-0">
                            {{ Form::password('password', array('placeholder'=>Lang::get('register.placeholder.password'))) }}
                            @if($errors->has('password'))
                            <br><span class="error_msg">{{ $errors->first('password') }}</span>
                            @endif
                            {{ Form::password('password_again', array('placeholder'=>Lang::get('register.placeholder.confirmpassword'))) }}
                            @if($errors->has('password_again'))
                            <br><span class="error_msg">{{ $errors->first('password_again') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::label(Lang::get('register.field.first_name'),null,array('class' => 'label')) }}
                        </div>
                        <div class="col-md-7 col-md-offset-0">
                            {{ Form::text('firstname', Input::old('firstname') , array('placeholder'=>Lang::get('register.placeholder.first_name') )) }}
                            @if($errors->has('firstname'))
                            <br><span class="error_msg">{{ $errors->first('firstname') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::label(Lang::get('register.field.last_name'),null,array('class' => 'label')) }}
                        </div>
                        <div class="col-md-7 col-md-offset-0">
                            {{ Form::text('lastname', Input::old('lastname'), array('placeholder'=>Lang::get('register.placeholder.last_name') )) }}
                            @if($errors->has('lastname'))
                            <br><span>{{ $errors->first('lastname') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::label(Lang::get('register.field.age_range').'*', null, array('class' => 'label')) }}
                        </div>
                        <div class="col-md-7 col-md-offset-0 range-age">
                            {{ Form::select('agerange', $age_options, Input::old('agerange'), array('class'=>'styled')) }}
                            @if($errors->has('agerange'))
                            <br><span class="error_msg">{{ $errors->first('agerange') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::label(Lang::get('register.field.email_address').'*', null, array('class' => 'label')) }}
                        </div>
                        <div class="col-md-7 col-md-offset-0">
                            {{ Form::text('email', Input::old('email'), array('placeholder'=>Lang::get('register.placeholder.email_address') )) }}
                            @if($errors->has('email'))
                            <br><span class="error_msg">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::label(Lang::get('register.field.phone_number'), null, array('class' => 'label')) }}
                        </div>
                        <div class="col-md-7 col-md-offset-0">
                            {{ Form::text('phonenumber', null, array('placeholder'=>Lang::get('register.placeholder.phone_number') )) }}
                            @if($errors->has('phonenumber'))
                            <br><span class="error_msg">{{ $errors->first('phonenumber') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::label(Lang::get('register.field.address'), null, array('class' => 'label')) }}
                        </div>
                        <div class="col-md-7 col-md-offset-0">
                            {{ Form::text('address', null, array('placeholder'=>Lang::get('register.placeholder.address'))) }}
                            @if($errors->has('address'))
                            <br><span class="error_msg">{{ $errors->first('address') }}</span>
                            @endif
                            {{ Form::text('city', null, array('placeholder'=>Lang::get('register.placeholder.city') )) }}
                            @if($errors->has('city'))
                            <br><span class="error_msg">{{ $errors->first('city') }}</span>
                            @endif
                            {{ Form::text('postalCode', null, array('placeholder'=>Lang::get('register.placeholder.postalcode') )) }}
                            @if($errors->has('postalCode'))
                            <br><span class="error_msg">{{ $errors->first('postalCode') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::label(Lang::get('register.field.residence') . '*', null, array('class' => 'label')) }}
                        </div>
                        <div class="col-md-7 col-md-offset-0 resid-drop">
                            {{ Form::select('residence', $country_options , Input::old('residence'), array('class'=>'styled')) }}
                            @if($errors->has('residence'))
                            <br><span class="error_msg">{{ $errors->first('residence') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::label(Lang::get('register.field.nationality') . '*', null, array('class' => 'label')) }}
                        </div>
                        <div class="col-md-7 col-md-offset-0 country-drop">
                            {{ Form::select('nationality', $country_options , Input::old('nationality'), array('class'=>'styled')) }}
                            @if($errors->has('nationality'))
                            <br><span class="error_msg">{{ $errors->first('nationality') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4" id="mand_field">
                            <br>{{ Form::label('*'.Lang::get('register.field.mandatory'), null, array('class' => 'label')) }}
                        </div>
                        <div class="col-md-6 pull-right">
                            {{ Form::submit(Lang::get('register.register')) }}
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::token() }}
            {{ Form::close() }}
    </div>
</div>
@stop
