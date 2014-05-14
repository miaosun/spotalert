<div class="signin_dropdown">
	<form action="{{ URL::route('account-sign-in-post') }}" method="post">

		<div class="form-group">
			<label for="inputUsernameEmail">{{Lang::get('home.signin.email')}}</label><br>
			<input type="email" class="form-control" id="inputUsernameEmail" name="email_signin" {{ (Input::old('email_signin')) ? ' value="' . Input::old('email_signin') . '"' : '' }}>
            @if($errors->has('email_signin'))
            <p>{{ $errors->first('email_signin') }}</p>
            <script>
                $(document).ready(function(){
                    $('.dropdown-toggle').dropdown('toggle');
                });
            </script>
            @endif
		</div>

		<div class="form-group">
			<a class="pull-right" href="{{ URL::route('account-forgot-password') }}"><span style="font-size:10px">Forgot password?</span></a>
			<label for="inputPassword">{{Lang::get('home.signin.password')}}</label><br>
			<input type="password" class="form-control" id="inputPassword" name="password_signin">
            @if($errors->has('password_signin'))
            <p>{{ $errors->first('password_signin') }}</p>
            @endif
            @if($errors->has('password_signin') && !$errors->has('email_signin'))
            <script>
                $(document).ready(function(){
                    $('.dropdown-toggle').dropdown('toggle');
                });
            </script>
            @endif
		</div>

		<div class="checkbox pull-left">
			<input type="checkbox" name="remember" id="remember">
			<label for="remember">
                {{Lang::get('home.signin.remember_me')}}
			</label>
		</div>

		<button type="submit" class="btn btn btn-primary pull-right">{{Lang::get('home.signin.signin')}}</button><br>
        {{ Form::token() }}
        <br>
        <hr width="90%">

        <div class="login_fb_gl">
            <a href="#" class="btn btn-lg btn-primary btn-block">{{Lang::get('home.signin.login_facebook')}}</a><br>
            <a href="#" class="btn btn-lg btn-danger btn-block">{{Lang::get('home.signin.login_google')}}</a>
        </div>

        <hr width="90%">

        <div class="register-block">
            <div class="row">
                <div class="col-md-12 row-block" style="text-align: center;">
                    {{Lang::get('home.signin.account_question')}}
                    <a href="{{ URL:: route('account-create') }}" class="btn btn-block"><h4>{{Lang::get('home.signin.register')}}</h4></a>
                </div>
            </div>
        </div>

    </form>
</div>