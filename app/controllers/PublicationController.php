<?php

class PublicationController extends BaseController
{
	/** Number of publications to initially show in the homepage */
	private static $initial_publications = 9;
	/** Number of publications to get in each scroll */
	private static $scroll_step = 3;

	/**
	 * It gets all the publications in the database
	 */
	public static function getAllPublications()
	{
		$stmt = Publication::with(array(
			'contents',
			'contents.language',
			'affectedCountries',
			'eventTypes')
			);

		if(!Auth::check() || Auth::user()->type == 'normal')
			$stmt->where('is_public', '=', true);

		$publications = $stmt->orderBy('risk', 'desc')->get();

		return self::makeSimpleAnswer($publications);
	}

	/**
	 * It gets some publications in the database 
	 * (just the initial ones, so it's possible to scroll)
	 */
	public static function getInitialPublications()
	{
		$stmt = Publication::with(array(
			'contents',
			'contents.language',
			'affectedCountries',
			'eventTypes')
			);

		if(!Auth::check() || Auth::user()->type == 'normal')
			$stmt->where('is_public', '=', true);

		$publications = $stmt->orderBy('risk', 'desc')->get();

		$publications_ini = self::makeSimpleAnswer($publications);
		$publications = array_slice($publications_ini, 0, self::$initial_publications);

		if(count($publications_ini) > count($publications)) //More publications to see
      		return View::make('home')->with('publications', $publications)
      								->with('next_page', 2)
      								->with('type', 'normal');
      	else
      		return View::make('home')->with('publications', $publications);
	}

	public function getNextPage($next_page)
	{
		$stmt = Publication::with(array(
			'contents',
			'contents.language',
			'affectedCountries',
			'eventTypes')
			);

		if(!Auth::check() || Auth::user()->type == 'normal')
			$stmt->where('is_public', '=', true);

		$publications = $stmt->orderBy('risk', 'desc')->get();

		$publications_ini = self::makeSimpleAnswer($publications);
		$offset           = self::$initial_publications + ($next_page-1)*self::$scroll_step;
		$publications     = array_slice($publications_ini, $offset, self::$scroll_step);

		if(count($publications_ini) >= $offset + self::$scroll_step) //More publications to see
      		return View::make('includes.publications')
      						->with('publications', $publications)
      						->with('next_page', $next_page+1)
      						->with('type', 'normal');
      	else
      		return View::make('includes.publications')->with('publications', $publications);
	}

	/**
	 * It removes a publication with a certain id from the database
	 */
	public function deletePublication($publ_id)
	{
		Publication::find($publ_id)->delete();
		return 'ok';
	}

	/**
	 * It gets all the publications in the database given a certain 
	 * search text "query"
	 */
	public function getSearchedPublications($search_text, $next_page = 1)
	{
		// Search for publications with $search_text within title
		// and with the website language
		$stmt = Publication::with(array(
			'contents',
			'contents.language',
			'affectedCountries',
			'eventTypes')
			)
			->whereHas('contents', function($query) use($search_text)
			{
				$query->where('title', 'ILIKE', "%$search_text%");
			});

		if(!Auth::check() || Auth::user()->type == 'normal')
			$stmt->where('is_public', '=', true);

		$publications = $stmt->orderBy('risk', 'desc')->get();


		$publications_ini = self::makeSimpleAnswer($publications);
		$offset           = self::$initial_publications + ($next_page-1)*self::$scroll_step;
		
		if($next_page > 1)
			$publications = array_slice($publications_ini, $offset, self::$scroll_step);
		else
			$publications = array_slice($publications_ini, 0, self::$initial_publications);

		if(($next_page > 1 && count($publications_ini) >= $offset + self::$scroll_step) || //More publications to see
			($next_page == 1 && count($publications_ini) > count($publications)))
		{
      		return View::make('includes.publications')
      						->with('publications', $publications)
      						->with('next_page', $next_page+1)
      						->with('type', 'search')
      						->with('search_text', $search_text);
      	}
      	else
      		return View::make('includes.publications')->with('publications', $publications);
	}

	/**
	 * It gets all the publications in the database given some parameters for
	 * filtering
	 */
	public function getFilteredPublications()
	{	
		$risks				= Input::get('risks');
		$event_types 		= Input::get('event_types');
		$affected_countries	= Input::get('affected_countries');
		$next_page          = Input::get('next_page');
  		
  		if(!isset($risks) || $risks === '')
  			$risks = NULL;
  		if(!isset($event_types) || $event_types === '')
  			$event_types = NULL;
  		if(!isset($affected_countries) || $affected_countries === '')
  			$affected_countries = NULL;
  		if(!isset($next_page) || $next_page === '')
  			$next_page = 1;

		// If it's all null, we should get all the publications as usual
		if($risks == NULL && $event_types == NULL && $affected_countries == NULL)
			return self::getInitialPublications();
		else
		{
			$risks2 			 = explode(',', $risks);
			$event_types2 		 = explode(',', $event_types);
			$affected_countries2 = explode(',', $affected_countries);

			$stmt = Publication::with(array(
			'contents',
			'contents.language',
			'affectedCountries',
			'eventTypes')
			)
			->where(function($query) use($risks2, $event_types2, $affected_countries2)
            {
            	//Risk information
            	foreach ($risks2 as $risk)
            		if(ctype_digit($risk)) // Just integer risks are accepted
            			$query->orWhere('risk', '=', $risk);

            	// Event types information
            	// Just do orWhereHas() if there is corrected elements
	            foreach ($event_types2 as $key => $event)
	            	if($event)
	            	{
	            		$query->orWhereHas('eventTypes', function($query) use($event_types2)
			            {
			            	$query->where(function($query) use($event_types2)
			            	{
				            	foreach ($event_types2 as $event)
				            		if($event)
				            			$query->orWhere('name', '=', $event);
				            });
			            });
			            break;
	            	}
	            	else
	            		unset($event_types2[$key]);

	            // Affected countries information
	            // Just do orWhereHas() if there is corrected elements
	            foreach ($affected_countries2 as $key => $country)
	            	if($country)
	            	{
	            		$query->orWhereHas('affectedCountries', function($query) use($affected_countries2)
			            {
			            	$query->where(function($query) use($affected_countries2)
			            	{
				            	foreach ($affected_countries2 as $country)
				            		if($country)
				            			$query->orWhere('name', '=', $country);
				            });
			            });
			            break;
	            	}
	            	else
	            		unset($affected_countries2[$key]);
            });

			if(!Auth::check() || Auth::user()->type == 'normal')
				$stmt->where('is_public', '=', true);

			$publications = $stmt->orderBy('risk', 'desc')->get();

			//$l = DB::getQueryLog();
			//return end($l);
			$publications_ini = self::makeSimpleAnswer($publications);
			$offset           = self::$initial_publications + ($next_page-1)*self::$scroll_step;
			
			if($next_page > 1)
				$publications = array_slice($publications_ini, $offset, self::$scroll_step);
			else
				$publications = array_slice($publications_ini, 0, self::$initial_publications);

			if(($next_page > 1 && count($publications_ini) >= $offset + self::$scroll_step) || //More publications to see
				($next_page == 1 && count($publications_ini) > count($publications)))
			{
	      		return View::make('includes.publications')
	      						->with('publications', $publications)
	      						->with('next_page', $next_page+1)
	      						->with('type', 'filter')
	      						->with('risks', $risks)
	      						->with('affected_countries', $affected_countries)
	      						->with('event_types', $event_types);
	      	}
	      	else
	      		return View::make('includes.publications')->with('publications', $publications);
		}
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