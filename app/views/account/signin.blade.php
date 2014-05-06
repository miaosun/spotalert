<div class="signin_dropdown">
	<form action="{{ URL::route('account-sign-in-post') }}" method="post">

		<div class="form-group">
			<label for="inputUsernameEmail">EMAIL</label>
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
			<label for="inputPassword">PASSWORD</label>
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
				Remember me
			</label>
		</div>

		<button type="submit" class="btn btn btn-primary pull-right">Sign in</button>
        {{ Form::token() }}

        <hr width="60%">

        <div class="login_fb_gl">
            <a href="#" class="btn btn-lg btn-primary btn-block">Login with Facebook</a><br>
            <a href="#" class="btn btn-lg btn-danger btn-block">Login with Google</a>
        </div>

        <hr width="60%">

        <div class="register-block">
            <div class="row">
                <div class="col-md-12 row-block" style="text-align: center;">
                    Don't have an account yet?
                    <a href="{{ URL:: route('account-create') }}" class="btn btn-block"><h4>REGISTER HERE</h4></a>
                </div>
            </div>
        </div>

    </form>
</div>