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

	public function showContact()
	{		
		return View::make('contact');
	}

	public function sendContact()
	{
		$validator = Validator::make(Input::all(),
			array(
				'email'    => 'required|max:50|email',
				'name'     => 'required|max:20|min:3',
				'content'  => 'required'
			)
		);

		if($validator->fails()) 
		{
			return Redirect::route('contact')
					-> withErrors($validator)
					-> withInput();
		}

		$email       = Input::get('email');
		$name        = Input::get('name');
		$content     = Input::get('content');
		$email_spotA = Config::get('mail.username');
		$name_spotA  = Config::get('mail.from.name');

		Mail::send('emails.contact', 
			array('email' => $email, 'name' => $name, 'content' => $content), 
			function($message) use ($email, $name, $email_spotA, $name_spotA) 
			{
					$message->to($email_spotA, $name_spotA)
						->from($email_spotA, $name_spotA)
						->subject('You have received a contact!')
						->replyTo($email, $name);
			});

		return Redirect::route('home')
			-> with('global', Lang::get('home.contact.sent'));
	}
}