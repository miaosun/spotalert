<?php

class PublicationController extends BaseController
{
	public static function getPublications() {
		return Publication::all();
	}
    
    public function showCreateAlert() {
        
        $country_options = Country::lists('name', 'id');
        $event_type_options = EventType::lists('name', 'id');
        //$guideline_options = Publication::where('type','=','guideline')->lists('title', 'id');
        
        $guideline_options = DB::table('publications AS p')
  ->join('publicationContents AS pc','pc.publication_id','=','p.id')
  ->where('p.type','=','guideline')
  ->lists('title','publication_id');
        
		return View::make('publication.create-alert')->with('country_options',$country_options)->with('event_type_options',$event_type_options)->with('guideline_options',$guideline_options);

	}
    
    public function showCreateGuideline() {
		return View::make('publication.create-guideline');

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
            'language_id' => 3,
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

}