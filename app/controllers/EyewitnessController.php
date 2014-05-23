<?php

class EyewitnessController extends BaseController 
{
	public function showEyewitnessCreation()
	{
		if(!Auth::check())
			return Redirect::route('account-create')
							->with('global', 'You must be registered in Spot Alert to send an Eyewitness!');
		else
		{
			$countries = Country::lists('name', 'id');
			return View::make('create-eyewitness')->with('countries', $countries);
		}
	}

	public function createEyewitness()
	{
		
	}
}