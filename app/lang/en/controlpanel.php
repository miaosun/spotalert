<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| User Control Panel Language Strings
	|--------------------------------------------------------------------------
	|
	| The following language lines contain all strings used in countrol panel view
	|
	*/
	"menu" => array(
		"profile"      => "PROFILE",
		"notification" => "NOTIFICATIONS",
		"publications" => "PUBLICATIONS",
		"comments"     => "MANAGE COMMENTS",
		"privileges"   => "PRIVILEGES",
		"eyewitnesses" => "MANAGE EYEWITNESSES"
	),
	"profile" => array(
		"title"    => "USER CONTROL PANEL - PROFILE",
		"addpic"   => "ADD PROFILE PICTURE",
		"altpic"   => "Default user Picture",
		"password" => array(
			"title"   => "CHANGE PASSWORD",
			"new"     => "NEW PASSWORD",
			"confirm" => "CONFIRM PASSWORD"
			),
		"username"     => "USERNAME",
		"name"         => "NAME",
		"residence"    => "RESIDENCE",
		"nationality"  => "NATIONALITY",
		"agerange"     => "AGE RANGE",
		"email"        => "EMAIL",
		"phone"        => "PHONE NUMBER",
		"address"      => "ADDRESS",
		"date"         => "MEMBER SINCE",
		"organization" => "ORGANIZATION",
		"okbutton"     => "OK"
	),

    "privileges" => array(
        "title"          => "USER CONTROL PANEL - PRIVILEGES",
        "add_publishers" => "ADD PUBLISHERS",
        "managers"       => "MANAGERS",
        "department"     => "DEPARTMENT",
        "name"           => "USERNAME",
        "type"           => "TYPE",
        "location"       => "LOCATION",
        "member_since"   => "MEMBER SINCE",
        "add"            => "ADD",
        "email"          => "EMAIL",
        "permissions"    => "PERMISSIONS",
        "remove"         => "REMOVE",
        "deleteuser"     => "DELETE USER",
        "warning"        => "Every information such as publications and comments of that user will be deleted as well!!!",
        "cancel"         => "Cancel",
        "confirm"        => "Yes I am"
    ),
	"publications" => array(
		"title"              => "USER CONTROL PANEL - PUBLICATIONS",
		"publication"        => "PUBLICATION",
		"author"             => "AUTHOR",
		"affected_countries" => "AFFECTED COUNTRIES",
		"initial_date"       => "INITIAL DATE",
		"final_date"         => "FINAL DATE",
		"risk"               => "RISK"
	),

    "notifications" => array(
        "title"          => "USER CONTROL PANEL - NOTIFICATIONS",
        "select"         => "SELECT",
        "country_option" => "COUNTRY",
        "minimum_risk"   => "MINIMUM RISK",
        "add"            => "ADD",
        "publication"    => "PUBLICATION"
    ),

    "comments" => array(
        "title"       => "USER CONTROL PANEL - MANAGE COMMENTS",
        "publication" => "PUBLICATION",
        "comment"     => "COMMENT",
        "name"        => "NAME",
        "date"        => "DATE",
        "risk"        => "RISK",
        "readmore"    => "Read More",
        "readless"    => "Read Less",
        "submit_msg"  => array(
            "success"       => "Comment submited with success and waiting to be approve!",
            "fail"          => "Comment submited without success! Try again later or contact admin.",
            "fail_img"      => "Comment submited without success! Image you try to submit isn't supported.",
            "bad_format"    => "Bad Format or you don't have permitions to submit new comments. Try Again or contact admin!"
        ),
        "delete"    => "DELETE COMMENT"
    ),

    "eyewitnesses" => array(
    	"title"              => "USER CONTROL PANEL - MANAGE EYEWITNESSES",
    	"title2"             => "TITLE",
    	"description"        =>"DESCRIPTION",
    	"created_at"         => "CREATED AT",
    	"author"             => "AUTHOR",
    	"language"           => "LANGUAGE",
    	"affected_countries" => "AFFECTED COUNTRIES"
    )
);
