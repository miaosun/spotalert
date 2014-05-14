<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array(
	'as' => 'home',
	'uses' => 'HomeController@showWelcome'
));

Route::get('/publications', array(
	'as'	=> 'publications',
	'uses'	=> 'PublicationController@getPublications'
));

Route::get('/user/{username}', array(
 	'as' => 'profile-user',
 	'uses' => 'ProfileController@user'
));

//Create Alert (POST)
       Route::post('/publication/createalert', array(
            'as' => 'publication-createalert',
            'uses' => 'PublicationController@createAlert'
       ));
            
        //Create Alert (POST)
        Route::post('/publication/createguideline', array(
            'as' => 'publication-createguideline',
            'uses' => 'PublicationController@createGuideline'
       ));


/* Control Panel */

//FIXME route for testing controlpanel without login
Route::get('/user', array(
	'as' => 'control-panel',
	'uses' => 'UserPanelController@show'
));

// update profile form route
Route::post('/user/updateprofile', array(
	'as' => 'update-profile',
	'uses' => 'UserPanelController@updateprofile'
));

// authenticated group
Route::group(array('before' => 'auth'), function() {

	// CSRF protection group
	Route::group(array('before' => 'csrf'), function() {

		// change password (POST)
		Route::post('/account/change-password', array(
			'as' => 'account-change-password-post',
			'uses' => 'AccountController@postChangePassword'
		));
	});

	// change password (GET)
	Route::get('/account/change-password', array(
		'as' => 'account-change-password',
		'uses' => 'AccountController@getChangePassword'
	));

	// sign out (GET)
	Route::get('/account/sign-out', array(
		'as' => 'account-sign-out',
		'uses' => 'AccountController@getSignOut'
	));

});

// unauthenticated group
Route::group(array('before' => 'guest'), function() {
	
	// CSRF protection group
	Route::group(array('before' => 'csrf'), function() {

		// create account (POST)
		Route::post('/account/create', array(
			'as' => 'account-create-post',
			'uses' => 'AccountController@postCreate'

		));

		// Sign in (POST)
		Route::post('/account/sign-in', array(
			'as' => 'account-sign-in-post',
			'uses' => 'AccountController@postSignIn'
	));
        
        
	});

	// sign in (GET)
	Route::get('/account/sign-in', array(
		'as' => 'account-sign-in',
		'uses' => 'AccountController@getSignIn'
	));



	// create account (GET)
	Route::get('/account/create', array(
		'as' => 'account-create',
		'uses' => 'AccountController@getCreate'

	));

	Route::get('/account/activate/{code}', array(
		'as' => 'account-activate',
		'uses' => 'AccountController@getActivate'
	));
    
    // show create alert (GET)
	Route::get('/publication/create-alert', array(
		'as' => 'publication-create-alert',
		'uses' => 'PublicationController@showCreateAlert'
	));
    
    // show create alert (GET)
	Route::get('/publication/create-guideline', array(
		'as' => 'publication-create-alert',
		'uses' => 'PublicationController@showCreateGuideline'
	));

});