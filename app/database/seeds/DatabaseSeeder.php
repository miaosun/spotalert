<?php

class DatabaseSeeder extends Seeder 
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('PublicationsSeeder');
		$this->command->info('Publications seeds finished.');

		//TODO: More seeds as it is necessary here
	}
}

class PublicationsSeeder extends Seeder 
{
	
	public function run() 
	{
		$this->clearDatabase();

		// ######################################################################
		// English and portuguese languages
		$langEN = Language::create(array(
			'name'	=> 'English',
			'code'	=> 'EN'
		));

		$langPT = Language::create(array(
			'name'	=> 'Português',
			'code'	=> 'PT'
		));

		// ######################################################################
		// Countries
		$portugal = Country::create(array(
			'name'	=> 'Portugal',
			'code'	=>	'PT'
		));

		$spain = Country::create(array(
			'name'	=> 'Spain',
			'code'	=>	'ES'
		));

		$uk = Country::create(array(
			'name'	=> 'United Kingdom',
			'code'	=>	'UK'
		));

		// ######################################################################
		// Event Types

		$typeClimatic = EventType::create(array(
			'name' => 'Climatic'
		));

		$typeSocial = EventType::create(array(
			'name' => 'Social'
		));

		// ######################################################################
		// First publication
		$publication1 = Publication::create(array(
			'initial_date'	=> NULL,
			'final_date'	=> '2014-03-30',
			'is_public'		=> true,
			'risk'			=> 4,
			'type'			=> 'alert'
		));

		$content1EN = PublicationContent::create(array(
			'title'			=> 'Hurricane in Portugal',
			'content'		=> 'Be careful about this Hurricane, stay at home!',
			'publication_id'=> $publication1->id,
			'language_id'	=> $langEN->id
		));

		$content1PT = PublicationContent::create(array(
			'title'			=> 'Tornado em Portugal',
			'content'		=> 'Cuidado com este tornado, fique em casa!',
			'publication_id'=> $publication1->id,
			'language_id'	=> $langPT->id
		));

		// Second publication
		$publication2 = Publication::create(array(
			'initial_date'	=> '2014-03-23',
			'final_date'	=> NULL,
			'is_public'		=> true,
			'risk'			=> 4,
			'type'			=> 'guideline'
		));

		$content2EN = PublicationContent::create(array(
			'title'			=> 'What to do with hurricanes',
			'content'		=> 'Just stay at home with the radio connected!',
			'publication_id'=> $publication2->id,
			'language_id'	=> $langEN->id
		));

		$content2PT = PublicationContent::create(array(
			'title'			=> 'O que fazer com os tornados',
			'content'		=> 'Apenas fique em casa com o rádio ligado',
			'publication_id'=> $publication2->id,
			'language_id'	=> $langPT->id
		));

		// Third publication
		$publication3 = Publication::create(array(
			'initial_date'	=> '2014-03-23',
			'final_date'	=> '2014-07-30',
			'is_public'		=> true,
			'risk'			=> 1,
			'type'			=> 'guideline'
		));

		$content3EN = PublicationContent::create(array(
			'title'			=> 'What to do with some disease',
			'content'		=> 'There are several ways to treat diseases, but <b>the best way is to go to a doctor</b>!',
			'publication_id'=> $publication3->id,
			'language_id'	=> $langEN->id
		));

		// Linking publications
		$publication1->guidelines()->attach($publication2->id);
		$publication1->eventTypes()->attach($typeClimatic->id);
		$publication1->affectedCountries()->attach($portugal->id);
		
		$publication2->eventTypes()->attach($typeSocial->id);
		$publication2->affectedCountries()->attach($spain->id);
		$publication2->affectedCountries()->attach($uk->id);
		
		$publication3->eventTypes()->attach($typeClimatic->id);
		$publication3->eventTypes()->attach($typeSocial->id);
		$publication3->affectedCountries()->attach($portugal->id);
		$publication3->affectedCountries()->attach($spain->id);
		$publication3->affectedCountries()->attach($uk->id);
	}

	public function clearDatabase()
	{
		DB::table('publications')->delete();
		DB::table('languages')->delete();
		DB::table('publicationContents')->delete();
		DB::table('eventTypes')->delete();
		DB::table('publications_eventTypes')->delete();
		DB::table('countries')->delete();
		DB::table('publications_countries')->delete();
		DB::table('alerts_guidelines')->delete();
		DB::table('ages')->delete();
		DB::table('users')->delete();
		DB::table('comments')->delete();
		DB::table('eyewitnesses')->delete();
		DB::table('eyewitnesses_countries')->delete();
		DB::table('notificationSettings')->delete();
	}
}