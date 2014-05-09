
<div class="navbar">
	<div class="navbar-inner">
		<ul class="nav">
			<li><a href="{{ URL::route('home') }}"><img src="{{asset('assets/images/logo_manyskill.png')}}" height="42"></a></li>
			<li><a href="/eyewitness">Eye Witness</a></li>
			<li><a href="/taqueto">Filter</a></li>
			<li><a href="/poetemanso">Contacts</a></li>
			@if(Auth::check())
          
            <li><a href="{{ URL::route('account-sign-out') }}">Sign out</a></li>

			<!--<li><a href="{{ URL::route('account-change-password') }}">Change password</a></li>-->

			@else
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Log in <b class="caret"></b></a>
                <div class="dropdown-menu">
                    @include('account.signin')
                </div>
            </li>
			@endif
            <li><form id="search" name="search" action="/search" method="get"></form>
            <input id="search-input" placeholder=" 🔍 SEARCH"name="Search" type="text"></li>
            <li><a href="/en">EN</a></li><li><a href="/pt">PT</a></li>
		</ul>	
	</div>
</div>
