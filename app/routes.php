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
	// All publications
	Route::get('/', array(
		'as'	=> 'publications-all',
		'uses'	=> 'PublicationController@getPublications'
	));

	// For searching publications
	Route::get('/search/{search_query}', array(
		'as'	=> 'publications-route',
		'uses'	=> 'PublicationController@getSearchedPublications'
	))
	->where('search_query', '[A-Za-z0-9\s]+');

	// For filtering
	// Possible parameters to receive: risks, event_types, affected_countries
	// In each one, separate by commas the elements
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

      		return PublicationController::getFilteredPublications($risks, $event_types, $affected_countries);
     	},
	));
});

Route::get('/user/{username}', array(
	'as' => 'profile-user',
	'uses' => 'ProfileController@user'
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

});