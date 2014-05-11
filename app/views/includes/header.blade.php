<div class="container-fluid grid-menu">
    <div class="row">

        <div class="col-md-3 col-sm-3">
            <a href="{{ URL::route('home') }}"><img src="{{asset('assets/images/logo_manyskill.png')}}" height="42"></a>
        </div>

        <div class="col-md-2 col-sm-2">
            <a href="/eyewitness">{{Lang::get('home.menu.eyewitness')}}</a>
        </div>

        <div class="col-md-1 col-sm-1 dropdown" id="filt">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{Lang::get('home.menu.filter')}} <span class="caret"></b></a>
            <div class="dropdown-menu">
                @include('publications.filter')
            </div>
        </div>

        <div class="col-md-1 col-sm-1">
            <a href="/contacts">{{Lang::get('home.menu.contact')}}</a>
        </div>

        @if(Auth::check())
        <div class="col-md-1 col-sm-1 signout">
            <!--<a href="{{ URL::route('profile-user') }}">{{ Auth::user()->username }}</a>-->
            <a href="#">{{ Auth::user()->username }}</a>
            <a href="{{ URL::route('account-sign-out') }}">{{Lang::get('home.menu.signout')}}</a>
        </div>
        <!--<li><a href="{{ URL::route('account-change-password') }}">Change password</a></li>-->

        @else
        <div class="col-md-1 col-sm-1 dropdown" id="login">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{Lang::get('home.menu.login')}} <span class="caret"></span></a>
            <div class="dropdown-menu">
                @include('account.signin')
            </div>
        </div>
        @endif

        <div class="col-md-3 col-sm-3">
            <form id="search" name="search" action="/search" method="get">
                <input id="search-input" placeholder="{{Lang::get('home.menu.search')}}" name="Search" type="text">
                <input id="search-glass" type="image" src="{{asset('assets/images/glass.png')}}">
            </form>
        </div>

        <div class="col-md-1 col-sm-1" id="language">
            <a id="en" href="/en">EN</a>
            <a id="pt" href="/pt">PT</a>
        </div>
    </div>
</div>


