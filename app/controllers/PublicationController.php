<?php

class PublicationController extends BaseController
{
	public static function getPublications()
	{
		return Publication::all();
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

		$json_response = array();
		foreach ($publications as $key => $publication)
		{
		    $json_response[$key] = array();
		    $json_response[$key]['initial_date'] = $publication->initial_date;
		    $json_response[$key]['final_date']   = $publication->final_date;
		    $json_response[$key]['risk']         = $publication->risk;
		    $json_response[$key]['type']         = $publication->type;

		    foreach ($publication->contents as $content)
		    {
		    	if($content->language->code === Config::get('database.website_language_code'))
		    	{
		    		$json_response[$key]['title'] = $content->title;
		    		break;
		    	}
		    }
		    
		    $json_response[$key]['affected_countries'] = array();
		    foreach ($publication->affectedCountries as $key2 => $country) 
		    {
		    	$json_response[$key]['affected_countries'][$key2] = $country->name;
		    }

		    $json_response[$key]['event_types'] = array();
		    foreach ($publication->eventTypes as $key2 => $eventType) 
		    {
		    	$json_response[$key]['event_types'][$key2] = $eventType->name;
		    }
		}

		return Response::json($json_response);
	}

	public function getFilteredPublications($first, $opt = NULL)
	{
				/*$results = MyModel::where('name', 'LIKE', "%$term%")->get();
		->where('name', '=', 'John')
            ->orWhere(function($query)
            {
                $query->where('votes', '>', 100)
                      ->where('title', '<>', 'Admin');
            })
            ->get();*/

	}
}