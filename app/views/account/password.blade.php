@extends('layouts.default')

@section('content')
    <div class="container-fluid">
        <div id="create" class="col-md-8 col-md-offset-2">
            <div class="row">
                <br><h1>CHANGE PASSWORD</h1>
                <form action="{{ URL::route('account-change-password-post') }}" method="post">
                    <div class="col-md-12 col-md-offset-0">
                        {{ Form::label('Old password',null, array('class' => 'label')) }}
                        {{ Form::password('password') }}
                        <!--Old password: <input type="password" name="old_password">-->
                        @if($errors->has('old_password'))
                            <span class="error_msg">{{ $errors->first('old_password') }}</span>
                        @endif
                    </div>

                    <div class="col-md-12 col-md-offset-0">
                        {{ Form::label('New password',null, array('class' => 'label')) }}
                        {{ Form::password('password') }}
                        <!--New password: <input type="password" name="password">-->
                        @if($errors->has('password'))
                            <span class="error_msg">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div class="col-md-12 col-md-offset-0">
                        {{ Form::label('new password again',null, array('class' => 'label')) }}
                        {{ Form::password('password') }}
                        <!--New password again: <input type="password" name="password_again">-->
                        @if($errors->has('password_again'))
                            <span class="error_msg">{{ $errors->first('password_again') }}</span>
                        @endif
                    </div>
                    <div class="col-md-6 col-md-offset0">
                        {{ Form::submit('RECOVER') }}
                    </div>
                    {{ Form::token() }}
                </form>
            </div>
        </div>
    </div>
@stop