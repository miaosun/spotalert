<?php

class HomeController extends BaseController 
{
	public function showWelcome()
	{
		//$request = Request::create('/publications', 'GET', array());
		//$publications = Route::dispatch($request)->getContent();
	
		$publications = PublicationController::getAllPublications();
		
		return View::make('home')->with('publications', $publications);
	}
}