<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		/*Publication::create(array(
			'initial_date'         => date('Y-m-d H:i:s'),
			'final_date'         => date('Y-m-d H:i:s'),
			'is_public'				 => true,
			'periodic_notification' => 1,
			'risk' => 3,
			'type' => 'alert'
		));*/
$contents = Publication::find(4)->contents();
var_dump($contents);
	
	foreach ($contents as $content)
		echo $content->title . ' ' . $content->content;

		//return View::make('pages.home');
	}

}