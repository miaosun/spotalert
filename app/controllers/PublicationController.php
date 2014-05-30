<?php

class PublicationController extends BaseController
{
	/** Number of publications to initially show in the homepage. MUST BE MULTIPLE OF 3! */
	private static $initial_publications = 9;
	/** Number of publications to get in each scroll. MUST BE MULTIPLE OF 3! */
	private static $scroll_step = 3;
	/** Number of days to consider that a publication is updated */
	private static $update_interval = 5;

	/**
	 * It gets all the publications in the database
	 */
	public static function getAllPublications()
	{
		$stmt = Publication::with(array(
			'contents',
			'contents.language',
			'affectedCountries',
			'eventTypes'));

		if(!Auth::check() || Auth::user()->type == 'normal')
			$stmt->where('is_public', '=', true);

		$publications = $stmt->orderBy('risk', 'desc')->get();

		return self::makeSimpleAnswer($publications);
	}
    public static function getPublication($id)
    {
       $stmt = Publication::with(array(
			'contents',
			'contents.language',
			'affectedCountries',
			'eventTypes'));

		if(!Auth::check() || Auth::user()->type == 'normal')
			$stmt->where('is_public', '=', true);
        
        ;
        $publication = $stmt->where('id', '=', $id)->get()->first();
        // In case of not find send 404  
        if(count($publication))
        {    
            $result = self::makeSimpleAnswerPlus($publication);
            return View::make('home')->with('publications', $result)->with('publicationAlone','true');
        }
        else
            App::abort(404);
    }
    /**
	 * Get certain publication expandile data from databse and return 
	 */
	public static function getPublicationExpandableContentByID($publ_id)
	{
        // load publication
        $publication = Publication::find($publ_id);
        
        $langCode = Config::get('database.website_language_code');
        // check for language on
        $language = Language::where("code","=",$langCode)->first();
        
        // load publication content in the language selected
        $content = $language->publicationContents()->where('publication_id','=',$publ_id)->first();
        
        $answer = array('id' => $publication->id,
                                'title' => $content->title,
                                'content' => $content->content,
                                'pubLinked' =>array(),
                                'comments' => array(),
                                'images' =>array()
                               );
        if(!$publication->alerts->isEmpty())
        {
            foreach($publication->alerts as $alert)
            {
                if($alert->is_public == 'TRUE')
                {
                    $answer['pubLinked'][] = array('id'=> $alert->id, 
                                                   'title' =>$language->publicationContents()->where('publication_id','=',$alert->id)->first()->title);
                }
                else 
                    if(Auth::check() && !(Auth::user()->type == 'normal'))
                    {    
                        $answer['pubLinked'][] = array('id'=> $alert->id, 
                                                       'title' =>$language->publicationContents()->where('publication_id','=',$alert->id)->first()->title);
                    }
            }
        }
        
        if(!$publication->guidelines->isEmpty())
        {
                foreach($publication->guidelines as $guidelines)
                {
                    if($guidelines->is_public == 'TRUE')
                    {
                        $answer['pubLinked'][] = array('id'=> $guidelines->id,
                                                       'title' =>$language->publicationContents()->where('publication_id','=',$guidelines->id)->first()->title);
                    }
                    else 
                        if(Auth::check() && !(Auth::user()->type == 'normal'))
                        {    
                            $answer['pubLinked'][] = array('id'=> $guidelines->id,
                                                           'title' =>$language->publicationContents()->where('publication_id','=',$guidelines->id)->first()->title);
                        }
                }
        }
         if(!$publication->comments->isEmpty())
         {
            foreach($publication->comments as $comment)
            {
               if($comment->approved)
               {    
                   $commentData = array('user' => $comment->author()->first()->username,'content' => $comment->content, 'date' =>$comment->created_at,'img'=>array(),'delete' => array());
                    // load images from publication if exists
                    $srcPath = public_path().'/assets/images/comments/'.$comment->id;
                    if(File::exists($srcPath))
                    {
                        $imagesUrl = File::allFiles($srcPath);
                        foreach($imagesUrl as $imgUrl)
                        {
                            $commentData['img'] = array('url'=>$url = asset('assets/images/comments/'.$comment->id.'/'.$imgUrl->getRelativePathName()),'alt'=>$content->title);
                        }
                    }
                   if(Auth::check() && !(Auth::user()->type == 'normal'))
                    {
                        $commentData['delete'] = array('url' => route('comment-deleted', $comment->id),'text' => Lang::get('controlpanel.comments.delete'));
                    }
                    $answer['comments'][] = $commentData;
                }
            }
            //TODO add Lang words for the comments be in selected language (e.g. "by", "on", "of" - $answer['language']) 
        }
        // load images from publication if exists
        $srcPath = public_path().'/assets/images/publications/'.$publ_id;
        if(File::exists($srcPath))
        {
            $imagesUrl = File::allFiles($srcPath);
            foreach($imagesUrl as $imgUrl)
            {
                $answer['images'][] = array('url'=>$url = asset('assets/images/publications/'.$publ_id.'/'.$imgUrl->getRelativePathName()),'alt'=>$content->title);
            }
        }
           
		return Response::json($answer);
        //return Response::json($publications);
	}
	/**
	 * Used to get the publications to appear in the user control panel
	 */
	public static function getPublicationsForUserPanel()
	{
		$stmt = Publication::with(array(
			'contents',
			'contents.language',
			'affectedCountries',
			'eventTypes',
			'author'))
			->orWhere(function($query)
			{
				$query->orWhere('user_id', '=', Auth::user()->id);
				
				if(Auth::user()->type == 'manager' || Auth::user()->type == 'admin')
					foreach(Auth::user()->supervised as $user)
						$query->orWhere('user_id', '=', $user->id);
			});

		if(!Auth::check() || Auth::user()->type == 'normal')
			$stmt->where('is_public', '=', true);

		$publications = $stmt->orderBy('risk', 'desc')->get();

		return self::makeSimpleAnswer($publications);

	}
    
    public function showCreateAlert()
    {   
        if(Auth::check() && Auth::user()->type != 'normal') {
        
        $country_options = Country::lists('name', 'id');
        $event_type_options = EventType::lists('name', 'id');
        $guideline_options = DB::table('publications AS p')->join('publicationContents AS pc','pc.publication_id','=','p.id')->where('p.type','=','guideline')->lists('title','publication_id');
        $language_options = Language::lists('name', 'id');
        
		return View::make('publication.create-alert')->with('country_options',$country_options)->with('event_type_options',$event_type_options)->with('guideline_options',$guideline_options)->with('language_options',$language_options);
        }
        else
            return Redirect::route('home')->with('global', "You're either not registered or you do not have enough privileges.");
        
    }
    
    public function showEditAlert($id)
    {
        if(Auth::check() && Auth::user()->type != 'normal') {
        
            $country_options = Country::lists('name', 'id');
            $event_type_options = EventType::lists('name', 'id');
            $guideline_options = DB::table('publications AS p')->join('publicationContents AS pc','pc.publication_id','=','p.id')->where('p.type','=','guideline')->lists('title','publication_id');
            $language_options = Language::lists('name', 'id');

            $publication = Publication::find($id);
            $types = Publication::find($id)->eventTypes->lists('id');
            $countries = Publication::find($id)->affectedCountries->lists('id');
            $guidelines = Publication::find($id)->guidelines->lists('id');
            $contents = Publication::find($id)->contents->toArray();

            $images_directory = public_path()."/assets/images/publications/".$id;
            $images = array();
            foreach(glob($images_directory.'/*.*') as $file) {
                array_push($images,$file);
            }


            return View::make('publication.edit-alert')->with('country_options',$country_options)->with('event_type_options',$event_type_options)->with('guideline_options',$guideline_options)->with('language_options',$language_options)->with('publication',$publication)->with('types',$types)->with('countries',$countries)->with('guidelines',$guidelines)->with('contents',$contents)->with('imagesupl',$images);
        }
        else
            return Redirect::route('home')->with('global', "You're either not registered or you do not have enough privileges.");           

    }
    
    public function showEditGuideline($id)
    {
        if(Auth::check() && Auth::user()->type != 'normal') {

            $country_options = Country::lists('name', 'id');
            $event_type_options = EventType::lists('name', 'id');
            $guideline_options = DB::table('publications AS p')->join('publicationContents AS pc','pc.publication_id','=','p.id')->where('p.type','=','guideline')->lists('title','publication_id');
            $language_options = Language::lists('name', 'id');

            $publication = Publication::find($id);
            $types = Publication::find($id)->eventTypes->lists('id');
            $countries = Publication::find($id)->affectedCountries->lists('id');
            $alerts = Publication::find($id)->alerts->lists('id');
            $contents = Publication::find($id)->contents->toArray();

            $images_directory = public_path()."/assets/images/publications/".$id;
            $images = array();
            foreach(glob($images_directory.'/*.*') as $file) {
                array_push($images,$file);
            }


            return View::make('publication.edit-guideline')->with('country_options',$country_options)->with('event_type_options',$event_type_options)->with('guideline_options',$guideline_options)->with('language_options',$language_options)->with('publication',$publication)->with('types',$types)->with('countries',$countries)->with('alerts',$alerts)->with('contents',$contents)->with('imagesupl',$images);
        }
        else
            return Redirect::route('home')->with('global', "You're either not registered or you do not have enough privileges.");           

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
    
    public function showCreateGuideline() {
        
        if(Auth::check() && Auth::user()->type != 'normal') {
        
        $country_options = Country::lists('name', 'id');
        $event_type_options = EventType::lists('name', 'id');
        $alert_options = DB::table('publications AS p')->join('publicationContents AS pc','pc.publication_id','=','p.id')->where('p.type','=','alert')->lists('title','publication_id');
        $language_options = Language::lists('name', 'id');

        return View::make('publication.create-guideline')->with('country_options',$country_options)->with('event_type_options',$event_type_options)->with('alert_options',$alert_options)->with('language_options',$language_options);
        }
        
        else
            return Redirect::route('home')->with('global', "You're either not registered or you do not have enough privileges.");
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
    
    public function createAlert() {

        //create the publication
        $pub = [
            'initial_date' => Input::get('alert-durationfrom'),
            'final_date' => Input::get('alert-durationto'),
            'is_public' => Input::get('alert-visibility'),
            'periodic_notification' => 7,
            'risk' => Input::get('alert-risk'),
            'user_id' => Auth::user()->id,
            'type' => "alert"
        ];
        if($pub['initial_date'] == '')
            $pub['initial_date'] = null;
        if($pub['final_date'] == '')
            $pub['final_date'] = null;
        
        $alert_guidelines = Input::get('alert-guidelines');
        $alert_countries = Input::get('alert-countries');
        $alert_types = Input::get('alert-types');
        
        $publication = new Publication($pub);

        $languages = json_decode(Input::get('alert-languages'), true);
        $languages_toarray = [];
        
        $en_id = Language::where('name','=','English')->first()->id;
        //publication content in english
        $pub_content1 = [
                'title' => Input::get('alert-title'),
                'content' => Input::get('alert-description'),
                'language_id' => $en_id, //language id
                'publication_id' => null, //defined at insertion in db*
        ];

        $publication_content1 = new PublicationContent($pub_content1);
        
        foreach($languages as $key => $lang) {
            //create the publication content
            $pub_content = [
                'title' => Input::get("alert-title".$lang),
                'content' => Input::get("alert-description".$lang),
                'language_id' => $lang, //language id
                'publication_id' => null, //defined at insertion in db*
            ];

            $publication_content = new PublicationContent($pub_content);
            
            //array_push($languages_toarray, $publication_content);
            
            $languages_toarray[$key] = $publication_content;
        }
        
        //rules for validator
        $rules_publication = [
            'is_public' => 'required',
            'risk' => 'required|numeric',
            'type' => 'required'
        ];
        
        $rules_content = [
            'title' => 'required|max:50',
            'content' => 'required'
        ];
        
        $valid_publication = Validator::make($pub, $rules_publication);
        //cycle through multiple languages
        $valid_content = Validator::make($pub_content1, $rules_content);
        if ($valid_publication->passes())
        { 
            if($valid_content->passes()){
                $publication->save();
                //cycle through multiple languages
                
                //Storing images
                if(Input::hasFile('alert-images'))
                {   
                    $destinationPath = public_path().'/assets/images/publications/' . $publication->id . '/';
                    if(!File::exists($destinationPath))
                        File::makeDirectory($destinationPath,  $mode = 0777, $recursive = true);
                    $images = Input::file('alert-images');
                    for ($i=0; $i < count($images); $i++)
                    {
                        $image = $images[$i];
                        $extension = $image->guessExtension();
                        $image->move($destinationPath, $i . '.' . $extension );
                    }
                }
                
                $publication_content1->publication_id = $publication->id;
                $publication_content1->save();
                foreach($languages_toarray as $lang){
                    $lang->publication_id = $publication->id;// here*
                    $lang->save();
                }
                
                //create the constraints in the database
                if(!empty($alert_guidelines)){
                    foreach ($alert_guidelines as $guideline_id) {
                         $publication->guidelines()->attach($guideline_id);
                    }
                }
                if(!empty($alert_types)){
                    foreach ($alert_types as $types_id) {
                         $publication->eventTypes()->attach($types_id);
                    }
                }
                if(!empty($alert_countries)){
                    foreach ($alert_countries as $country_id) {
                         $publication->affectedCountries()->attach($country_id);
                    }
                }
                
                // If there notifications to send, send it
                $this->checkCreateNotification($publication);
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
            'initial_date' => Input::get('guideline-durationfrom'),
            'final_date' => Input::get('guideline-durationto'),
            'is_public' => Input::get('guideline-visibility'),
            'periodic_notification' => 7,
            'risk' => Input::get('guideline-risk'),
            'type' => "guideline",
            'user_id' => Auth::user()->id
        ];
        
        if($pub['initial_date'] == '')
            $pub['initial_date'] = null;
        if($pub['final_date'] == '')
            $pub['final_date'] = null;

        $guideline_alerts = Input::get('guideline-alerts');
        $guideline_countries = Input::get('guideline-countries');
        $guideline_types = Input::get('guideline-types');

        $publication = new Publication($pub);


        $languages = json_decode(Input::get('alert-languages'), true);
        $languages_toarray = [];

        $en_id = Language::where('name','=','English')->first()->id;
        //publication content in english
        $pub_content1 = [
            'title' => Input::get('guideline-title'),
            'content' => Input::get('guideline-description'),
            'language_id' => $en_id, //language id
            'publication_id' => null, //defined at insertion in db*
        ];

        $publication_content1 = new PublicationContent($pub_content1);

        foreach($languages as $key => $lang) {
            //create the publication content
            $pub_content = [
                'title' => Input::get("alert-title".$lang),
                'content' => Input::get("alert-description".$lang),
                'language_id' => $lang, //language id
                'publication_id' => null, //defined at insertion in db*
            ];

            $publication_content = new PublicationContent($pub_content);

            //array_push($languages_toarray, $publication_content);

            $languages_toarray[$key] = $publication_content;
        }

        //rules for validator
        $rules_publication = [
            'is_public' => 'required',
            'risk' => 'required|numeric',
            'type' => 'required'
        ];

        $rules_content = [
            'title' => 'required|max:50',
            'content' => 'required'
        ];

        $valid_publication = Validator::make($pub, $rules_publication);
        //cycle through multiple languages
        $valid_content = Validator::make($pub_content1, $rules_content);
        if ($valid_publication->passes())
        { 
            if($valid_content->passes()){
                $publication->save();
                //cycle through multiple languages
                
                //Storing images
                if(Input::hasFile('guideline-images'))
                {   
                    $destinationPath = public_path().'/assets/images/publications/' . $publication->id . '/';
                    if(!File::exists($destinationPath))
                        File::makeDirectory($destinationPath,  $mode = 0777, $recursive = true);
                    $images = Input::file('guideline-images');
                    for ($i=0; $i < count($images); $i++)
                    {
                        $image = $images[$i];
                        $extension = $image->guessExtension();
                        $image->move($destinationPath, $i . '.' . $extension );
                    }
                }
                
                $publication_content1->publication_id = $publication->id;
                $publication_content1->save();
                foreach($languages_toarray as $lang){
                    $lang->publication_id = $publication->id;// here*
                    $lang->save();
                }
                //create the constraints in the database
                if(!empty($guideline_alerts)){
                    foreach ($guideline_alerts as $alert) {
                        Publication::find($alert)->guidelines()->attach($publication->id);                    
                    }
                }
                if(!empty($guideline_types)){
                    foreach ($guideline_types as $types_id) {
                        $publication->eventTypes()->attach($types_id);
                    }
                }
                if(!empty($guideline_countries)){
                    foreach ($guideline_countries as $country_id) {
                        $publication->affectedCountries()->attach($country_id);
                    }
                }

				        // If there notifications to send, send it
                $this->checkCreateNotification($publication);

                return Redirect::to('/')->with('global', 'Guideline was created!');
            }
            else
                return Redirect::back()->withErrors($valid_content)->withInput();
        }
        else
            return Redirect::back()->withErrors($valid_publication)->withInput();            
    }

    public function checkCreateNotification($publication)
    {
    	if($publication->is_public)
    	{
	    	//Creating the countries array
	    	$countries = array();
	    	foreach ($publication->affectedCountries as $country)
	    		array_push($countries, $country->id);

        if(count($countries) <= 0)
          return;

	    	// Get the notifications
	    	$notifications = NotificationSetting::where('risk', '>=', $publication->risk)
	    		->whereIn('country_id', $countries)->get();

	    	$already_sent = array();
	    	// Sending the email to each needed user
	    	foreach ($notifications as $notification) 
	    	{
	    		$user_id = $notification->user->id;
	    		// Avoid sending repeated emails
	    		if(!in_array($user_id, $already_sent))
	    		{
	    			array_push($already_sent, $user_id);
		    		$email       = $notification->user->email;
		    		$username    = $notification->user->username; 
		    		$email_spotA = Config::get('mail.username');
					  $name_spotA  = Config::get('mail.from.name');

		    		Mail::send('emails.notification_create', 
					array('username' => $username, 'publ_name' => $publication->contents()->first()->title, 'publ_risk' => $publication->risk), 
					function($message) use ($email, $username, $email_spotA, $name_spotA) 
					{
							$message->from($email_spotA, $name_spotA)
								->to($email, $username)
								->subject('[Spot Alert] You have received a notification!')
								->replyTo($email_spotA, $name_spotA);
					});
	    		}
	    	}
	    }
    }
 
    public function updateAlert() {
        
        $id = Input::get('alert-id');
            
        $publication = Publication::find($id);
        
        $date = date_create('now');
        $date = date_format($date, 'Y-m-d');
        
        //edit the publication
        if(Input::get('alert-durationfrom') == "")
            $publication->initial_date = null;
        else $publication->initial_date = Input::get('alert-durationfrom');
        if(Input::get('alert-durationto') == "")
            $publication->final_date = null;
        else $publication->final_date = Input::get('alert-durationto');
        $publication->is_public = Input::get('alert-visibility');
        $publication->periodic_notification = 7;
        $publication->risk = Input::get('alert-risk');
        $publication->type = "alert";
        $publication->last_update = $date;

        $alert_guidelines = Input::get('alert-guidelines');
        $alert_countries = Input::get('alert-countries');
        $alert_types = Input::get('alert-types');

        
        $languages = json_decode(Input::get('alert-languages'), true);
        $languages_toarray = [];

        
        $publication_content1 = PublicationContent::whereRaw('publication_id = ? and language_id = ?',[$id,1])->first();
        //publication content in english
        $publication_content1->title = Input::get('alert-title');
        $publication_content1->content = Input::get('alert-description');
        $publication_content1->language_id = 1; //language id
        $publication_content1->publication_id = null; //defined at insertion in db*

        

        foreach($languages as $key => $lang) {
            
            $publication_content = PublicationContent::whereRaw('publication_id = ? and language_id = ?',[$id,$lang])->first();
            
            if($publication_content){
                //create the publication content
                $publication_content->title = Input::get("alert-title".$lang);
                $publication_content->content = Input::get("alert-description".$lang);
                $publication_content->language_id = $lang; //language id
                $publication_content->publication_id = $id; //defined at insertion in db*
                
                
                $languages_toarray[$key] = $publication_content;
            }
        }
        
        $publication->save();
        //cycle through multiple languages
        //var_dump($publication_content1);
        //die();
        $publication_content1->publication_id = $publication->id;
        $publication_content1->save();
        
        foreach($languages_toarray as $lang){
            
            $lang->publication_id = $publication->id;// here*
            $lang->save();
        }
        //create the constraints in the database
        if(!empty($alert_guidelines)){
            foreach ($alert_guidelines as $guideline_id) {
                $publication->guidelines()->attach($guideline_id);
            }
        }
        if(!empty($alert_types)){
            foreach ($alert_types as $types_id) {
                $publication->eventTypes()->attach($types_id);
            }
        }
        if(!empty($alert_countries)){
            foreach ($alert_countries as $country_id) {
                $publication->affectedCountries()->attach($country_id);
            }
        }
        $this->checkEditNotification($publication);

        return Redirect::to('/')->with('success', 'The alert was updated!');      
    }
    
    public function updateGuideline() {

        $id = Input::get('guideline-id');

        $publication = Publication::find($id);

        $date = date_create('now');
        $date = date_format($date, 'Y-m-d');

        //edit the publication
        if(Input::get('guideline-durationfrom') == "")
            $publication->initial_date = null;
        else $publication->initial_date = Input::get('guideline-durationfrom');
        if(Input::get('guideline-durationto') == "")
            $publication->final_date = null;
        else $publication->final_date = Input::get('guideline-durationto');
        $publication->is_public = Input::get('guideline-visibility');
        $publication->periodic_notification = 7;
        $publication->risk = Input::get('guideline-risk');
        $publication->type = "guideline";
        $publication->last_update = $date;

        $guideline_guidelines = Input::get('guideline-alerts');
        $guideline_countries = Input::get('guideline-countries');
        $guideline_types = Input::get('guideline-types');


        $languages = json_decode(Input::get('guideline-languages'), true);
        $languages_toarray = [];


        $publication_content1 = PublicationContent::whereRaw('publication_id = ? and language_id = ?',[$id,1])->first();
        //publication content in english
        $publication_content1->title = Input::get('guideline-title');
        $publication_content1->content = Input::get('guideline-description');
        $publication_content1->language_id = 1; //language id
        $publication_content1->publication_id = null; //defined at insertion in db*



        foreach($languages as $key => $lang) {

            $publication_content = PublicationContent::whereRaw('publication_id = ? and language_id = ?',[$id,$lang])->first();

            if($publication_content){
                //create the publication content
                $publication_content->title = Input::get("guideline-title".$lang);
                $publication_content->content = Input::get("guideline-description".$lang);
                $publication_content->language_id = $lang; //language id
                $publication_content->publication_id = $id; //defined at insertion in db*


                $languages_toarray[$key] = $publication_content;
            }
        }

        $publication->save();
        //cycle through multiple languages
        //var_dump($publication_content1);
        //die();
        $publication_content1->publication_id = $publication->id;
        $publication_content1->save();

        foreach($languages_toarray as $lang){

            $lang->publication_id = $publication->id;// here*
            $lang->save();
        }
        //create the constraints in the database
        if(!empty($guideline_alerts)){
            foreach ($guideline_alerts as $alert) {
                $publication->guidelines()->attach($guideline_id);
            }
        }
        if(!empty($guideline_types)){
            foreach ($guideline_types as $types_id) {
                $publication->eventTypes()->attach($types_id);
            }
        }
        if(!empty($guideline_countries)){
            foreach ($guideline_countries as $country_id) {
                $publication->affectedCountries()->attach($country_id);
            }
        }
        $this->checkEditNotification($publication);

        return Redirect::to('/')->with('success', 'The guideline was updated!');      
    }

    public function checkEditNotification($publication)
    {
    	if($publication->is_public)
    	{
            $users = $publication->usersNotified;

            foreach ($users as $user) 
            {
            	$email       = $user->email;
	    		$username    = $user->username; 
	    		$email_spotA = Config::get('mail.username');
				$name_spotA  = Config::get('mail.from.name');

	    		Mail::send('emails.notification_edit', 
				array('username' => $username, 'publ_name' => $publication->title), 
				function($message) use ($email, $username, $email_spotA, $name_spotA) 
				{
						$message->from($email_spotA, $name_spotA)
							->to($email, $username)
							->subject('[Spot Alert] You have received a notification!')
							->replyTo($email_spotA, $name_spotA);
				});
            }
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
		    if(Auth::check() && Auth::user()->type != 'normal')
		    	$json_response['author']       = $publication->author->username;

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

		    // See if it is a hidden publication
		    if(!$publication->is_public)
		    	$json_response['hidden'] = 1;


		    //See if there is an update to do
		    $today       = new DateTime;
		    $last_update = DateTime::createFromFormat('Y-m-d', $publication->last_update);
		    if($last_update)
		    	if($last_update->add(new DateInterval('P'.self::$update_interval.'D')) >= $today)
		    		$json_response['updated'] = 1;

		    //Decide if goes to the first or to the second array
		    $ini_date = DateTime::createFromFormat('Y-m-d', $publication->initial_date);
		    $fin_date = DateTime::createFromFormat('Y-m-d', $publication->final_date);
		    
		    if($ini_date)
		    	if($ini_date > $today)
		    	{
		    		$json_response['inactive'] = 1;
		    		array_push($second_array, $json_response);
		    		continue;
		    	}
		    if($fin_date)
		    	if($fin_date < $today)
		    	{
		    		$json_response['inactive'] = 1;
		    		array_push($second_array, $json_response);
		    		continue;
		    	}
		    array_push($first_array, $json_response);
		}

		return array_merge($first_array, $second_array);
	}
    /*
    *   make same as makeSimpleAnswer with description
    */
    private static function makeSimpleAnswerPlus($publication)
	{
		//Two arrays to append at the end
        $json_response = array();

        $json_response = array();
        $json_response['id'] = $publication->id;
        $json_response['initial_date'] = $publication->initial_date;
        $json_response['final_date']   = $publication->final_date;
        $json_response['risk']         = $publication->risk;
        $json_response['type']         = $publication->type;
        if(Auth::check() && Auth::user()->type != 'normal')
            $json_response['author']       = $publication->author->username;

        // Putting the titles in the response
        foreach ($publication->contents as $content)
        {
            if($content->language->code === Config::get('database.website_language_code'))
            {
                $json_response['title'] = $content->title;
                $json_response['content'] = $content->content;
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

        // See if it is a hidden publication
        if(!$publication->is_public)
            $json_response['hidden'] = 1;


        //See if there is an update to do
        $today       = new DateTime;
        $last_update = DateTime::createFromFormat('Y-m-d', $publication->last_update);
        if($last_update)
            if($last_update->add(new DateInterval('P'.self::$update_interval.'D')) >= $today)
                $json_response['updated'] = 1;

        //Decide if goes to the first or to the second array
        $ini_date = DateTime::createFromFormat('Y-m-d', $publication->initial_date);
        $fin_date = DateTime::createFromFormat('Y-m-d', $publication->final_date);

        if($ini_date)
            if($ini_date > $today)
            {
                $json_response['inactive'] = 1;
            }
        if($fin_date)
            if($fin_date < $today)
            {
                $json_response['inactive'] = 1;
            }
         return array($json_response);
    }
}