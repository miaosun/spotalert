<?php

class EventType extends Eloquent 
{
	protected $fillable   = array('name');
	protected $guarded    = array('id');
	protected $table      = 'eventTypes';
	public    $timestamps = false;

	public function publications()
	{
		return $this->belongsToMany('Publication', 'publications_eventTypes', 'eventType_id', 'publication_id');
	}
}