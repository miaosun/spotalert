<?php
class AccountController extends BaseController {

	public function getSignIn() {
		return View::make('home');
	}

	public function postSignIn() {
		$validator = Validator::make(Input::all(),
			array(
				'email' => 'required|email',
				'password' => 'required',
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
				'email' => Input::get('email'),
				'password' => Input::get('password'),
				'active' => 1
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
		return View::make('account.create');

	}

	public function postCreate() {
		$validator = Validator::make(Input::all(),
			array(
				'email'          => 'required|max:50|email|unique:users',
				'username'       => 'required|max:20|min:3|unique:users',
				'password'       => 'required|min:6',
				'password_again' => 'required|same:password',
                'agerange'       => 'required'
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
            $postcode = Input::get('postcode');

			// Activation code
			$code = str_random(60);

			$user = User::create(array(
				'email'       => $email,
				'username'    => $username,
				'password'    => Hash::make($password),
				'code'        => $code,
				'active'      => 0,
                'agerange'    => $agerange,
                'firstname'   => $firstname,
                'lastname'    => $lastname,
                'phonenumber' => $phonenumber,
                'address'     => $address,
                'city'        => $city,
                'postcode'    => $postcode
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
		$user = User::where('code', '=', $code)->where('active', '=', 0);

		if($user->count()) {
			$user = $user->first();

			//update user to active state
			$user->active = 1;
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