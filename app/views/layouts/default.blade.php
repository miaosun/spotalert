<!doctype html>
<html>
    
    <head>@include('includes.head')</head>
    
    <body>
        <div>
        	@if(Session::has('global'))
            <!--<p>{{ Session::get('global') }}</p>-->
            <?php $message = Session::get('global');
            echo "<script type='text/javascript'>alert('$message');</script>"; ?>
			@endif
            <header>@include('includes.header')</header>
            <div id="main">@yield('content')</div>
            <footer>@include('includes.footer')</footer>
        </div>
    </body>

</html>