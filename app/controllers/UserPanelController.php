<?php 
class UserPanelController extends BaseController {
	
	/* show the usercontrol panel */
	public function show() {
		// get user profile data to fill. TODO: fix to Auth:user 
		$profile = User::find(Auth::user()->getId());
		return View::make('user.controlpanel',array('user'=>$profile));
	}

    public function getPrivileges() {
        $profile = User::find(Auth::user()->getId());
        return View::make('user.privileges',array('user' => $profile));
    }

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