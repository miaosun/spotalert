<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    protected $fillable   = array('username', 'firstname', 'lastname', 'email', 'password', 'password_temp', 'periodic_notification',
                                     'code', 'created_at', 'phonenumber', 'address', 'postalCode', 'city', 'type',
                                     'age_id', 'residence_country_id', 'nationality_country_id', 'organization');
    protected $guarded    = array('id', 'facebookId', 'googleId', 'activated', 'supervisor_id');
    protected $table      = 'users';
    public    $timestamps = false;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    public function getId()
    {
        return $this->id;
    }

	public function age()

	{
		return $this->belongsTo('Age','age_id');
	}

    public function getOrganization()
    {
        return $this->organization;
    }

	public function residence()
	{
		return $this->belongsTo('Country','residence_country_id');
	}

	public function nationality()
	{
		return $this->belongsTo('Country','nationality_country_id');
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

	public function publicationNotifications()
	{
		return $this->belongsToMany('Publication', 'users_publications', 'user_id', 'publication_id');
	}

	public function getRememberToken()
	{
	    return $this->remember_token;
	}

	public function setRememberToken($value)
	{
	    $this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
	    return 'remember_token';
	}
}


