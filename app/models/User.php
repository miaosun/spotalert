<?php

class User extends Eloquent 
{
	protected $fillable   = array('username', 'firstname', 'lastname', 'email', 'password',
								  'phonenumber', 'address', 'postalCode', 'city', 'type',
								  'age_id', 'residence_country_id', 'nacionality_country_id');
	protected $guarded    = array('id', 'facebookId', 'googleId', 'organization', 
								  'activated', 'supervisor_id');
	protected $table      = 'users';
	public    $timestamps = false;

	public function age()
	{
		return $this->belongsTo('Age','age_id');
	}

	public function residence()
	{
		return $this->belongsTo('Country','residence_country_id');
	}

	public function nacionality()
	{
		return $this->belongsTo('Country','nacionality_country_id');
	}

	public function notifications()
	{
		return $this->hasMany('NotificationSetting');
	}

	public function eyeWitnesses()
	{
		return $this->hasMany('Eyewitness');
	}

	public function supervisor()
	{ 
		return $this->belongsTo('User', 'supervisor_id');
	}

	public function supervised()
	{
		return $this->hasMany('User', 'supervisor_id');
	}
}