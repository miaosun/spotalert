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
		// European Countries
        Country::create(array('name' => 'Albania',				'code' => 'AL'));
        Country::create(array('name' => 'Andorra',				'code' => 'AD'));
        Country::create(array('name' => 'Austria',				'code' => 'AT'));
        Country::create(array('name' => 'Belarus',				'code' => 'BY'));
        Country::create(array('name' => 'Belgium',				'code' => 'BE'));
        Country::create(array('name' => 'Bulgaria',				'code' => 'BG'));
        Country::create(array('name' => 'Croatia',				'code' => 'HR'));
        Country::create(array('name' => 'Cyprus',				'code' => 'CY'));
        Country::create(array('name' => 'Czech Republic',		'code' => 'CZ'));
        Country::create(array('name' => 'Denmark',				'code' => 'DK'));
        Country::create(array('name' => 'Estonia',				'code' => 'EE'));
        Country::create(array('name' => 'Faroe Islands',		'code' => 'FO'));
        Country::create(array('name' => 'Finland',				'code' => 'FI'));
        Country::create(array('name' => 'Germany',				'code' => 'DE'));
        Country::create(array('name' => 'Gibraltar',			'code' => 'GI'));
        Country::create(array('name' => 'Greece',				'code' => 'GR'));
        Country::create(array('name' => 'Hungary',				'code' => 'HU'));
        Country::create(array('name' => 'Iceland',				'code' => 'IS'));
        Country::create(array('name' => 'Ireland',				'code' => 'IE'));
        Country::create(array('name' => 'Italy',				'code' => 'IT'));
        Country::create(array('name' => 'Latvia',				'code' => 'LV'));
        Country::create(array('name' => 'Liechtenstein',		'code' => 'LI'));
        Country::create(array('name' => 'Lithuania',			'code' => 'LT'));
        Country::create(array('name' => 'Luxembourg',			'code' => 'LU'));
        Country::create(array('name' => 'Macedonia',			'code' => 'MK'));
        Country::create(array('name' => 'Malta',				'code' => 'MT'));
        Country::create(array('name' => 'Moldova',				'code' => 'MD'));
        Country::create(array('name' => 'Monaco',				'code' => 'MC'));
        Country::create(array('name' => 'Netherlands',			'code' => 'NL'));
        Country::create(array('name' => 'Norway',				'code' => 'NO'));
        Country::create(array('name' => 'Poland',				'code' => 'PL'));
        Country::create(array('name' => 'Romania',				'code' => 'RO'));
        Country::create(array('name' => 'San Marino',			'code' => 'SM'));
        Country::create(array('name' => 'Serbia',				'code' => 'RS'));
        Country::create(array('name' => 'Slovakia',				'code' => 'SK'));
        Country::create(array('name' => 'Slovenia',				'code' => 'SI'));
        Country::create(array('name' => 'Sweden',				'code' => 'SE'));
        Country::create(array('name' => 'Switzerland',			'code' => 'CH'));
        Country::create(array('name' => 'Ukraine',				'code' => 'UA'));
        Country::create(array('name' => 'Vatican city',			'code' => 'VA'));
        Country::create(array('name' => 'Yugoslavia',			'code' => 'RS'));
        Country::create(array('name' => 'Isle of Man',			'code' => 'IM'));
        Country::create(array('name' => 'Kosovo',				'code' => 'RS'));
        Country::create(array('name' => 'Montenegro',			'code' => 'ME'));
        Country::create(array('name' => 'United Kingdom',		'code' => 'UK'));

        // Countries necessary for publications down in this code
		$portugal = Country::create(array('name' => 'Portugal',          'code' => 'PT'));
		$spain    = Country::create(array('name' => 'Spain',             'code' => 'ES'));
		$bosnia   = Country::create(array('name' => 'Bosnia-Herzegovina','code' => 'BA'));
		$france   = Country::create(array('name' => 'France',            'code' => 'FR'));
		$russia   = Country::create(array('name' => 'Russia',            'code' => 'RU'));

        // ######################################################################
        // Ages
        Age::create(array('stepname' => '10-'));
        Age::create(array('stepname' => '11-20'));
        $age20 = Age::create(array('stepname' => '21-30'));
        $age30 = Age::create(array('stepname' => '31-40'));
        Age::create(array('stepname' => '41-50'));
        Age::create(array('stepname' => '51-60'));
        Age::create(array('stepname' => '61-70'));
        Age::create(array('stepname' => '71-80'));
        Age::create(array('stepname' => '81-90'));
        $age90 = Age::create(array('stepname' => '91+'));

		// ######################################################################

        // Users
        User::create(array('username' => 'admin1',       'firstname' => 'Admin',    'lastname' => 'Silva', 'email' => 'admin@spotalert.com',  'password' => Hash::make('111111'), 'password_temp' => '', 'code' => '', 'created_at' => '2014-05-15', 'phonenumber' => 915283154, 'address' => 'Address 1', 'postalCode' => '4200-000', 'city' => 'Porto', 'activated' => 'true',  'type' => 'admin',       'age_id' =>$age20->id, 'residence_country_id' => $portugal->id, 'nationality_country_id' => $portugal->id ));
        User::create(array('username' => 'manager1',    'firstname' => 'Manager',   'lastname' => 'Silva', 'email' => 'manager@spotalert.com', 'password' => Hash::make('222222'), 'password_temp' => '', 'code' => '', 'created_at' => '2014-05-15', 'phonenumber' => 912345678, 'address' => 'Address 2', 'postalCode' => '4900-000', 'city' => 'Lisboa', 'activated' => 'true', 'type' => 'manager',    'age_id' =>$age30->id, 'residence_country_id' => $portugal->id, 'nationality_country_id' =>  $portugal->id ));
        User::create(array('username' => 'publisher1',  'firstname' => 'Publisher', 'lastname' => 'Silva', 'email' => 'publisher@spotalert.com', 'password' => Hash::make('333333'), 'password_temp' => '', 'code' => '', 'created_at' => '2014-05-15', 'phonenumber' => 918765432, 'address' => 'Address 3', 'postalCode' => '4100-000', 'city' => 'Aveiro', 'activated' => 'true', 'type' => 'publisher',  'age_id' =>$age20->id, 'residence_country_id' => $spain->id, 'nationality_country_id' => $spain->id ));
        User::create(array('username' => 'normal1',     'firstname' => 'Normal',    'lastname' => 'Silva', 'email' => 'normal@spotalert.com', 'password' => Hash::make('444444'), 'password_temp' => '', 'code' => '', 'created_at' => '2014-05-15', 'phonenumber' => 915821654, 'address' => 'Address 4', 'postalCode' => '4500-000', 'city' => 'Coimbra',  'activated' => 'true','type' => 'normal',    'age_id' =>$age30->id, 'residence_country_id' => $france->id, 'nationality_country_id' => $spain->id ));
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

		// Fourth publication
		$publication4 = Publication::create(array(
			'initial_date'	=> '2014-03-23',
			'final_date'	=> '2014-06-30',
			'is_public'		=> true,
			'risk'			=> 5,
			'type'			=> 'alert'
		));

		$content4EN = PublicationContent::create(array(
			'title'			=> 'Solar Storm in Spain',
			'content'		=> 'There\'s going to be a high solar intensity during the next 2 weeks mainly in Asturias and Cadiz',
			'publication_id'=> $publication4->id,
			'language_id'	=> $langEN->id
		));

		// Fifth publication
		$publication5 = Publication::create(array(
			'initial_date'	=> '2014-03-23',
			'final_date'	=> '2014-06-30',
			'is_public'		=> true,
			'risk'			=> 4,
			'type'			=> 'alert'
		));

		$content5EN = PublicationContent::create(array(
			'title'			=> 'Earthquake in Lyon, France.',
			'content'		=> 'A 3.5 scale earthquake has occurred in Lyon at 2:22 pm, replicas might occur during the following hours.',
			'publication_id'=> $publication5->id,
			'language_id'	=> $langEN->id
		));

		// Sixth publication
		$publication6 = Publication::create(array(
			'initial_date'	=> '2014-03-23',
			'final_date'	=> '2014-06-30',
			'is_public'		=> true,
			'risk'			=> 2,
			'type'			=> 'alert'
		));

		$content6EN = PublicationContent::create(array(
			'title'			=> 'Riots in Peckham, England.',
			'content'		=> 'The city of Peckham has been place of hostile civil riots against the police force. Avoid crossing this city.',
			'publication_id'=> $publication6->id,
			'language_id'	=> $langEN->id
		));

		// Seventh publication
		$publication7 = Publication::create(array(
			'initial_date'	=> '2014-03-23',
			'final_date'	=> '2014-06-30',
			'is_public' 	=> true,
			'risk'			=> 2,
			'type'			=> 'guideline'
		));

		$content7EN = PublicationContent::create(array(
			'title'			=> 'How to handle high temperatures',
			'content'		=> 'Use solar protection factor 50 if you\'re exposed to the sun and drink 2,5 liters of water per day. ',
			'publication_id'=> $publication7->id,
			'language_id'	=> $langEN->id
		));


		// Linking publications
		$publication1->guidelines()->attach($publication2->id);
		$publication1->eventTypes()->attach($typeClimatic->id);
		$publication1->affectedCountries()->attach($portugal->id);
		
		$publication2->eventTypes()->attach($typeSocial->id);
		$publication2->affectedCountries()->attach($spain->id);
		$publication2->affectedCountries()->attach($bosnia->id);
		
		$publication3->eventTypes()->attach($typeClimatic->id);
		$publication3->eventTypes()->attach($typeSocial->id);
		$publication3->affectedCountries()->attach($portugal->id);
		$publication3->affectedCountries()->attach($spain->id);
		$publication3->affectedCountries()->attach($bosnia->id);

		$publication4->eventTypes()->attach($typeClimatic->id);
		$publication4->affectedCountries()->attach($spain->id);

		$publication5->eventTypes()->attach($typeClimatic->id);
		$publication5->affectedCountries()->attach($france->id);

		$publication6->eventTypes()->attach($typeSocial->id);
		$publication6->affectedCountries()->attach($bosnia->id);

		$publication7->eventTypes()->attach($typeSocial->id);
		$publication7->affectedCountries()->attach($russia->id);
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

