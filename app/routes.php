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
// single publication
Route::get('/{id}', array(
		'as'	=> 'publication-solo',
        'uses' =>'PublicationController@getPublication'
	))
    ->where('id', '[0-9]+');
/*TODO filter by publ title also */

Route::get('/contact', array(
    'as' => 'contact',
    'uses' => 'HomeController@showContact'
));

Route::post('/contact', array(
    'as' => 'send-contact',
    'uses' => 'HomeController@sendContact'
));

// Eyewitness page
Route::get('/eyewitness', array(
    'as' => 'eyewitness',
    'uses' => 'EyewitnessController@showEyewitnessCreation'
));

Route::group(array('prefix' => 'publications'), function()
{
    // For removing publication, it just removes
    Route::post('/delete/{publ_id}', array(
        'before' => 'auth.not_normal',
        'as'     => 'publication-delete',
        'uses'   => 'PublicationController@deletePublication'
    ))
    ->where('publ_id', '[0-9]+');

    // For the RSS feed, it returns a JSON object
    Route::get('/rss', array(
        'as'    => 'publications-rss',
        function() 
        {
            $publications = PublicationController::getAllPublications();
            $contents = View::make('rss')->with('all_publications',$publications);
            return Response::make($contents)->header('Content-Type', 'application/xml');
        }
    ));

    // For searching publications, it returns the the view
    //  specific for the publications
    Route::get('/search/{search_query}/{next_page?}', array(
        'as'   => 'publications-route',
        'uses' => 'PublicationController@getSearchedPublications'
    ))
    ->where('search_query', '[A-Za-z0-9\s]+');

    // For filtering
    // Possible parameters to receive: risks, event_types, affected_countries
    // In each one, separate the elements by commas
    // It returns the view specific specific for the publications
    Route::get('/filter/', array(
        'as'   => 'publications-filter',
        'uses' => 'PublicationController@getFilteredPublications'
    ));

    // Returning the next page
    Route::get('/next_page/{next_page}', array(
        'as'   => 'next-page',
        'uses' => 'PublicationController@getNextPage'
    ));
    
    // Load publication content
    Route::get('/content/{publ_id}', array(
		'as'	=> 'publications-content',
		'uses'	=> 'PublicationController@getPublicationExpandableContentByID'
	))
    ->where('publ_id', '[0-9]+');
    
	// For searching publications
	Route::get('/search/{search_query}', array(
		'as'	=> 'publications-route',
		function($search_query)
		{
			$publications = PublicationController::getSearchedPublications($search_query);
      		return View::make('includes.publications')->with('publications', $publications);
		}
	))
    ->where('publ_id', '[0-9]+');
});

        
// show create alert (GET)
Route::get('/publication/create-alert', array(
    'as' => 'publication-create-alert',
    'uses' => 'PublicationController@showCreateAlert'
));

// show create guideline (GET)
Route::get('/publication/create-guideline', array(
    'as' => 'publication-create-guideline',
    'uses' => 'PublicationController@showCreateGuideline'
));

// show edit alert (GET)
Route::get('/publication/edit-alert/{id}', array(
    'as' => 'publication-edit-alert',
    'uses' => 'PublicationController@showEditAlert'
)); 

// show edit guideline (GET)
Route::get('/publication/edit-guideline/{id}', array(
    'as' => 'publication-edit-guideline',
    'uses' => 'PublicationController@showEditGuideline'
));

// show create alert from eyewitness (GET)
Route::post('/publication/eyewit-alert/{id}', array(
    'as' => 'publication-eyewit-alert',
    'uses' => 'PublicationController@showEyewitToAlert'
));

// show create guideline from eyewitness (GET)
Route::post('/publication/eyewit-guideline/{id}', array(
    'as' => 'publication-eyewit-guideline',
    'uses' => 'PublicationController@showEyewitToGuideline'
));

/*
 * API Controle Panel
 */
Route::get('/user/api/ages', array(
    'as' => 'api-ages',
    'uses' => 'UserPanelController@getAges'
));

Route::get('/user/api/countries', array(
    'as' => 'api-countries',
    'uses' => 'UserPanelController@getCountries'
));

Route::get('/user/api/usernames', array(
   'as' => 'api-usernames',
    'uses' => 'UserPanelController@getUsernames'
));

Route::get('/user/api/emails', array(
    'as' => 'api-emails',
    'uses' => 'UserPanelController@getEmails'
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

        // Create Eyewitness (POST)
        Route::post('/create-eyewitness', array(
            'as' => 'create-eyewitness',
            'uses' => 'EyewitnessController@createEyewitness'
        ));

        // Delete Eyewitness
        Route::post('/delete-eyewitness/{eyewit_id}', array(
            'as' => 'delete-eyewitness',
            'before' => 'auth.not_normal',
            'uses' => 'EyewitnessController@deleteEyewitness'
        ))
        ->where('eyewit_id', '[0-9]+');
        
        //Create Alert (POST)
        Route::post('/publication/createalert', array(
            'as' => 'publication-createalert',
            'uses' => 'PublicationController@createAlert'
        ));
        
        //Create Guideline (POST)
        Route::post('/publication/createguideline', array(
            'as' => 'publication-createguideline',
            'uses' => 'PublicationController@createGuideline'
        ));
        
        //Edit Alert (POST)
        Route::post('/publication/editalert', array(
            'as' => 'publication-editalert',
            'uses' => 'PublicationController@updateAlert'
        ));
        
        //Edit Guideline (POST)
        Route::post('/publication/editguideline', array(
            'as' => 'publication-editguideline',
            'uses' => 'PublicationController@updateGuideline'
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

    /* Control Panel */

    Route::get('/user', array(
        'as' => 'control-panel',
        'uses' => 'UserPanelController@show'
    ));

    /* User privileges */
    Route::get('/user/privileges', array(
       'as' => 'user-privileges',
       'uses' => 'UserPanelController@getPrivileges'
    ));

    Route::post('/user/privileges/{username}', array(
        'as' => 'update-privileges',
        'uses' => 'UserPanelController@updatePrivileges'
    ));

    // Delete User
    Route::post('/user/privileges/delete/user', array(
       'as' => 'privileges-delete',
        'uses' => 'UserPanelController@deleteUser'
    ));

    //Notifications
    Route::get('/user/notifications', array(
        'as' => 'user-notifications',
        'uses' => 'UserPanelController@getNotifications'
    ));

    Route::post('/user/notifications/addCountryRisk', array(
        'as' => 'country-risk-notification',
        'uses' => 'UserPanelController@addCountryRisk'
    ));

    Route::post('/user/notifications/addPublication', array(
        'as' => 'publication-notification',
        'uses' => 'UserPanelController@addPublication'
    ));

    Route::get('/user/notifications/deleteNot/{id}', array(
        'as' => 'notification-delete',
        'uses' => 'UserPanelController@deleteNotification'
    ));

    Route::get('/user/notifications/deletePub/{id}', array(
        'as' => 'publication-delete',
        'uses' => 'UserPanelController@deletePublication'
    ));

    //Comments
    Route::get('/user/comments', array(
        'as' => 'user-comments',
        'uses' => 'UserPanelController@getComments'
    ));

    Route::get('/user/comments/approve/{id}', array(
        'as' => 'comment-approved',
        'uses' => 'UserPanelController@approveComment'
    ));

    Route::get('/user/comments/delete/{id}', array(
        'as' => 'comment-deleted',
        'uses' => 'UserPanelController@deleteComment'
    ));
    Route::get('/user/comments/deleteFromHome/{id}', array(
        'as' => 'comment-deleted-home',
        'uses' => 'UserPanelController@deleteCommentFromHome'
    ));
    Route::post('/user/comments/submit/{id}',array(
        'as' => 'insert-comment',
        'uses' => 'UserPanelController@submitComment'
    ))->where('id', '[0-9]+');;

    // Eyewitness Management
    Route::get('/user/eyewitnesses', array(
       'before' => 'auth.not_normal',
       'as' => 'user-eyewitnesses',
       'uses' => 'EyewitnessController@getEyewitnesses'
    ));

    // Publications listing
    Route::get('/user/publications', array(
       'before' => 'auth.not_normal',
       'as' => 'user-publications',
       'uses' => 'UserPanelController@getPublications'
    ));

    // update profile form route
    Route::post('/user/updateprofile', array(
        'as' => 'update-profile',
        'uses' => 'UserPanelController@updateprofile'
    ));
    Route::post('/user/updatepassword', array(
        'as' => 'update-user-password',
        'uses' => 'UserPanelController@updatepassword'
    ));
    
    Route::post('/deleteimage/{pub}/{img}', array(
        'as' => 'deleteimage',
        function($pub,$img)
        {                File::delete(public_path()."/assets/images/publications/".$pub."/".$img);
        }
    ));
    
    Route::post('/deleteimagew/{eye}/{img}', array(
        'as' => 'deleteimagew',
        function($eye,$img)
        {                       File::delete(public_path()."/assets/images/eyewitnesses".$eye."/".$img);
        }
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

});