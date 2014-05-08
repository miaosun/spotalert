<?php 
class UserPanelController extends BaseController {
	
	/* show the usercontrol panel */
	public function show() {

		// get user profile data to fill. TODO: fix to Auth:user 
		$profile = User::find(2);
		return View::make('user.controlpanel',array('user'=>$profile));
	}
	
	/* update user profile data  */
	public function updateprofile() 
	{
		// TODO fix to auth:user
		$profile = User::find(2);

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
			if(Input::hasFile('uploadfile'))
			{
				$filename = $profile->username;
				//$extension = Input::file('photo')->getClientOriginalExtension();
				//Input::file('uploadbtn')->move('/public/assets/images/user', $filename.$extension);
                //FIXME - change hardcode 3.jpg to login userid
				$uploadSuccess = Input::file('uploadfile')->move('/public/assets/images/user', '3.jpg');
			}
            else
            {
                $uploadSuccess = true;
            }
			//TODO rest of inputs
			if($profile->save() && $uploadSuccess)
                return Redirect::route('control-panel')->with(array('user'=> $profile,'msg' => 'Teste: update with success!'));
			else
				return View::make('user.controlpanel', array('user'=> $profile,'msg' => "Teste: update without sucess! Can't save model"));
		}
		else
			return View::make('user.controlpanel', array('user'=> $profile,'msg' => "Teste: update without success! Input not validated",'error' => $valid));
	}
    
	private function validate() 
	{
		//FIX and complete with more rules
	    $rules = array(
	    	'username'=>'AlphaNum',
			'email'=>'Between:3,64|Email'
	    );
	    return Validator::make(Input::all(), $rules);
    }
    
    private function validateWithPassword()
    {
    	$rules = array(
    		'username'=>'AlphaNum',
			'email'=>'Between:3,64|Email',
			'newpassword'=>'Required|AlphaNum|min:4|Confirmed',
			'newpassword_confirmation'=>'Required|AlphaNum|min:4'
	    );
	    return Validator::make(Input::all(), $rules);
    }
}