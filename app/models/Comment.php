<?php

class Comment extends Eloquent 
{
	protected $fillable   = array('content', 'created_at', 'approved', 'user_id', 'publication_id');
	protected $guarded    = array('id');
	protected $table      = 'comments';
	public    $timestamps = false;

	public function author()
	{
		return $this->belongsTo('User', 'user_id');
	}

	public function publication()
	{
		return $this->belongsTo('Publication', 'publication_id');
	}
}