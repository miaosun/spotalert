<?php

class HomeController extends BaseController
{
	public function showWelcome()
	{
        //$publications = PublicationController::getPublications();

       // return View::make('pages.home')->with('publications', $publications);
        return View::make('home');
	}

}