<?php

class Eyewitness extends Eloquent 
{
	protected $fillable   = array('title', 'description', 'created_at', 'user_id', 'language_id');
	protected $guarded    = array('id');
	protected $table      = 'eyewitnesses';
	public    $timestamps = false;

	public function countries()
	{
		return $this->belongsToMany('Country', 'eyewitnesses_countries', 'eyewitness_id', 'country_id');
	}

	public function author()
	{
		return $this->belongsTo('User', 'user_id');
	}

	public function language()
	{
		return $this->belongsTo('Language', 'language_id');
	}
}