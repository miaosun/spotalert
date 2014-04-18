<?php

class PublicationController extends BaseController
{
	public function getPublications()
	{
		return Publication::all();
	}

}