<?php

class HomeController extends BaseController 
{
	public function showWelcome()
	{
		//$request = Request::create('/publications', 'GET', array());
		//$publications = Route::dispatch($request)->getContent();
	
		//$publications = PublicationController::getPublications();
		
		//return View::make('pages.home')->with('publications', $publications);
        return View::make('home');
	}
}