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
			$languages = Language::lists('name', 'id');

			return View::make('create-eyewitness')
							->with('countries', $countries)
							->with('languages', $languages);
		}
	}

	public function createEyewitness()
	{
		$validator = Validator::make(Input::all(),
			array(
				'title'              => 'required|max:50|min:3',
				'description'        => 'required|min:10',
				'affected-countries' => 'array',
				'language'           => 'exists:languages,id'
			)
		);

		if($validator->fails()) 
		{
			return Redirect::route('eyewitness')
					-> withErrors($validator)
					-> withInput();
		}

		// Validating countries
		if(Input::has('affected-countries'))
			foreach(Input::get('affected-countries') as $country)
			{
				$validator = Validator::make(array($country), ['country' => 'exists:countries,id']);
				if($validator->fails()) 
				{
					return Redirect::route('eyewitness')
							-> withErrors($validator)
							-> withInput();
				}

			}

		// Validating the files that must be images
		$files = Input::file('images');
		for ($i=0; $i < count($files); $i++)
		{
		    $file = $files[$i];
		    $input = array(
		        'file' => $files[$i]
		    );

		    $rules = array(
		        'file' => 'image|max:2048'
		    );
		    $validation = Validator::make($input, $rules);

		    if($validation->fails()) 
			{
				return Redirect::route('eyewitness')
						-> withErrors($validation)
						-> withInput();
			}
		}

		// Creating the eyewitness
		$eyewitness = Eyewitness::create(array(
			'title'	      => Input::get('title'),
			'description' => Input::get('description'),
			'created_at'  => date('Y-m-d'),
			'user_id'     => Auth::user()->id,
			'language_id' => Input::get('language')
		));

		// Linking eyewitness to the countries
		if(Input::has('affected-countries'))
			foreach(Input::get('affected-countries') as $country)
				$eyewitness->countries()->attach($country);
		
		//Storing images
		$destinationPath = '/var/www/spotalert/app/images/eyewitnesses' . $eyewitness->id;
		if(!File::exists($destinationPath))
			File::makeDirectory($destinationPath,  $mode = 0777, $recursive = true);
		$images = Input::file('images');
		for ($i=0; $i < count($images); $i++)
		{
			$image = $images[$i];
			$extension = $image->guessExtension();
			$image->move($destinationPath, $i . '.' . $extension );
		}

		return Redirect::route('home')
			-> with('global', 'Eyewitness successfully received! As soon as possible we will analyse it.');
		
	}
}