<div class="container-fluid grid-menu">
    <div class="row row-header">

        <div class="col-md-3 col-sm-3">
            <a href="{{ URL::route('home') }}"><img src="{{asset('assets/images/logo_manyskill.png')}}" height="42"></a>
        </div>

        <div class="col-md-2 col-sm-2">
            <a href="/eyewitness">{{Lang::get('home.menu.eyewitness')}}</a>
        </div>

        <div class="col-md-1 col-sm-1 dropdown" id="filt">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{Lang::get('home.menu.filter')}} <span class="caret"></span></a>
            <div class="dropdown-menu">
                @include('publications.filter')</div>
        </div>

        <div class="col-md-1 col-sm-1">
            <a href="/contact">{{Lang::get('home.menu.contact')}}</a>
        </div>

        @if(Auth::check())
        <div class="col-md-1 col-sm-1 signout">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><div id="username_length">{{ Auth::user()->username }}</div><b class="caret"></b></a>

            <div class="dropdown-menu">
                <li><a href="{{ URL::route('control-panel')}}">{{Lang::get('home.menu.profile')}}</a></li>
                @if(Auth::user()->type != 'normal')
                <li><a href="{{ URL::route('publication-create-alert')}}">{{"Create Alert"}}</a></li>
                <li><a href="{{ URL::route('publication-create-guideline')}}">{{"Create Guideline"}}</a></li>
                @endif
                @if(Auth::user()->type == 'admin' || Auth::user()->type == 'manager')
                <li><a href="https://www.google.com/analytics/web/" target="_blank">{{Lang::get('home.menu.statistics')}}</a></li>
                @endif
                <li><a href="{{ URL::route('account-sign-out') }}">{{Lang::get('home.menu.signout')}}</a></li>
            </div>
        </div>
        <!--<li><a href="{{ URL::route('account-change-password') }}">Change password</a></li>-->

        @else
        <div class="col-md-1 col-sm-1 dropdown" id="login">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{Lang::get('home.menu.login')}} <span
                    class="caret"></span></a>

            <div class="dropdown-menu">
                @include('account.signin')
            </div>
        </div>
        @endif

        <div class="col-md-3 col-sm-3">
            <form id="search" name="search" action="/search" method="get">
                <input id="search-input" placeholder="{{Lang::get('home.menu.search')}}" name="Search" type="text">
                <button id="search-glass" class="glyphicon glyphicon-search" />
            </form>
        </div>

        <div class="col-md-1 col-sm-1" id="language">
            <a id="en" href="/en">EN</a>
            <a id="pt" href="/pt">PT</a>
        </div>
    </div>
</div>
