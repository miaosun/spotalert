<!doctype html>
<html>
    
    <head>@include('includes.head')</head>
    
    <body>
        <div class="">
        	@if(Session::has('global'))
				<p>{{ Session::get('global') }}</p>
			@endif
            <header class="">@include('includes.header')</header>
            <div id="main" class="">@yield('content')</div>
            <footer class="">@include('includes.footer')</footer>
        </div>
    </body>

</html>