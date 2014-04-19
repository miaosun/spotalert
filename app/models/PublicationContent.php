<?php

class PublicationContent extends Eloquent 
{
	protected $fillable   = array('title', 'content', 'language_id', 'publication_id');
	protected $guarded    = array('id');
	protected $table      = 'publicationContents';
	public    $timestamps = false;

	public function language()
	{
		return $this->belongsTo('Language');
	}

	public function publication()
	{
		return $this->belongsTo('Publication');
	}
}