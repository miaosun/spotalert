<meta charset="utf-8">
<meta name="description" content="">
<meta name="author" content="Spot Alert Team">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Spot Alert</title>

<!-- load bootstrap and jquery from a cdn -->

{{ HTML::style('assets/css/normalize.css'); }}
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
{{ HTML::style('assets/css/spotalert.css'); }}

<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
{{ HTML::script('assets/js/script.js') }}
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<!-- the mousewheel plugin - optional to provide mousewheel support -->
{{ HTML::script('assets/js/jquery.mousewheel.js') }}
<!-- the jScrollPane script -->
{{ HTML::script('assets/js/jquery.jscrollpane.min.js') }}

<script>
var loading_message = "{{Lang::get('home.filter.loading_msg')}}";
var nothing_returned_message = "{{Lang::get('home.filter.nothing_ret_msg')}}";
</script>
