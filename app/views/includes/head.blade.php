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

<!-- for autocomplete -->
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/smoothness/jquery-ui.css" />
<!-- -->
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<!-- the mousewheel plugin - optional to provide mousewheel support -->
{{ HTML::script('assets/js/jquery.mousewheel.js') }}
<!-- the jScrollPane script -->
{{ HTML::script('assets/js/jquery.jscrollpane.min.js') }}
{{ HTML::script('assets/js/jquery.dataTables.js') }}
{{ HTML::script('scripts/controlpanel.js') }}
{{ HTML::script('assets/js/script.js') }}
<script>
var loading_message = "{{Lang::get('home.filter.loading_msg')}}";
var nothing_returned_message = "{{Lang::get('home.filter.nothing_ret_msg')}}";
</script>
