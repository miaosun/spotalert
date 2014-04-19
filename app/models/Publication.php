<?php

class Publication extends Eloquent 
{
	protected $fillable   = array('initial_date', 'final_date', 'is_public', 'periodic_notification', 'risk', 'type');
	protected $guarded    = array('id');
	protected $table      = 'publications';
	public    $timestamps = false;

	public function contents() 
	{
		return $this->hasMany('PublicationContent');
	}

	public function comments()
	{
		return $this->hasMany('Comment');
	}

	public function eventTypes()
	{
		return $this->belongsToMany('EventType', 'publications_eventTypes', 'publication_id', 'eventType_id');
	}

	public function affectedCountries()
	{
		return $this->belongsToMany('Country', 'publications_countries', 'publication_id', 'country_id');
	}

	public function guidelines()
	{
		return $this->belongsToMany('Publication', 'alerts_guidelines', 'alert_id', 'guideline_id');
	}

	public function alerts()
	{
		return $this->belongsToMany('Publication', 'alerts_guidelines', 'guideline_id', 'alert_id');
	}
}