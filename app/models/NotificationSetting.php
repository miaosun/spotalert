<?php

class NotificationSetting extends Eloquent 
{
	protected $fillable   = array('risk', 'user_id', 'country_id');
	protected $guarded    = array('id');
	protected $table      = 'notificationSettings';
	public    $timestamps = false;

	public function country()
	{
		return $this->belongsTo('Country');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}
}