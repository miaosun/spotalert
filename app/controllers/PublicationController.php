<?php

class PublicationController extends BaseController
{
	public static function getPublications()
	{
		return Publication::all();
	}
    
    public function showCreateAlert() {
		return View::make('publication.create-alert');

	}
    
    public function showCreateGuideline() {
		return View::make('publication.create-guideline');

	}
    
    public function createAlert() {
        
        //create the publication
        $pub = [
            'initial_date' => Input::get('alert-durationfrom'),
            'final_date' => Input::get('alert-durationto'),
            'is_public' => Input::get('visbility'),
            'periodic_notification' => "poder ser",
            'risk' => Input::get('alert-risk'),
            'type' => Input::get('alert-type'),
        ];
        
        $publication = new Publication($pub);
        
        
        //create the publication content
        /*this will need dynamic creation for multiple languages*/
        $pub_content = [
            'title' => Input::get('alert-title'),
            'content' => Input::get('alert-description'),
            'language_id' => 1,
            'publication_id' => $publication->id,
        ];
        
        $publication_content = new PublicationContent($pub_content);
        
        
        //rules for validator
        $rules = [
            'initial_date' => 'required',
            'final_date' => 'required',
            'is_public' => 'required',
            'risk' => 'required|numeric',
            'type' => 'required',
            'title' => 'required',
            'content' => 'required',
        ];
        
        //$valid_publication = Validator::make($pub, $rules_publication);
        //cycle through multiple languages
        //$valid_content = Validator::make($pub_content, $rules_content);
        if ($valid_publication->passes() || $valid_content->passes())
        { 
            if($valid_content->passes()){
                $publication->save();
                //cycle through multiple languages
                $publication_content->save();
                
                echo "passei";
                //return Redirect::to('/')->with('success', 'Alert was created!');
            }
            else
                return Redirect::back()->withErrors($valid_content)->withInput();
        }
        else
            return Redirect::back()->withErrors($valid_publication)->withInput();      
    }
    
    
    public function createGuideline() {
        
        //create the publication
        $pub = [
            'initial_date' => Input::get('alert-durationfrom'),
            'final_date' => Input::get('alert-durationto'),
            'is_public' => Input::get('visbility'),
            'periodic_notification' => "poder ser",
            'risk' => Input::get('alert-risk'),
            'type' => Input::get('alert-type'),
        ];
        
        $publication = new Publication($pub);
        
        
        //create the publication content
        /*this will need dynamic creation for multiple languages*/
        $pub_content = [
            'title' => Input::get('alert-title'),
            'content' => Input::get('alert-description'),
            'language_id' => 1,
            'publication_id' => $publication->id,
        ];
        
        $publication_content = new PublicationContent($pub_content);
        
        
        //rules for validator
        $rules = [
            'initial_date' => 'required',
            'final_date' => 'required',
            'is_public' => 'required',
            'risk' => 'required|numeric',
            'type' => 'required',
            'title' => 'required',
            'content' => 'required',
        ];
        
        //$valid_publication = Validator::make($pub, $rules_publication);
        //cycle through multiple languages
        //$valid_content = Validator::make($pub_content, $rules_content);
        if ($valid_publication->passes() || $valid_content->passes())
        { 
            if($valid_content->passes()){
                $publication->save();
                //cycle through multiple languages
                $publication_content->save();

                return Redirect::to('/')->with('success', 'Alert was created!');
            }
            else
                return Redirect::back()->withErrors($valid_content)->withInput();
        }
        else
            return Redirect::back()->withErrors($valid_publication)->withInput();      
    }

	public function getSearchedPublications($search_text)
	{
		// Search for publications with $search_text within title
		// and with the website language
		$publications = Publication::with(array(
			'contents',
			'contents.language',
			'affectedCountries',
			'eventTypes')
			)
			->whereHas('contents', function($query) use($search_text)
			{
				$query->where('title', 'ILIKE', "%$search_text%");
			})
			//FIXME: Change to know who's authenticated
			->where('is_public', '=', true)
			->orderBy('risk', 'desc')
			->get();

		return Response::json(self::makeSimpleAnswer($publications));
	}

	public static function getFilteredPublications($risks, $event_types, $affected_countries)
	{	
		// If it's all null, we should do anything
		if($risks == NULL && $event_types == NULL && $affected_countries == NULL)
			return Response::json();
		else
		{
			$risks 				= explode(',', $risks);
			$event_types 		= explode(',', $event_types);
			$affected_countries = explode(',', $affected_countries);

			$publications = Publication::with(array(
			'contents',
			'contents.language',
			'affectedCountries',
			'eventTypes')
			)
			->where(function($query) use($risks, $event_types, $affected_countries)
            {
            	//Risk information
            	foreach ($risks as $risk)
            		if(ctype_digit($risk)) // Just integer risks are accepted
            			$query->orWhere('risk', '=', $risk);

            	// Event types information
            	// Just do orWhereHas() if there is corrected elements
	            foreach ($event_types as $key => $event)
	            	if($event)
	            	{
	            		$query->orWhereHas('eventTypes', function($query) use($event_types)
			            {
			            	foreach ($event_types as $event)
			            		if($event)
			            			$query->where('name', '=', $event);
			            });
			            break;
	            	}
	            	else
	            		unset($event_types[$key]);

	            // Affected countries information
	            // Just do orWhereHas() if there is corrected elements
	            foreach ($affected_countries as $key => $country)
	            	if($country)
	            	{
	            		$query->orWhereHas('affectedCountries', function($query) use($affected_countries)
			            {
			            	foreach ($affected_countries as $country)
			            		if($country)
			            			$query->where('name', '=', $country);
			            });
			            break;
	            	}
	            	else
	            		unset($event_types[$key]);
            })
			//FIXME: Change to know who's authenticated
			->where('is_public', '=', true)
			->orderBy('risk', 'desc')
			->get();

			//return DB::getQueryLog();
			//return end($l);
			return Response::json(self::makeSimpleAnswer($publications));

		}
	}

	/**
	 *	Queries for publications that go to the homepage are modified here to
	 *  went with a good structure.
	 */
	private static function makeSimpleAnswer($publications)
	{
		$json_response = array();
		foreach ($publications as $key => $publication)
		{
		    $json_response[$key] = array();
		    $json_response[$key]['initial_date'] = $publication->initial_date;
		    $json_response[$key]['final_date']   = $publication->final_date;
		    $json_response[$key]['risk']         = $publication->risk;
		    $json_response[$key]['type']         = $publication->type;

		    // Putting the titles in the response
		    foreach ($publication->contents as $content)
		    {
		    	if($content->language->code === Config::get('database.website_language_code'))
		    	{
		    		$json_response[$key]['title'] = $content->title;
		    		break;
		    	}
		    }
		    
		    // Putting the affected countries in the response
		    $json_response[$key]['affected_countries'] = array();
		    foreach ($publication->affectedCountries as $key2 => $country) 
		    {
		    	$json_response[$key]['affected_countries'][$key2] = $country->name;
		    }

			// Putting the event types in the response
		    $json_response[$key]['event_types'] = array();
		    foreach ($publication->eventTypes as $key2 => $eventType) 
		    {
		    	$json_response[$key]['event_types'][$key2] = $eventType->name;
		    }
		}

		return $json_response;
	}
}