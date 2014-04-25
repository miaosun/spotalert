@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div id="create" class="col-md-8 col-md-offset-2">
        <div class="row">
            <br>
            <h1>RECOVER PASSWORD</h1>
                <form action="{{ URL::route('account-forgot-password-post') }}" method="post">
                    <div class="col-md-12 col-md-offset-0">
                        <br>Insert the Email of the registered account:<br><br>
                        {{ Form::label('email address', null, array('class' => 'label')) }}
                        {{ Form::text('email_recover', Input::old('email_recover'), array('placeholder'=>'INSERT EMAIL')) }}
                        @if($errors->has('email_recover'))
                        {{ $errors->first('email_recover') }}
                        @endif
                    </div>
                    <div class="col-md-6 col-md-offset0">
                        {{ Form::submit('RECOVER') }}
                    </div>
                    {{ Form::token() }}
                </form>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
@stop
