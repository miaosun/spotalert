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

	public function deleteEyewitness($eyewitId)
	{
		$eyewitness = Eyewitness::find($eyewitId);
		$eyewitness->delete();

		// Remove possible stored images
		$destinationPath = '/var/www/spotalert/app/images/eyewitnesses' . $eyewitId;
			if(File::exists($destinationPath))
			{
				if (is_dir($destinationPath)) 
				{ 
					$objects = scandir($destinationPath); 
				    foreach ($objects as $object) 
				    { 
				    	if ($object != "." && $object != "..") 
				    	{ 
				        	if (filetype($destinationPath."/".$object) == "dir") rrmdir($destinationPath."/".$object); else unlink($destinationPath."/".$object); 
				        } 
				    } 
				    reset($objects); 
				    rmdir($destinationPath); 
				} 
			}

		return Redirect::route('user-eyewitnesses')->with('global', 'Eyewitness successfully deleted!');
	}

	public function getEyewitnesses()
	{
		$profile      = User::find(Auth::user()->getId());
		$eyewitnesses = Eyewitness::with(array(
			'author',
			'countries',
			'language'))->get();

		return View::make('user.eyewitnesses')
						->with('user', $profile)
						->with('eyewitnesses', $eyewitnesses);
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
		$files    = Input::file('images');
		$hasFiles = false; //Some issues with laravel validation, it has to be this way

		for ($i=0; $i < count($files); $i++)
		{
		    $file = $files[$i];
		    if($file != NULL)
		    {
		    	$hasFiles = true;
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
		if($hasFiles)
		{
			$destinationPath = '/var/www/spotalert/app/images/eyewitnesses' . $eyewitness->id;
			if(!File::exists($destinationPath))
				File::makeDirectory($destinationPath,  $mode = 0777, $recursive = true);
			$images = Input::file('images');
			for ($i=0; $i < count($images); $i++)
			{
				$image = $images[$i];
				$extension = $image->guessExtension();
				$image->move($destinationPath, $i . '.' . $extension);
			}
		}

		return Redirect::route('home')
			-> with('global', 'Eyewitness successfully received! As soon as possible we will analyse it.');
	}
}