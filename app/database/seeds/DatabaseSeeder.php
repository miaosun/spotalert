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
        $admin = User::create(array('username' => 'admin1',       'firstname' => 'Admin',    'lastname' => 'Silva', 'email' => 'admin@spotalert.com',  'password' => Hash::make('111111'), 'password_temp' => '', 'code' => '', 'created_at' => '2014-05-15', 'phonenumber' => 915283154, 'address' => 'Address 1', 'postalCode' => '4200-000', 'city' => 'Porto', 'activated' => 'true',  'type' => 'admin',       'age_id' =>$age20->id, 'residence_country_id' => $portugal->id, 'nationality_country_id' => $portugal->id ));
        $manager = User::create(array('username' => 'manager1',    'firstname' => 'Manager',   'lastname' => 'Silva', 'email' => 'manager@spotalert.com', 'password' => Hash::make('222222'), 'password_temp' => '', 'code' => '', 'created_at' => '2014-05-15', 'phonenumber' => 912345678, 'address' => 'Address 2', 'postalCode' => '4900-000', 'city' => 'Lisboa', 'activated' => 'true', 'type' => 'manager',    'age_id' =>$age30->id, 'residence_country_id' => $portugal->id, 'nationality_country_id' =>  $portugal->id ));
        $publisher = User::create(array('username' => 'publisher1',  'firstname' => 'Publisher', 'lastname' => 'Silva', 'email' => 'publisher@spotalert.com', 'password' => Hash::make('333333'), 'password_temp' => '', 'code' => '', 'created_at' => '2014-05-15', 'phonenumber' => 918765432, 'address' => 'Address 3', 'postalCode' => '4100-000', 'city' => 'Aveiro', 'activated' => 'true', 'type' => 'publisher',  'age_id' =>$age20->id, 'residence_country_id' => $spain->id, 'nationality_country_id' => $spain->id ));
        $normal = User::create(array('username' => 'normal1',     'firstname' => 'Normal',    'lastname' => 'Silva', 'email' => 'normal@spotalert.com', 'password' => Hash::make('444444'), 'password_temp' => '', 'code' => '', 'created_at' => '2014-05-15', 'phonenumber' => 915821654, 'address' => 'Address 4', 'postalCode' => '4500-000', 'city' => 'Coimbra',  'activated' => 'true','type' => 'normal',    'age_id' =>$age30->id, 'residence_country_id' => $france->id, 'nationality_country_id' => $spain->id ));
        // ######################################################################

		// Event Types
		$typeClimatic = EventType::create(array(
			'name' => 'Climatic'
		));

		$typeSocial = EventType::create(array(
			'name' => 'Social'
		));

		// ######################################################################
		// ***************
		$publication1 = Publication::create(array(
			'initial_date'	=> NULL,
			'final_date'	=> '2014-03-30',
			'is_public'		=> true,
			'risk'			=> 4,
			'type'			=> 'alert',
			'user_id'       => $admin->id
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

		$publication1->eventTypes()->attach($typeClimatic->id);
		$publication1->affectedCountries()->attach($portugal->id);

		// ***************
		$publication2 = Publication::create(array(
			'initial_date'	=> '2014-03-23',
			'final_date'	=> NULL,
			'is_public'		=> true,
			'risk'			=> 4,
			'type'			=> 'guideline',
			'user_id'       => $admin->id
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

		$publication2->affectedCountries()->attach($spain->id);
		$publication2->affectedCountries()->attach($bosnia->id);
		$publication2->eventTypes()->attach($typeSocial->id);

		// ***************
		$publication3 = Publication::create(array(
			'initial_date'	=> '2014-03-23',
			'final_date'	=> '2014-07-30',
			'is_public'		=> true,
			'risk'			=> 1,
			'type'			=> 'guideline',
			'user_id'       => $admin->id
		));

		$content3EN = PublicationContent::create(array(
			'title'			=> 'What to do with some disease',
			'content'		=> 'There are several ways to treat diseases, but <b>the best way is to go to a doctor</b>!',
			'publication_id'=> $publication3->id,
			'language_id'	=> $langEN->id
		));

		$publication3->eventTypes()->attach($typeClimatic->id);
		$publication3->eventTypes()->attach($typeSocial->id);
		$publication3->affectedCountries()->attach($portugal->id);
		$publication3->affectedCountries()->attach($spain->id);
		$publication3->affectedCountries()->attach($bosnia->id);

		// ***************
		$publication4 = Publication::create(array(
			'initial_date'	=> '2014-03-23',
			'final_date'	=> '2014-06-30',
			'is_public'		=> true,
			'risk'			=> 5,
			'type'			=> 'alert',
			'user_id'       => $admin->id
		));

		$content4EN = PublicationContent::create(array(
			'title'			=> 'Solar Storm in Spain',
			'content'		=> 'There\'s going to be a high solar intensity during the next 2 weeks mainly in Asturias and Cadiz',
			'publication_id'=> $publication4->id,
			'language_id'	=> $langEN->id
		));

		$publication4->eventTypes()->attach($typeClimatic->id);
		$publication4->affectedCountries()->attach($spain->id);

		// ***************
		$publication5 = Publication::create(array(
			'initial_date'	=> '2014-03-23',
			'final_date'	=> '2014-06-30',
			'is_public'		=> true,
			'risk'			=> 4,
			'type'			=> 'alert',
			'user_id'       => $admin->id
		));

		$content5EN = PublicationContent::create(array(
			'title'			=> 'Earthquake in Lyon, France.',
			'content'		=> 'A 3.5 scale earthquake has occurred in Lyon at 2:22 pm, replicas might occur during the following hours.',
			'publication_id'=> $publication5->id,
			'language_id'	=> $langEN->id
		));

		$publication5->eventTypes()->attach($typeClimatic->id);
		$publication5->affectedCountries()->attach($france->id);

		// ***************
		$publication6 = Publication::create(array(
			'initial_date'	=> '2014-03-23',
			'final_date'	=> '2014-06-30',
			'is_public'		=> true,
			'risk'			=> 2,
			'type'			=> 'alert',
			'user_id'       => $admin->id
		));

		$content6EN = PublicationContent::create(array(
			'title'			=> 'Riots in Peckham, England.',
			'content'		=> 'The city of Peckham has been place of hostile civil riots against the police force. Avoid crossing this city.',
			'publication_id'=> $publication6->id,
			'language_id'	=> $langEN->id
		));

		$publication6->eventTypes()->attach($typeSocial->id);
		$publication6->affectedCountries()->attach($bosnia->id);

		// ***************
		$publication7 = Publication::create(array(
			'initial_date'	=> '2014-03-23',
			'final_date'	=> '2014-06-30',
			'is_public' 	=> true,
			'risk'			=> 2,
			'type'			=> 'guideline',
			'user_id'       => $admin->id
		));

		$content7EN = PublicationContent::create(array(
			'title'			=> 'How to handle high temperatures',
			'content'		=> 'Use solar protection factor 50 if you\'re exposed to the sun and drink 2,5 liters of water per day. ',
			'publication_id'=> $publication7->id,
			'language_id'	=> $langEN->id
		));

		$publication7->eventTypes()->attach($typeSocial->id);
		$publication7->affectedCountries()->attach($russia->id);

		// ***************
		$publication8 = Publication::create(array(
			'initial_date'	=> '2014-03-02',
			'final_date'	=> '2014-06-01',
			'is_public'		=> true,
			'risk'			=> 5,
			'type'			=> 'alert',
			'user_id'       => $admin->id
		));

		$content8EN = PublicationContent::create(array(
			'title'			=> 'Hurricane in Portugal',
			'content'		=> 'Be careful about this Hurricane, stay at home!',
			'publication_id'=> $publication8->id,
			'language_id'	=> $langEN->id
		));

		$publication8->eventTypes()->attach($typeClimatic->id);
		$publication8->affectedCountries()->attach($portugal->id);
		$publication8->affectedCountries()->attach($bosnia->id);
		
		// ***************
		$publication9 = Publication::create(array(
			'initial_date'	=> '2014-03-04',
			'final_date'	=> '2014-06-05',
			'is_public'		=> true,
			'risk'			=> 1,
			'type'			=> 'guideline',
			'user_id'       => $admin->id
		));

		$content9EN = PublicationContent::create(array(
			'title'			=> 'Strong wind in Portugal',
			'content'		=> 'Be careful about this strong wind, stay at home!',
			'publication_id'=> $publication9->id,
			'language_id'	=> $langEN->id
		));

		$publication9->eventTypes()->attach($typeClimatic->id);
		$publication9->affectedCountries()->attach($spain->id);
		$publication9->affectedCountries()->attach($france->id);
		
		// ***************
		$publication10 = Publication::create(array(
			'initial_date'	=> '2014-03-08',
			'final_date'	=> '2014-05-12',
			'is_public'		=> true,
			'risk'			=> 2,
			'type'			=> 'guideline',
			'user_id'       => $admin->id
		));

		$content10EN = PublicationContent::create(array(
			'title'			=> 'Heavy rain in Portugal',
			'content'		=> 'Be careful about this heavy rain, stay at home!',
			'publication_id'=> $publication10->id,
			'language_id'	=> $langEN->id
		));

		$publication10->eventTypes()->attach($typeClimatic->id);
		$publication10->affectedCountries()->attach($spain->id);
		$publication10->affectedCountries()->attach($france->id);
		
		// ***************
		$publication11 = Publication::create(array(
			'initial_date'	=> '2014-03-12',
			'final_date'	=> '2014-05-30',
			'is_public'		=> true,
			'risk'			=> 3,
			'type'			=> 'alert',
			'user_id'       => $admin->id
		));

		$content11EN = PublicationContent::create(array(
			'title'			=> 'storm in Portugal',
			'content'		=> 'Be careful about this storm, stay at home!',
			'publication_id'=> $publication11->id,
			'language_id'	=> $langEN->id
		));

		$publication11->eventTypes()->attach($typeClimatic->id);
		$publication11->affectedCountries()->attach($spain->id);
		$publication11->affectedCountries()->attach($russia->id);
		
		// ***************
		$publication12 = Publication::create(array(
			'initial_date'	=> '2014-03-18',
			'final_date'	=> '2014-03-22',
			'is_public'		=> true,
			'risk'			=> 4,
			'type'			=> 'alert',
			'user_id'       => $admin->id
		));

		$content12EN = PublicationContent::create(array(
			'title'			=> 'Rain storm in Portugal',
			'content'		=> 'Be careful about this rain storm, stay at home!',
			'publication_id'=> $publication12->id,
			'language_id'	=> $langEN->id
		));

		$publication12->eventTypes()->attach($typeClimatic->id);
		$publication12->affectedCountries()->attach($france->id);
		$publication12->affectedCountries()->attach($russia->id);
		$publication12->affectedCountries()->attach($spain->id);
		
		// ***************
		$publication13 = Publication::create(array(
			'initial_date'	=> '2014-04-15',
			'final_date'	=> '2014-04-22',
			'is_public'		=> true,
			'risk'			=> 5,
			'type'			=> 'alert',
			'user_id'       => $admin->id
		));

		$content13EN = PublicationContent::create(array(
			'title'			=> 'H1N1 in Portugal',
			'content'		=> 'Be careful with H1N1, stay at home and wear mask!',
			'publication_id'=> $publication13->id,
			'language_id'	=> $langEN->id
		));

		$publication13->eventTypes()->attach($typeSocial->id);
		$publication13->affectedCountries()->attach($france->id);
		$publication13->affectedCountries()->attach($russia->id);
		$publication13->affectedCountries()->attach($bosnia->id);
		
		// ***************
		$publication14 = Publication::create(array(
			'initial_date'	=> '2014-01-18',
			'final_date'	=> '2014-01-25',
			'is_public'		=> true,
			'risk'			=> 4,
			'type'			=> 'alert',
			'user_id'       => $admin->id
		));

		$content14EN = PublicationContent::create(array(
			'title'			=> 'Storm snow in Portugal',
			'content'		=> 'Be careful with this strom snow, stay at home!',
			'publication_id'=> $publication14->id,
			'language_id'	=> $langEN->id
		));

		$publication14->eventTypes()->attach($typeClimatic->id);
		$publication14->affectedCountries()->attach($france->id);
		$publication14->affectedCountries()->attach($russia->id);

		// ***************
		$publication15 = Publication::create(array(
			'initial_date'	=> '2014-02-18',
			'final_date'	=> '2014-03-17',
			'is_public'		=> true,
			'risk'			=> 2,
			'type'			=> 'guideline',
			'user_id'       => $admin->id
		));

		$content15EN = PublicationContent::create(array(
			'title'			=> 'Rain in Portugal',
			'content'		=> 'Be careful with rain, take umbrella with you!',
			'publication_id'=> $publication15->id,
			'language_id'	=> $langEN->id
		));

		$publication15->eventTypes()->attach($typeClimatic->id);
		$publication15->affectedCountries()->attach($france->id);
		$publication15->affectedCountries()->attach($spain->id);
		
		// ***************
		$publication16 = Publication::create(array(
			'initial_date'	=> '2014-02-18',
			'final_date'	=> '2014-02-17',
			'is_public'		=> true,
			'risk'			=> 4,
			'type'			=> 'alert',
			'user_id'       => $admin->id
		));

		$content16EN = PublicationContent::create(array(
			'title'			=> 'Ice rain in Portugal',
			'content'		=> 'Be careful with ice rain, stay at home!',
			'publication_id'=> $publication16->id,
			'language_id'	=> $langEN->id
		));

		$publication16->eventTypes()->attach($typeClimatic->id);
		$publication16->affectedCountries()->attach($bosnia->id);
		$publication16->affectedCountries()->attach($spain->id);

		// ***************
		$publication17 = Publication::create(array(
			'initial_date'	=> '2014-03-29',
			'final_date'	=> '2014-03-17',
			'is_public'		=> true,
			'risk'			=> 4,
			'type'			=> 'alert',
			'user_id'       => $admin->id
		));

		$content17EN = PublicationContent::create(array(
			'title'			=> 'Hurricane in Portugal',
			'content'		=> 'Be careful with hurricane, stay at home!',
			'publication_id'=> $publication17->id,
			'language_id'	=> $langEN->id
		));

		$publication17->eventTypes()->attach($typeClimatic->id);
		$publication17->affectedCountries()->attach($bosnia->id);
		$publication17->affectedCountries()->attach($spain->id);
		$publication17->affectedCountries()->attach($russia->id);

		// ***************
		$publication18 = Publication::create(array(
			'initial_date'	=> '2014-03-30',
			'final_date'	=> '2014-04-15',
			'is_public'		=> true,
			'risk'			=> 4,
			'type'			=> 'alert',
			'user_id'       => $admin->id
		));

		$content18EN = PublicationContent::create(array(
			'title'			=> 'Bird flue in Portugal',
			'content'		=> 'Be careful with bird flu, stay at home and wear mask!',
			'publication_id'=> $publication18->id,
			'language_id'	=> $langEN->id
		));

		$publication18->eventTypes()->attach($typeSocial->id);
		$publication18->affectedCountries()->attach($bosnia->id);
		$publication18->affectedCountries()->attach($spain->id);
		$publication18->affectedCountries()->attach($russia->id);

		// ***************
		$publication19 = Publication::create(array(
			'initial_date'	=> '2014-05-18',
			'final_date'	=> '2014-05-19',
			'is_public'		=> true,
			'risk'			=> 5,
			'type'			=> 'alert',
			'user_id'       => $admin->id
		));

		$content19EN = PublicationContent::create(array(
			'title'			=> 'Earthquake in Portugal',
			'content'		=> 'Be careful with Earthquake, find safe place!',
			'publication_id'=> $publication19->id,
			'language_id'	=> $langEN->id
		));

		$publication19->eventTypes()->attach($typeClimatic->id);
		$publication19->affectedCountries()->attach($bosnia->id);
		$publication19->affectedCountries()->attach($spain->id);

		// ***************
		$publication20 = Publication::create(array(
			'initial_date'	=> '2014-01-8',
			'final_date'	=> '2014-01-20',
			'is_public'		=> true,
			'risk'			=> 5,
			'type'			=> 'alert',
			'user_id'       => $admin->id
		));

		$content20EN = PublicationContent::create(array(
			'title'			=> 'Blizzards in Portugal',
			'content'		=> 'Be careful with blizzards, stay at home!',
			'publication_id'=> $publication20->id,
			'language_id'	=> $langEN->id
		));

		$publication20->eventTypes()->attach($typeClimatic->id);
		$publication20->affectedCountries()->attach($russia->id);
		$publication20->affectedCountries()->attach($spain->id);

		// ***************
		$publication21 = Publication::create(array(
			'initial_date'	=> '2014-05-08',
			'final_date'	=> '2014-05-20',
			'is_public'		=> true,
			'risk'			=> 2,
			'type'			=> 'guideline',
			'user_id'       => $admin->id
		));

		$content21EN = PublicationContent::create(array(
			'title'			=> 'Tornados in Portugal',
			'content'		=> 'Be careful with tornados, stay at home and wear mask!',
			'publication_id'=> $publication21->id,
			'language_id'	=> $langEN->id
		));

		$publication21->eventTypes()->attach($typeClimatic->id);
		$publication21->affectedCountries()->attach($russia->id);
		$publication21->affectedCountries()->attach($spain->id);
		$publication21->affectedCountries()->attach($france->id);

		// ***************
		$publication22 = Publication::create(array(
			'initial_date'	=> '2014-05-10',
			'final_date'	=> '2014-05-24',
			'is_public'		=> true,
			'risk'			=> 5,
			'type'			=> 'alert',
			'user_id'       => $admin->id
		));

		$content22EN = PublicationContent::create(array(
			'title'			=> 'Epidemics in Portugal',
			'content'		=> 'Be careful with epidemics, stay at home, wear mask and see doctor if you are sick!',
			'publication_id'=> $publication22->id,
			'language_id'	=> $langEN->id
		));

		$publication22->eventTypes()->attach($typeSocial->id);
		$publication22->affectedCountries()->attach($russia->id);
		$publication22->affectedCountries()->attach($france->id);

		// ***************
		$publication23 = Publication::create(array(
			'initial_date'	=> '2014-05-15',
			'final_date'	=> '2014-05-24',
			'is_public'		=> true,
			'risk'			=> 1,
			'type'			=> 'guideline',
			'user_id'       => $admin->id
		));

		$content23EN = PublicationContent::create(array(
			'title'			=> 'Flower dust in Portugal',
			'content'		=> 'Be careful with flower dust, wear mask!',
			'publication_id'=> $publication23->id,
			'language_id'	=> $langEN->id
		));

		$publication23->eventTypes()->attach($typeClimatic->id);
		$publication23->affectedCountries()->attach($spain->id);
		$publication23->affectedCountries()->attach($france->id);
		
		// ***************
		$publication24 = Publication::create(array(
			'initial_date'	=> '2014-05-15',
			'final_date'	=> '2014-05-24',
			'is_public'		=> true,
			'risk'			=> 1,
			'type'			=> 'guideline',
			'user_id'       => $admin->id
		));

		$content24EN = PublicationContent::create(array(
			'title'			=> 'Storm in Portugal',
			'content'		=> 'Be careful with storm, find a safe place!',
			'publication_id'=> $publication24->id,
			'language_id'	=> $langEN->id
		));

		$publication24->eventTypes()->attach($typeClimatic->id);
		$publication24->affectedCountries()->attach($spain->id);
		$publication24->affectedCountries()->attach($france->id);
		
		// ***************
		$publication25 = Publication::create(array(
			'initial_date'	=> '2014-07-20',
			'final_date'	=> '2014-06-24',
			'is_public'		=> true,
			'risk'			=> 1,
			'type'			=> 'guideline',
			'user_id'       => $admin->id
		));

		$content25EN = PublicationContent::create(array(
			'title'			=> 'Hot weather in Portugal',
			'content'		=> 'Be careful with hot weather!',
			'publication_id'=> $publication25->id,
			'language_id'	=> $langEN->id
		));

		$publication25->eventTypes()->attach($typeClimatic->id);
		$publication25->affectedCountries()->attach($spain->id);
		$publication25->affectedCountries()->attach($france->id);
		$publication25->affectedCountries()->attach($bosnia->id);
		
		// ***************
		$publication26 = Publication::create(array(
			'initial_date'	=> '2014-06-25',
			'final_date'	=> '2014-07-24',
			'is_public'		=> true,
			'risk'			=> 4,
			'type'			=> 'guideline',
			'user_id'       => $admin->id
		));

		$content26EN = PublicationContent::create(array(
			'title'			=> 'Draught in Portugal',
			'content'		=> 'Be careful with draught, stay at safe place!',
			'publication_id'=> $publication26->id,
			'language_id'	=> $langEN->id
		));

		$publication26->eventTypes()->attach($typeClimatic->id);
		$publication26->affectedCountries()->attach($spain->id);
		$publication26->affectedCountries()->attach($russia->id);

		// ***************
		$publication27 = Publication::create(array(
			'initial_date'	=> '2014-08-25',
			'final_date'	=> '2014-11-24',
			'is_public'		=> true,
			'risk'			=> 3,
			'type'			=> 'guideline',
			'user_id'       => $admin->id
		));

		$content27EN = PublicationContent::create(array(
			'title'			=> 'Cold weather in Portugal',
			'content'		=> 'Be careful with cold weather, wear thick clothes!',
			'publication_id'=> $publication27->id,
			'language_id'	=> $langEN->id
		));

		$publication27->eventTypes()->attach($typeClimatic->id);
		$publication27->affectedCountries()->attach($spain->id);
		$publication27->affectedCountries()->attach($france->id);
		$publication27->affectedCountries()->attach($russia->id);
		$publication27->affectedCountries()->attach($bosnia->id);
		
		// Linking publications
		$publication1->guidelines()->attach($publication2->id);
        $publication1->guidelines()->attach($publication3->id);
        $publication2->alerts()->attach($publication4->id);
        $publication2->alerts()->attach($publication6->id);
        $publication7->alerts()->attach($publication5->id);
        $publication7->alerts()->attach($publication6->id);
        
        // Comments
        $comment1 = Comment::create(array(
			'content'	=> 'Meu deus que grande susto!.',
			'created_at' => date("Y-m-d H:i:s"),
			'approved'=> "true",
            'user_id' => $admin->id,
            'publication_id' => $publication2->id
		));
         $comment2 = Comment::create(array(
			'content' => 'Isto provocou um transito tremendo na rua das amoras.',
			'created_at' => date("Y-m-d H:i:s"),
			'approved'=> "true",
            'user_id' => $admin->id,
            'publication_id' => $publication2->id
		));
         $comment3 = Comment::create(array(
			'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur in tortor pretium, pellentesque magna nec, posuere libero. Vestibulum condimentum felis et neque volutpat cursus. Aliquam in tellus mi. Vivamus consectetur.',
			'created_at' => date("Y-m-d H:i:s"),
			'approved'=> "true",
            'user_id' => $publisher->id,
            'publication_id' => $publication2->id
		));
         $comment4 = Comment::create(array(
			'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur in tortor pretium, pellentesque magna nec, posuere libero. Vestibulum condimentum felis et neque volutpat cursus.',
			'created_at' => date("Y-m-d H:i:s"),
			'approved'=> "true",
            'user_id' => $manager->id,
            'publication_id' => $publication4->id
		));
         $comment5 = Comment::create(array(
			'content'	=> 'Consectetur adipiscing elit. Curabitur in tortor pretium, pellentesque magna nec, posuere libero. Vestibulum condimentum felis et neque volutpat cursus.',
			'created_at' => date("Y-m-d H:i:s"),
			'approved'=> "true",
            'user_id' => $normal->id,
            'publication_id' => $publication8->id
		));

        
	}

	public function clearDatabase()
	{
		DB::table('publications')->delete();
		DB::table('languages')->delete();
		DB::table('publicationContents')->delete();
		DB::table('eventTypes')->delete();
		DB::table('publications_eventTypes')->delete();
		DB::table('users')->delete();
		DB::table('countries')->delete();
		DB::table('publications_countries')->delete();
		DB::table('alerts_guidelines')->delete();
		DB::table('ages')->delete();
		DB::table('comments')->delete();
		DB::table('eyewitnesses')->delete();
		DB::table('eyewitnesses_countries')->delete();
		DB::table('notificationSettings')->delete();
	}
}

