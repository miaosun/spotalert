<?php
class AccountController extends BaseController {

	public function getSignIn() {
		return View::make('home');
	}

	public function postSignIn() {
		$validator = Validator::make(Input::all(),
			array(
				'email_signin' => 'required|email',
				'password_signin' => 'required',
			)
		);

		if($validator->fails()) {
			return Redirect::route('home')
						->withErrors($validator)
						->withInput();
		}
		else {
			// Attempt user sign in
			$remember = (Input::has('remember')) ? true : false;

			$auth = Auth::attempt(array(
				'email' => Input::get('email_signin'),
				'password' => Input::get('password_signin'),
				'activated' => true
			), $remember);

			if($auth) {
				//Redirect to the intended page
				return Redirect::intended('/');
			}
			else {
				return Redirect::route('home')
						->with('global', 'Email/Password wrong, or account not activated.');
			}
		}

		return Redirect::route('home')
				->with('global', 'There was a problem signing you in.');
	}

	public function getSignOut() {
		Auth::logout();
		return Redirect::route('home');
	}

	public function getCreate() {
        $country_options = array('' => 'CHOOSE COUNTRY') + Country::lists('name', 'id');
        $age_options = array('' => 'CHOOSE AGE RANGE') + Age::lists('stepname','id');
        //$age_options = array('' => 'CHOOSE AGE RANGE') + DB::table('ages')->lists('range','id');
        //$country_options = array('' => 'CHOOSE COUNTRY') + DB::table('countries')->orderBy('short_name', 'asc')->lists('short_name','id');
		return View::make('account.create')->with('country_options',$country_options)->with('age_options',$age_options);
	}

	public function postCreate() {
		$validator = Validator::make(Input::all(),
			array(
				'email'          => 'required|max:50|email|unique:users',
				'username'       => 'required|max:20|min:3|unique:users',
				'password'       => 'required|min:6',
				'password_again' => 'required|same:password',
                'firstname'      => 'max:20',
                'lastname'       => 'max:20',
                'phonenumber'    => 'max:20',
                'address'        => 'max:30',
                'city'           => 'max:20',
                'postalCode'     => 'max:15',
                'agerange'       => 'Digits|required|min:1',
                'residence'      => 'Digits|required|min:1',
                'nationality'    => 'Digits|required|min:1',
                'accept'         => 'accepted'
			)
		);

		if($validator->fails()) {
			return Redirect::route('account-create')
					-> withErrors($validator)
					-> withInput();
		}
		else {
			// create account
			$email = Input::get('email');
			$username = Input::get('username');
			$password = Input::get('password');
            $agerange = Input::get('agerange');
            $firstname = Input::get('firstname');
            $lastname = Input::get('lastname');
            $phonenumber = Input::get('phonenumber');
            $address = Input::get('address');
            $city = Input::get('city');
            $postalCode = Input::get('postalCode');
            $residence = Input::get('residence');
            $nationality = Input::get('nationality');
			// Activation code
			$code = str_random(60);

			$user = User::create(array(
				'email'       => $email,
				'username'    => $username,
				'password'    => Hash::make($password),
				'code'        => $code,
                'age_id'    => $agerange,
                'firstname'   => $firstname,
                'lastname'    => $lastname,
                'phonenumber' => $phonenumber,
                'address'     => $address,
                'city'        => $city,
                'postalCode'    => $postalCode,
                'residence_country_id'   => $residence,
                'nationality_country_id' => $nationality,
                'created_at'  => date('Y-m-d')
			));

			if($user) {

				//send email to active account
				Mail::send('emails.auth.activate', array('link' => URL::route('account-activate', $code), 'username' => $username), function($message) use ($user) {
					$message->to($user->email, $user->username)->subject('Activate your account');
				});

				return Redirect::route('home')
					-> with('global', 'Your account has been created! We have sent you a email to active your account!');
			}
		}
	}

	public function getActivate($code) {
		$user = User::where('code', '=', $code)->where('activated', '=', false);

		if($user->count()) {
			$user = $user->first();

			//update user to active state
			$user->activated = true;
			$user->code = '';

			if($user->save()) {
				return Redirect::route('home')
						->with('global', 'Activated! You can now sign in!');
			}
		}
		return Redirect::route('home')
					->with('global', 'We cannot activate your account. Try again later.');
	}

	public function getChangePassword() {
		return View::make('account.password');
	}

	public function postChangePassword() {
		$validator = Validator::make(Input::all(),
			array(
				'old_password'   => 'required',
				'password'       => 'required|min:6',
				'password_again' => 'required|same:password'
			)
		);

		if($validator->fails()) {
			return Redirect::route('account-change-password')
					->withErrors($validator);
		}
		else {
			// change password
			$user = User::find(Auth::user()->id);

			$old_password = Input::get('old_password');
			$password = Input::get('password');

			if(Hash::check($old_password, $user->getAuthPassword())) {
				$user->password = Hash::make($password);

				if($user->save()) {
					return Redirect::route('home')
							->with('global', 'Your password has been changed.');
				}
				else {
					return Redirect::route('account-change-password')
							->with('global', 'Your old password is incorrect.');
				}
			}
		}

		return Redirect::route('account-change-password')
				->with('global', 'Your password could not be changed.');
	}

    public function getForgotPassword() {
        return View::make('account.forgot');
    }

    public function postForgotPassword() {
        $validator = Validator::make(Input::all(),
            array(
                'email_recover' => 'required|email'
             )
        );

        if($validator->fails())
        {
            return Redirect::route('account-forgot-password')
                    ->withErrors($validator)
                    ->withInput();
        }
        else
        {
            // change password
            $user = User::where('email', '=', Input::get('email_recover'));

            if($user->count()) {
                $user = $user->first();
                //Generate a new code and password
                $code     = str_random(60);
                $password = str_random(10);

                $user->code = $code;
                $user->password_temp = Hash::make($password);

                if($user->save()) {
                    Mail::send('emails.auth.forgot', array('link' => URL::route('account-recover', $code), 'username' => $user->username, 'password' => $password), function($message) use ($user) {
                        $message->to($user->email, $user->username)->subject('Your new password');
                    });

                    return Redirect::route('home')
                            ->with('global', 'We have sent you a new password by email.');
                }
            }
        }
            return Redirect::route('account-forgot-password')
                ->with('global', 'Email not registered, could not request recover!');

    }

    public function getRecover($code) {
        $user = User::where('code', '=', $code)
                ->where('password_temp', '!=', '');

        if($user->count()) {
            $user = $user->first();

            $user->password = $user->password_temp;
            $user->password_temp = '';
            $user->code = '';

            if($user->save()) {
                return Redirect::route('home')
                        ->with('global', 'Your account has been recovered and you can now sign in with your new password.');
            }

        }
        return Redirect::route('home')
                ->with('global', 'Could not recover your account.');
    }
}