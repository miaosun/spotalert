
	<form action="{{ URL::route('account-sign-in-post') }}" method="post">

		<div class="form-group">
			<label for="inputUsernameEmail">EMAIL</label>
			<input type="email" class="form-control" id="inputUsernameEmail" name="email" {{ (Input::old('email')) ? ' value="' . Input::old('email') . '"' : '' }}>
            @if($errors->has('email'))
            {{ $errors->first('email') }}
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
			<input type="password" class="form-control" id="inputPassword" name="password">
            @if($errors->has('password'))
            {{ $errors->first('password') }}
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
        <br><br>
        <hr width="60%">

        <div class="login_fb_gl">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <a href="#" class="btn btn-lg btn-primary btn-block">Login with Facebook</a>
                </div>
            </div><br>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <a href="#" class="btn btn-lg btn-danger btn-block">Login with Google</a>
                </div>
            </div>
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
