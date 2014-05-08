<?php

class Eyewitness extends Eloquent 
{
	protected $fillable   = array('title', 'description', 'created_at', 'user_id');
	protected $guarded    = array('id');
	protected $table      = 'eyewitnesses';
	public    $timestamps = false;

	public function countries()
	{
		return $this->belongsToMany('Country', 'eyewitnesses_countries', 'eyewitness_id', 'country_id');
	}

	public function publication()
	{
		return $this->belongsTo('User');
	}
}