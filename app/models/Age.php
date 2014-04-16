<?php

class Age extends Eloquent 
{
	protected $fillable   = array('stepname');
	protected $guarded    = array('id');
	protected $table      = 'ages';
	public    $timestamps = false;

	public function users()
	{
		return $this->hasMany('User');
	}
}