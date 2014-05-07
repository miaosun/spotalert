<?php

class Language extends Eloquent 
{
	protected $fillable   = array('name', 'code');
	protected $guarded    = array('id');
	protected $table      = 'languages';
	public    $timestamps = false;

	public function publicationContents()
	{
		return $this->hasMany('PublicationContent');
	}
}
