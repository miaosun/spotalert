<?php

class PublicationController extends BaseController
{
	public static function getPublications()
	{
		return Publication::all();
	}

}