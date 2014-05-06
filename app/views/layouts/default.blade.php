<!doctype html>
<html>
    
    <head>@include('includes.head')</head>
    
    <body>
        <div class="container">
        	@if(Session::has('global'))
            <!--<p>{{ Session::get('global') }}</p>-->
            <?php $message = Session::get('global');
            echo "<script type='text/javascript'>alert('$message');</script>"; ?>
			@endif
            <header class="row">@include('includes.header')</header>
            <div id="main" class="row">@yield('content')</div>
            <footer class="row">@include('includes.footer')</footer>
        </div>
    </body>

</html>