<?php 
class UserPanelController extends BaseController {

	/* show the usercontrol panel */
	public function show() {
		$profile = User::find(Auth::user()->getId());
        return View::make('user.controlpanel',array('user'=>$profile));
	}

    public function getPrivileges() {
        $profile = User::find(Auth::user()->getId());
        $users_with_permissions = User::where('type','<>', 'normal')->get();
        $selected = false;
        return View::make('user.privileges' ,array('selected'=>$selected, 'user' => $profile,  'users_with_permissions'=>$users_with_permissions));
    }

    public function getPrivilegesWithUser() {
        $profile = User::find(Auth::user()->getId());
        $users_with_permissions = User::where('type','<>', 'normal')->get();
        if(Input::has('username'))
        {
            $selected = true;
            $selectedUser = User::where('username', '=', Input::get("username"))->firstOrFail();
            return View::make('user.privileges', array('selected'=>$selected, 'user' => $profile, 'selectedUser' => $selectedUser, 'users_with_permissions'=>$users_with_permissions));
        }
        else
            return Redirect::route('user-privileges');

    }

    public function updatePrivileges() {
        return Redirect::route('user-privileges')->with('global', 'Changes made with success!');
    }

    // Notifications Page
    public function getNotifications()  {
        $temp = array();
        foreach(PublicationController::getAllPublications() as $publication)
        {
            $temp[$publication['id']] = $publication['title'];
        }
        $country_options = array('' => Lang::get('controlpanel.notifications.country_option')) + Country::lists('name', 'id');
        $publication_options = array('' => Lang::get('controlpanel.notifications.publication')) + $temp;
        $notification_settings = NotificationSetting::all();
        $user_publications = DB::table('publications')
                                ->join('users_publications', 'users_publications.publication_id', '=', 'publications.id')
                                ->join('publicationContents', 'publicationContents.publication_id', '=', 'publications.id')
                                ->get(array('publications.id', 'title'));
        //var_dump($user_publications->toArray());
        return View::make('user.notifications')->with('country_options', $country_options)->with('publication_options', $publication_options)->with('notification_settings', $notification_settings)->with('user_publications', $user_publications);
    }

    public function addCountryRisk() {
        $validator = Validator::make(Input::all(),
            array(
                'country'        => 'required',
                'minimum_risk'  => 'required',
            )
        );

        if($validator->fails()) {
            return Redirect::route('user-notifications')
                -> withErrors($validator);
        }
        else
        {
            $country_id = Input::get('country');
            $risk_level = Input::get('minimum_risk');
            $notificationSetting = NotificationSetting::create(array(
                'country_id'    => $country_id,
                'risk'          => $risk_level,
                'user_id'       => Auth::user()->getId()
            ));

            if($notificationSetting) {
                return Redirect::route('user-notifications')
                    -> with('global', 'Notofication for Country and Minimum Risk Level added successfully!');
            }
        }

    }

    public function addPublication() {
        $validator = Validator::make(Input::all(),
            array(
                'publication'        => 'required',
            )
        );

        if($validator->fails()) {
            return Redirect::route('user-notifications')
                -> withErrors($validator)
                -> withInput();
        }
        else
        {
            $publication_id = Input::get('publication');

            $user = User::find(Auth::user()->getId());
            $user->publicationNotifications()->attach($publication_id);

            if($user) {
                return Redirect::route('user-notifications')
                    -> with('global', 'Notofication for selected Publication added successfully!');
            }
        }
    }

    // Comments Page
    public function getComments()  {

        return View::make('user.comments');
    }

    /*  APIs  */
    public function getUsernames() {
        $usernames_array = User::lists('username');
        return Response::json($usernames_array);
    }

    public function getEmails() {
        $emails_array = User::lists('email');
        return Response::json($emails_array);
    }

    public function getAges() {
        $age_options = array('0'=> Lang::get('register.placeholder.country')) + Age::lists('stepname','id');
        return Response::json($age_options);
    }

    public function getCountries() {
        $country_options = array('0' => Lang::get('register.placeholder.age_range')) + Country::lists('name', 'id');
        return Response::json($country_options);
    }
	
	/* update user profile data  */
	public function updateprofile() 
	{
		// TODO fix to auth:user
		$profile = User::find(Auth::user()->getId());

		if(Input::has('newpassword'))
		{
			$valid = $this->validateWithPassword();
		}
		else
		{
			$valid = $this->validate();
		}
		if($valid->passes())
		{	
			if(Input::has('newpassword'))
			{
				//$profile->password = Hash::make(Input::get('newpassword'));
				$profile->password = Input::get('newpassword');
			}
			if(Input::has('username'))
			{
				$profile->username = Input::get('username');
			}
			if(Input::has('firstname'))
			{
				$profile->firstname = Input::get('firstname');
			}
			if(Input::has('lastname'))
			{
				$profile->lastname = Input::get('lastname');
			}
            if(Input::has('agerange'))
            {
                $profile->age_id = Input::get('agerange');
            }
            if(Input::has('residence'))
            {
                $profile->residence_country_id = Input::get('residence');
            }
            if(Input::has('nationality'))
            {
                $profile->nationality_country_id = Input::get('nationality');
            }
			if(Input::hasFile('uploadfile'))
			{
				$filename = $profile->username;
				//$extension = Input::file('photo')->getClientOriginalExtension();
				//Input::file('uploadbtn')->move('/public/assets/images/user', $filename.$extension);
                //FIXME - change hardcode 3.jpg to login userid
				$uploadSuccess = Input::file('uploadfile')->move('/public/assets/images/user', Auth::user()->getId().'.jpg');
			}
            else
            {
                $uploadSuccess = true;
            }
			//TODO rest of inputs
			if($profile->save() && $uploadSuccess)
                return Redirect::route('control-panel')->with('global','Teste: update with success!')->withErrors($valid);
			else
                return Redirect::route('control-panel')->with('global',"Teste: update without sucess! Can't save model!")->withErrors($valid);
		}
		else
            return Redirect::route('control-panel')->with('global',"Teste: update failed! Input not validated!")->withErrors($valid);
	}

    public function getPublications() 
    {
        $publications = PublicationController::getPublicationsForUserPanel();
        return View::make('user.publications')->with('publications', $publications);
    }
    
	private function validate() 
	{
		//FIX and complete with more rules
        return Validator::make(Input::all(),
            array(
                'email'          => 'max:50|email|unique:users',
                'username'       => 'max:20|min:3|unique:users',
                'firstname'      => 'max:20',
                'lastname'       => 'max:20',
                'phonenumber'    => 'max:20',
                'address'        => 'max:30',
                'city'           => 'max:20',
                'postalCode'     => 'max:15',
                'agerange'       => 'numeric|min:1',
                'residence'      => 'numeric|min:1',
                'nationality'    => 'numeric|min:1'
            )
        );
    }
    
    private function validateWithPassword()
    {
        return Validator::make(Input::all(),
            array(
                'newpassword'=>'Required|AlphaNum|min:4|Confirmed',
                'newpassword_confirmation'=>'Required|AlphaNum|min:4',
                'email'          => 'required|max:50|email|unique:users',
                'username'       => 'required|max:20|min:3|unique:users',
                'firstname'      => 'max:20',
                'lastname'       => 'max:20',
                'phonenumber'    => 'max:20',
                'address'        => 'max:30',
                'city'           => 'max:20',
                'postalCode'     => 'max:15',
                'agerange'       => 'numeric|min:1',
                'residence'      => 'numeric|min:1',
                'nationality'    => 'numeric|min:1'
	        )
        );
    }
}