<?php

class PublicationController extends BaseController
{
	/**
	 * It gets all the publications in the database
	 */
	public static function getAllPublications()
	{
		$publications = Publication::with(array(
			'contents',
			'contents.language',
			'affectedCountries',
			'eventTypes')
			)
			//FIXME: Change to know who's authenticated
			->where('is_public', '=', true)
			->orderBy('risk', 'desc')
			->get();
        
		return self::makeSimpleAnswer($publications);
	}
    
    public function showCreateAlert() {
        
        $country_options = Country::lists('name', 'id');
        $event_type_options = EventType::lists('name', 'id');
        $guideline_options = DB::table('publications AS p')
  ->join('publicationContents AS pc','pc.publication_id','=','p.id')
  ->where('p.type','=','guideline')
  ->lists('title','publication_id');
        
		return View::make('publication.create-alert')->with('country_options',$country_options)->with('event_type_options',$event_type_options)->with('guideline_options',$guideline_options);
        
    }
    
	/**
	 * It gets all the publications in the database given a certain 
	 * search text "query"
	 */
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
    
    public function showCreateGuideline() {
		return View::make('publication.create-guideline');
    }
	/**
	 * It gets all the publications in the database given some parameters for
	 * filtering
	 */
	public static function getFilteredPublications($risks, $event_types, $affected_countries)
	{	
		// If it's all null, we should do anything
		if($risks == NULL && $event_types == NULL && $affected_countries == NULL)
			return array();
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

			//$l = DB::getQueryLog();
			//return end($l);
			return self::makeSimpleAnswer($publications);
		}
	}
    
    public function createAlert() {
        
        //create the publication
        $pub = [
            'initial_date' => Input::get('alert-durationfrom'),
            'final_date' => Input::get('alert-durationto'),
            'is_public' => Input::get('alert-visibility'),
            'periodic_notification' => 7,
            'risk' => Input::get('alert-risk'),
            'type' => "alert"
        ];
        
        $publication = new Publication($pub);
        
        
        //create the publication content
        /*this will need dynamic creation for multiple languages*/
        $pub_content = [
            'title' => Input::get('alert-title'),
            'content' => Input::get('alert-description'),
            'language_id' => 1,
            'publication_id' => null, //
        ];
        
        $publication_content = new PublicationContent($pub_content);
        
        $alert_guidelines = Input::get('alert-guidelines');
        $alert_countries = Input::get('alert-countries');
        $alert_types = Input::get('alert-types');
        
        //rules for validator
        $rules_publication = [
            'initial_date' => 'required',
            'final_date' => 'required',
            'is_public' => 'required',
            'risk' => 'required|numeric',
            'type' => 'required'
        ];
        
        $rules_content = [
            'title' => 'required',
            'content' => 'required'
        ];
        
        $valid_publication = Validator::make($pub, $rules_publication);
        //cycle through multiple languages
        $valid_content = Validator::make($pub_content, $rules_content);
        if ($valid_publication->passes())
        { 
            if($valid_content->passes()){
                $publication->save();
                //cycle through multiple languages
                $publication_content->publication_id = $publication->id;
                $publication_content->save();
                
                //create the constraints in the database
                foreach ($alert_guidelines as $guideline_id) {
                     $publication->guidelines()->attach($guideline_id);
                }
                foreach ($alert_types as $types_id) {
                     $publication->eventTypes()->attach($types_id);
                }
                foreach ($alert_countries as $country_id) {
                     $publication->affectedCountries()->attach($country_id);
                }
                

                return Redirect::to('/')->with('success', 'Alert was created!');
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
            'periodic_notification' => 7,
            'risk' => Input::get('alert-risk'),
            'type' => "guideline"
        ];
        
        $publication = new Publication($pub);
        
        
        //create the publication content
        /*this will need dynamic creation for multiple languages*/
        $pub_content = [
            'title' => Input::get('alert-title'),
            'content' => Input::get('alert-description'),
            'language_id' => Language::where('code', '=', 'EN')->first()->id,
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
                $publication_content->
                $publication_content->save();

                return Redirect::to('/')->with('success', 'Alert was created!');
            }
            else
                return Redirect::back()->withErrors($valid_content)->withInput();
        }
        else
            return Redirect::back()->withErrors($valid_publication)->withInput();      
    }
        
	/**
	 * Queries for publications that go to the homepage are modified here to
	 * go with a good structure.
	 * Also, it correctly orders the publications in what concerns initial and
	 * final dates.
	 *
	 * NOTE: In order to this to work, publications must come already
	 *       ordered by risk (desc)
	 */
	private static function makeSimpleAnswer($publications)
	{
		//Two arrays to append at the end
		$first_array = array();
		$second_array = array();

		foreach ($publications as $key => $publication)
		{
			$json_response = array();

		    $json_response = array();
		    $json_response['id'] = $publication->id;
		    $json_response['initial_date'] = $publication->initial_date;
		    $json_response['final_date']   = $publication->final_date;
		    $json_response['risk']         = $publication->risk;
		    $json_response['type']         = $publication->type;

		    // Putting the titles in the response
		    foreach ($publication->contents as $content)
		    {
		    	if($content->language->code === Config::get('database.website_language_code'))
		    	{
		    		$json_response['title'] = $content->title;
		    		break;
		    	}
		    }
		    
		    // Putting the affected countries in the response
		    $json_response['affected_countries'] = array();
		    foreach ($publication->affectedCountries as $key2 => $country) 
		    {
		    	$json_response['affected_countries'][$key2] = $country->name;
		    }

			// Putting the event types in the response
		    $json_response['event_types'] = array();
		    foreach ($publication->eventTypes as $key2 => $eventType) 
		    {
		    	$json_response['event_types'][$key2] = $eventType->name;
		    }

		    //Decide if goes to the first or to the second array
		    $ini_date = DateTime::createFromFormat('Y-m-d', $publication->initial_date);
		    $fin_date = DateTime::createFromFormat('Y-m-d', $publication->final_date);
		    $today    = new DateTime;
		    
		    if($ini_date)
		    	if($ini_date > $today)
		    	{
		    		array_push($second_array, $json_response);
		    		continue;
		    	}
		    if($fin_date)
		    	if($fin_date < $today)
		    	{
		    		array_push($second_array, $json_response);
		    		continue;
		    	}
		    array_push($first_array, $json_response);
		}

		return array_merge($first_array, $second_array);
	}
}