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

}