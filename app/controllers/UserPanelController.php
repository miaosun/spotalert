<?php 
class UserPanelController extends BaseController {

	/* show the usercontrol panel */
	public function show() {
		$profile = User::find(Auth::user()->getId());
        $srcPath = public_path().'/assets/images/user/'.Auth::user()->getId().'.jpg';
        $pic=FALSE;
        if(File::exists($srcPath))
        {
            $pic=TRUE;
        }
        return View::make('user.controlpanel',array('user'=>$profile))->with('pic',$pic);
	}

    /* Privileges Page */
    public function getPrivileges() {
        $profile = User::find(Auth::user()->getId());
        if($profile['type'] == "admin")
            $users_privileges = User::where('id', '<>', Auth::user()->getId())->get();
        if($profile['type'] == "manager")
            $users_privileges = User::where('type', '<>', 'admin')->where('type', '<>', 'manager')->get();
        $selected = false;
        return View::make('user.privileges' ,array('selected'=>$selected, 'user' => $profile,  'users_privileges'=>$users_privileges));
    }

    public function updatePrivileges($username) {
        //Have to select a user (click search button, go to route('selectedUser->privileges') first
        $profile = User::find(Auth::user()->getId());
        if($profile->username == $username)
            return Redirect::route('user-privileges')->with('global', 'Change failed! Select a user first!');

        if(Input::has('department') && Input::has('permissions'))
            DB::update('update users set organization=?, type = ? where username = ?', array(Input::get('department'), Input::get('permissions'), $username));
        else if(Input::has('department'))
            DB::update('update users set organization=? where username = ?', array(Input::get('department'), $username));
        else if(Input::has('permissions'))
            DB::update('update users set type = ? where username = ?', array(Input::get('permissions'), $username));

        else
            Redirect::route('user-privileges')->with('global', 'Can not make changes!');

        return Redirect::route('user-privileges')->with('global', 'Changes made with success!');
    }

    public function deleteUser() {
        $profile = User::find(Auth::user()->getId());
        if(Input::has('del_username'))
        {
            $username = Input::get('del_username');

            if($profile->type == 'admin' || $profile->type == 'manager')
            {
                User::where('username', '=', $username)->delete();
                return Redirect::route('user-privileges')->with('global', 'Selected user deleted successfully!');
            }
        }
        else
        {
            return Redirect::route('user-privileges')->with('global', 'User not found!');
        }
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
        $notification_settings = NotificationSetting::where('user_id', '=', Auth::user()->getId())->get();

        $user_publications = Publication::with(array('usersNotified', 'contents'))
                                        ->whereHas('usersNotified', function($query)
                                        {
                                            $query->where('user_id', '=', Auth::user()->getId());
                                        })
                                        ->get();

        return View::make('user.notifications')->with('country_options', $country_options)->with('publication_options', $publication_options)->with('notification_settings', $notification_settings)->with('user_publications', $user_publications)->with('user', $profile);
    }

    public function deleteNotification($id)
    {
        $notification = NotificationSetting::find($id);
        if($notification != null)
            $notification->delete();
        return Redirect::route('user-notifications');
    }

    public function deletePublication($id)
    {
        $user = User::find(Auth::user()->getId());
        $user->publicationNotifications()->detach($id);
        return Redirect::route('user-notifications');
    }

    public function addCountryRisk() {
        $validator = Validator::make(Input::all(),
            array(
                'country'        => 'required',
                'minimum_risk'  => 'required|numeric',
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
            $notificationSetting = NotificationSetting::where('country_id','=',$country_id)->where('risk','=',$risk_level)->where('user_id','=',Auth::user()->getId())->first();
            if($notificationSetting == null)
            {
                $notificationSetting = NotificationSetting::create(array(
                    'country_id'    => $country_id,
                    'risk'          => $risk_level,
                    'user_id'       => Auth::user()->getId()
                ));

                if($notificationSetting) {
                    return Redirect::route('user-notifications');
                }
            }
            else
                return Redirect::route('user-notifications');
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
            if($user->publicationNotifications->contains($publication_id))
                return Redirect::route('user-notifications')->with('global', 'Selected Publication already in the list!');

            $user->publicationNotifications()->attach($publication_id);

            if($user) {
                return Redirect::route('user-notifications');
            }
        }
    }

    // Comments Page
    public function getComments()  {
        $profile = User::find(Auth::user()->getId());

        $comments = Comment::with(array('author', 'publication', 'publication.contents'))->where('approved', '=', false)->get();

        $answer = array();

        foreach($comments as $comment)
        {
            if(!$comment->approved)
            {
                $commentData = array('img'=>array());

                $srcPath = public_path().'/assets/images/comments/'.$comment->id;
                if(File::exists($srcPath))
                {
                    $imagesUrl = File::allFiles($srcPath);
                    foreach($imagesUrl as $imgUrl)
                    {
                        $commentData['img'] = array('url'=>$url = asset('assets/images/comments/'.$comment->id.'/'.$imgUrl->getRelativePathName()),'alt'=>$comment->publication->contents->first()->title);
                    }
                }

                $answer[$comment->id] = $commentData;
            }
        }

        return View::make('user.comments')->with('user', $profile)->with('comments', $comments)->with('images', $answer);
    }

    public function approveComment($id) {
        DB::update('update comments set approved = ? where id = ?', array('true', $id));

        return Redirect::route('user-comments');
    }

    public function deleteComment($id) 
    {
       if(Auth::check() && Auth::user()->type != 'normal')
       { 
        Comment::destroy($id);
        //Comment::where('id', '=', $id)->delete();
        return Redirect::route('user-comments');
       }
        else
            return 'No Autorization';
    }    
    /*  Submit new comments API  */
    public function submitComment($id) {
        
        if(Auth::check() && Input::has("text"))
        {
            //'content', 'created_at', 'approved', 'user_id', 'publication_id'
            $comment = new Comment;
            $comment->content = Input::get("text");
            $comment->created_at = date("Y-m-d H:i:s");
            $comment->approved = false;
            $comment->user_id = Auth::user()->id;
            $comment->publication_id = $id;
            
            if(Input::hasFile("img"))
            {
                // Validating the files that must be images
		        $img = Input::file('img');
                $input = array(
                    'img' => $img
                );

                $rules = array(
                    'img' => 'image|max:2048'
                );
                $validation = Validator::make($input, $rules);

                if($validation->passes()) 
                {
                    if($comment->save())
                    {
                        $destinationPath = public_path().'/assets/images/comments/'.$comment->id;
                        if(!File::exists($destinationPath))
                            File::makeDirectory($destinationPath,  $mode = 0777, $recursive = true);
                        $extension = $img->guessExtension();
                        $img->move($destinationPath, $comment->id . '.' . $extension);
                        if(File::exists($destinationPath.'/'.$comment->id . '.' . $extension))
                            $answer = array("msg" => Lang::get('controlpanel.comments.submit_msg.success'),"id"=>$id,"status"=>"ok");
                        else
                        {
                            
                            $answer = array("msg" => Lang::get('controlpanel.comments.submit_msg.fail_img'),"id"=>$id,"status"=>"Image not saved");
                            $comment->delete();
                        }
                    }
                    else
                    {
                        $answer = array("msg" => Lang::get('controlpanel.comments.submit_msg.fail'),"id"=>$id,"status"=>"DataBase Error: can't saved");
                    }
                }
                else
                {
                   $answer = array("msg" => Lang::get('controlpanel.comments.submit_msg.fail_img'),"id"=>$id,"status"=>"Image not valid");
                }
            }
            else
            {
                if($comment->save())
                    $answer = array("msg" => Lang::get('controlpanel.comments.submit_msg.success'),"id"=>$id,"status"=>"ok");
                else
                    $answer = array("msg" => Lang::get('controlpanel.comments.submit_msg.fail'),"id"=>$id,"status"=>"DataBase Error: can't saved");
            }
        }
        else
            $answer = array("msg"=>Lang::get('controlpanel.comments.submit_msg.bad_format'),"id"=>$id); 
        
        return Response::json($answer);
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
				$profile->password = Hash::make(Input::get('newpassword'));
				//$profile->password = Input::get('newpassword');
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
                $destinationPath = public_path().'/assets/images/user';
				//$extension = Input::file('photo')->getClientOriginalExtension();
                //FIXME - Not force to be jpg maybe? Photos have to be .jpg still..
				Input::file('uploadfile')->move($destinationPath, Auth::user()->getId().'.jpg');
                $uploadSuccess = File::exists($destinationPath.Auth::user()->getId().'.jpg');
                
			}
            else
            {
                $uploadSuccess = true;
            }
            //return Response::json(array("teste"=>$uploadSuccess));
			//TODO verificar porque nao está a fazer upload do uploadfile <----
			if($profile->save() && $uploadSuccess)
                return Redirect::route('control-panel')->withErrors($valid);
			else
                return Redirect::route('control-panel')->with('global',"Update without sucess! Can't save model!")->withErrors($valid);
		}
		else
            return Redirect::route('control-panel')->withErrors($valid);
	}

    public function getPublications() 
    {
        $profile = User::find(Auth::user()->getId());
        $publications = PublicationController::getPublicationsForUserPanel();
        return View::make('user.publications')->with('publications', $publications)->with('user', $profile);
    }
    
	private function validate() 
	{
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
                'newpassword'=>'Required|AlphaNum|min:6|Confirmed',
                'newpassword_confirmation'=>'Required|AlphaNum|min:4',
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
}