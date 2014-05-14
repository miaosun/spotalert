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

Route::group(array('prefix' => 'publications'), function()
{
	// For the RSS feed
	Route::get('/rss', array(
		'as'	=> 'publications-rss',
		'uses'	=> 'PublicationController@getAllPublications'
	));

	// For searching publications
	Route::get('/search/{search_query}', array(
		'as'	=> 'publications-route',
		'uses'	=> 'PublicationController@getSearchedPublications'
	))
	->where('search_query', '[A-Za-z0-9\s]+');

	// For filtering
	// Possible parameters to receive: risks, event_types, affected_countries
	// In each one, separate the elements by commas
	Route::get('/filter/', array(
		'as'	=> 'publications-filter',
		function() 
		{ 
			$risks				= Input::get('risks');
			$event_types 		= Input::get('event_types');
			$affected_countries	= Input::get('affected_countries');
      		
      		if(!isset($risks) || $risks === '')
      			$risks = NULL;
      		if(!isset($event_types) || $event_types === '')
      			$event_types = NULL;
      		if(!isset($affected_countries) || $affected_countries === '')
      			$affected_countries = NULL;


      		$publications = PublicationController::getFilteredPublications($risks, $event_types, $affected_countries);
      		return View::make('includes.publications')->with('publications', $publications);
     	},
	));
});

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

/*
 * AUTHENTICATED GROUP
 */
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


/*
 * UNAUTHENTICATED GROUP
 */
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

        // Forgot password (POST)
        Route::post('/account/forgot-password', array(
            'as' => 'account-forgot-password-post',
            'uses' => 'AccountController@postForgotPassword'
        ));
	});

    // Forgot password (GET)
    Route::get('/account/forgot-password', array(
        'as' => 'account-forgot-password',
        'uses' => 'AccountController@getForgotPassword'
    ));

    Route::get('/account/recover/{code}', array(
        'as' => 'account-recover',
        'uses' => 'AccountController@getRecover'
    ));


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