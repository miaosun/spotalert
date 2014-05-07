<!doctype html>
<html>
    
    <head>@include('includes.head')</head>
    
    <body>
        <div class="">
        	@if(Session::has('global'))
            <!--<p>{{ Session::get('global') }}</p>-->
            <?php $message = Session::get('global');
            echo "<script type='text/javascript'>alert('$message');</script>"; ?>
			@endif
            <header class="">@include('includes.header')</header>
            <div id="main" class="">@yield('content')</div>
            <footer class="">@include('includes.footer')</footer>
        </div>
    </body>

</html>