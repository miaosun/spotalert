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

        if(Input::has('username') || Input::has('email'))
        {
            if(Input::has('username'))
                $selectedUser = User::where('username', '=', Input::get("username"))->first();
            if(Input::has('email'))
                $selectedUser = User::where('email', '=', Input::get("email"))->first();
            if($selectedUser == null)
                return Redirect::route('user-privileges')->with('global', 'User not exists, try again!');
            $selected = true;
            return View::make('user.privileges', array('selected'=>$selected, 'user' => $profile, 'selectedUser' => $selectedUser, 'users_with_permissions'=>$users_with_permissions));
        }
        else
            return Redirect::route('user-privileges');
    }

    public function updatePrivileges($username) {
        //Have to select a user (click search button, go to route('selectedUser->privileges') first
        $profile = User::find(Auth::user()->getId());
        if($profile->username == $username)
            return Redirect::route('user-privileges')->with('global', 'Change failed! Select a user first!');

        DB::update('update users set type = ? where username = ?', array(Input::get('permissions'), $username));

        return Redirect::route('user-privileges')->with('global', 'Changes made with success!');
    }

    // Notifications Page
    public function getNotifications()  {
        $profile = User::find(Auth::user()->getId());
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

        return View::make('user.notifications')->with('country_options', $country_options)->with('publication_options', $publication_options)->with('notification_settings', $notification_settings)->with('user_publications', $user_publications)->with('user', $profile);
    }

    public function deleteNotification($id)
    {
        NotificationSetting::find($id)->delete();
        return Redirect::route('user-notifications')->with('global', 'Notification Setting deleted successfully!');
    }

    public function deletePublication($id)
    {
        $user = User::find(Auth::user()->getId());
        $user->publicationNotifications()->detach($id);
        return Redirect::route('user-notifications')->with('global', 'Notification for selected Publication deleted successfully!');
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
        $profile = User::find(Auth::user()->getId());

        $comments = Comment::with(array('author', 'publication', 'publication.contents'))->get();

        return View::make('user.comments')->with('user', $profile)->with('comments', $comments);
    }

    public function approveComment($id) {
        DB::update('update comments set approved = ? where id = ?', array('true', $id));

        return Redirect::route('user-comments')->with('global', 'Comment approved with success!');
    }

    public function deleteComment($id) {
        Comment::destroy($id);
        //Comment::where('id', '=', $id)->delete();
        return Redirect::route('user-comments')->with('global', 'Comment deleted with success!');
    }

    /*  APIs  */
    public function getUsernames() {
        $profile = User::find(Auth::user()->getId());
        if($profile['type'] == 'admin')
            $temp = User::where('type', '<>', 'admin')->get();
        if($profile['type'] == 'manager')
            $temp = User::where('type', '<>', 'admin')->where('type', '<>', 'manager')->get();
        $usernames_array = array();
        foreach($temp as $tem)
        {
            $usernames_array[] = $tem['username'];
        }
        return Response::json($usernames_array);
    }

    public function getEmails() {
        $profile = User::find(Auth::user()->getId());
        if($profile['type'] == 'admin')
            $temp = User::where('type', '<>', 'admin')->get();
        if($profile['type'] == 'manager')
            $temp = User::where('type', '<>', 'admin')->where('type', '<>', 'manager')->get();
        $useremails_array = array();
        foreach($temp as $tem)
        {
            $useremails_array[] = $tem['email'];
        }
        return Response::json($useremails_array);
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
        $profile = User::find(Auth::user()->getId());
        $publications = PublicationController::getPublicationsForUserPanel();
        return View::make('user.publications')->with('publications', $publications)->with('user', $profile);
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