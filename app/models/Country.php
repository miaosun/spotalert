<?php

class Country extends Eloquent 
{
	protected $fillable   = array('name', 'code');
	protected $guarded    = array('id');
	protected $table      = 'countries';
	public    $timestamps = false;

	public function eyeWitnesses()
	{
		return $this->belongsToMany('EyeWitness', 'eyewitnesses_countries', 'country_id', 'eyewitness_id');
	}

	public function publications()
	{
		return $this->belongsToMany('Publication', 'publications_countries', 'country_id', 'publication_id');
	}

	public function notifications()
	{
		return $this->hasMany('NotificationSetting');
	}

	public function usersResidence()
	{
		return $this->hasMany('User', 'residence_country_id');
	}

	public function usersNacionality()
	{
		return $this->hasMany('User', 'nacionality_country_id');
	}
}