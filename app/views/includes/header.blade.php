<div class="container grid-menu">
	<div class="row">
		
			<div class="col-md-2 col-sm-2 spotlogo">
				<a href="/"><img src="{{asset('assets/images/logo_manyskill.png')}}" height="42"></img></a>
			</div>
			
			<div class="col-md-2 col-sm-2 eye">
				<a href="/eyewitness">Eye Witness</a>
			</div>
			
			<div class="col-md-1 col-sm-1 filt">
				<a href="/taqueto">Filter</a>
			</div>
			
			<div class="col-md-1 col-sm-1 act">
				<a href="/poetemanso">Contacts</a>
			</div>
            
            <!--<div class="col-md-1 col-sm-1 log">
            	<a href="/tirapata">Log in</a>
            </div>-->

            @if(Auth::check())
            <li><a href="{{ URL::route('account-sign-out') }}">Sign out</a></li>

			<li><a href="{{ URL::route('account-change-password') }}">Change password</a></li>

			@else
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Log in <b class="caret"></b></a>
                <div class="dropdown-menu">
                    @include('account.signin')
                </div>
            </li>
			@endif
            
            <div class="col-md-2 col-sm-1 srch">
            <form id="search" name="search" action="/search" method="get">
            	<input id="search-input" placeholder="SEARCH" name="Search" type="text">
            	<input id="search-glass" type="image" src="{{asset('assets/images/glass.png')}}">
            </form>
            </div>
	            <div class="col-md-1 col-sm-1 en">
	            	<a href="/en">EN</a>
	            </div>

	            <div class="col-md-1 col-sm-1 pt">
	            	<a href="/pt">PT</a>
	            </div>
   
	</div>
</div>
