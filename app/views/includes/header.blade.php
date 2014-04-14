<div class="navbar">
	<div class="navbar-inner">
		<ul class="nav">
			<li><a href="{{ URL::route('home') }}">{{HTML::image('assets/images/logo_manyskill.png', null, array('height' => 32))}}</a></li>
			<li><a href="/eyewitness">Eye Witness</a></li>
			<li><a href="/taqueto">Filter</a></li>
			<li><a href="/poetemanso">Contacts</a></li>
            @if(Auth::check())
				<li><a href="{{ URL::route('account-sign-out') }}">Sign out</a></li>
				<li><a href="{{ URL::route('account-change-password') }}">Change password</a></li>
			@else
				<li><a href="{{ URL::route('account-sign-in') }}">Sign in</a></li>
				<li><a href="{{ URL:: route('account-create') }}">Sign up</a></li>
		@endif
		</ul>
	</div>
</div>