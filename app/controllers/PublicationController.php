<?php

class PublicationController extends BaseController
{
	public static function getPublications()
	{
		return Publication::all();
	}

	public function getSearchedPublications($search_text)
	{
		return $search_text;
	}

	public function getFilteredPublications($first, $opt = NULL)
	{

	}
}