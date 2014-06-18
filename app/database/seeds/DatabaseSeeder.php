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
        
        $langES = Language::create(array(
            'name'	=> 'Español',
            'code'	=> 'ES'
        ));
        
        $langFR = Language::create(array(
            'name'	=> 'Français',
            'code'	=> 'FR'
        ));
        
        $langDE = Language::create(array(
            'name'	=> 'Deutsch',
            'code'	=> 'DE'
        ));

        // ######################################################################
		// World Countries
        Country::create(array('code' => 'AF', 'name' => 'Afghanistan'));
		Country::create(array('code' => 'AL', 'name' => 'Albania'));
		Country::create(array('code' => 'DZ', 'name' => 'Algeria'));
		Country::create(array('code' => 'AS', 'name' => 'American Samoa'));
		Country::create(array('code' => 'AD', 'name' => 'Andorra'));
		Country::create(array('code' => 'AO', 'name' => 'Angola'));
		Country::create(array('code' => 'AI', 'name' => 'Anguilla'));
		Country::create(array('code' => 'AQ', 'name' => 'Antarctica'));
		Country::create(array('code' => 'AG', 'name' => 'Antigua and Barbuda'));
		Country::create(array('code' => 'AR', 'name' => 'Argentina'));
		Country::create(array('code' => 'AM', 'name' => 'Armenia'));
		Country::create(array('code' => 'AW', 'name' => 'Aruba'));
		Country::create(array('code' => 'AU', 'name' => 'Australia'));
		Country::create(array('code' => 'AT', 'name' => 'Austria'));
		Country::create(array('code' => 'AZ', 'name' => 'Azerbaijan'));
		Country::create(array('code' => 'BS', 'name' => 'Bahamas'));
		Country::create(array('code' => 'BH', 'name' => 'Bahrain'));
		Country::create(array('code' => 'BD', 'name' => 'Bangladesh'));
		Country::create(array('code' => 'BB', 'name' => 'Barbados'));
		Country::create(array('code' => 'BY', 'name' => 'Belarus'));
		Country::create(array('code' => 'BE', 'name' => 'Belgium'));
		Country::create(array('code' => 'BZ', 'name' => 'Belize'));
		Country::create(array('code' => 'BJ', 'name' => 'Benin'));
		Country::create(array('code' => 'BM', 'name' => 'Bermuda'));
		Country::create(array('code' => 'BT', 'name' => 'Bhutan'));
		Country::create(array('code' => 'BO', 'name' => 'Bolivia'));
		$bosnia = Country::create(array('code' => 'BA', 'name' => 'Bosnia-Herzegovina'));
		Country::create(array('code' => 'BW', 'name' => 'Botswana'));
		Country::create(array('code' => 'BV', 'name' => 'Bouvet Island'));
		Country::create(array('code' => 'BR', 'name' => 'Brazil'));
		Country::create(array('code' => 'BQ', 'name' => 'British Antarctic Territory'));
		Country::create(array('code' => 'IO', 'name' => 'British Indian Ocean Territory'));
		Country::create(array('code' => 'VG', 'name' => 'British Virgin Islands'));
		Country::create(array('code' => 'BN', 'name' => 'Brunei'));
		Country::create(array('code' => 'BG', 'name' => 'Bulgaria'));
		Country::create(array('code' => 'BF', 'name' => 'Burkina Faso'));
		Country::create(array('code' => 'BI', 'name' => 'Burundi'));
		Country::create(array('code' => 'KH', 'name' => 'Cambodia'));
		Country::create(array('code' => 'CM', 'name' => 'Cameroon'));
		Country::create(array('code' => 'CA', 'name' => 'Canada'));
		Country::create(array('code' => 'CT', 'name' => 'Canton and Enderbury Islands'));
		Country::create(array('code' => 'CV', 'name' => 'Cape Verde'));
		Country::create(array('code' => 'KY', 'name' => 'Cayman Islands'));
		Country::create(array('code' => 'CF', 'name' => 'Central African Republic'));
		Country::create(array('code' => 'TD', 'name' => 'Chad'));
		Country::create(array('code' => 'CL', 'name' => 'Chile'));
		Country::create(array('code' => 'CN', 'name' => 'China'));
		Country::create(array('code' => 'CX', 'name' => 'Christmas Island'));
		Country::create(array('code' => 'CC', 'name' => 'Cocos [Keeling] Islands'));
		Country::create(array('code' => 'CO', 'name' => 'Colombia'));
		Country::create(array('code' => 'KM', 'name' => 'Comoros'));
		Country::create(array('code' => 'CG', 'name' => 'Congo - Brazzaville'));
		Country::create(array('code' => 'CD', 'name' => 'Congo - Kinshasa'));
		Country::create(array('code' => 'CK', 'name' => 'Cook Islands'));
		Country::create(array('code' => 'CR', 'name' => 'Costa Rica'));
		Country::create(array('code' => 'HR', 'name' => 'Croatia'));
		Country::create(array('code' => 'CU', 'name' => 'Cuba'));
		Country::create(array('code' => 'CY', 'name' => 'Cyprus'));
		Country::create(array('code' => 'CZ', 'name' => 'Czech Republic'));
		Country::create(array('code' => 'CI', 'name' => 'Côte d’Ivoire'));
		Country::create(array('code' => 'DK', 'name' => 'Denmark'));
		Country::create(array('code' => 'DJ', 'name' => 'Djibouti'));
		Country::create(array('code' => 'DM', 'name' => 'Dominica'));
		Country::create(array('code' => 'DO', 'name' => 'Dominican Republic'));
		Country::create(array('code' => 'NQ', 'name' => 'Dronning Maud Land'));
		Country::create(array('code' => 'DD', 'name' => 'East Germany'));
		Country::create(array('code' => 'EC', 'name' => 'Ecuador'));
		Country::create(array('code' => 'EG', 'name' => 'Egypt'));
		Country::create(array('code' => 'SV', 'name' => 'El Salvador'));
		Country::create(array('code' => 'GQ', 'name' => 'Equatorial Guinea'));
		Country::create(array('code' => 'ER', 'name' => 'Eritrea'));
		Country::create(array('code' => 'EE', 'name' => 'Estonia'));
		Country::create(array('code' => 'ET', 'name' => 'Ethiopia'));
		Country::create(array('code' => 'FK', 'name' => 'Falkland Islands'));
		Country::create(array('code' => 'FO', 'name' => 'Faroe Islands'));
		Country::create(array('code' => 'FJ', 'name' => 'Fiji'));
		Country::create(array('code' => 'FI', 'name' => 'Finland'));
		$france = Country::create(array('code' => 'FR', 'name' => 'France'));
		Country::create(array('code' => 'GF', 'name' => 'French Guiana'));
		Country::create(array('code' => 'PF', 'name' => 'French Polynesia'));
		Country::create(array('code' => 'TF', 'name' => 'French Southern Territories'));
		Country::create(array('code' => 'FQ', 'name' => 'French Southern and Antarctic Territories'));
		Country::create(array('code' => 'GA', 'name' => 'Gabon'));
		Country::create(array('code' => 'GM', 'name' => 'Gambia'));
		Country::create(array('code' => 'GE', 'name' => 'Georgia'));
		Country::create(array('code' => 'DE', 'name' => 'Germany'));
		Country::create(array('code' => 'GH', 'name' => 'Ghana'));
		Country::create(array('code' => 'GI', 'name' => 'Gibraltar'));
		Country::create(array('code' => 'GR', 'name' => 'Greece'));
		Country::create(array('code' => 'GL', 'name' => 'Greenland'));
		Country::create(array('code' => 'GD', 'name' => 'Grenada'));
		Country::create(array('code' => 'GP', 'name' => 'Guadeloupe'));
		Country::create(array('code' => 'GU', 'name' => 'Guam'));
		Country::create(array('code' => 'GT', 'name' => 'Guatemala'));
		Country::create(array('code' => 'GG', 'name' => 'Guernsey'));
		Country::create(array('code' => 'GN', 'name' => 'Guinea'));
		Country::create(array('code' => 'GW', 'name' => 'Guinea-Bissau'));
		Country::create(array('code' => 'GY', 'name' => 'Guyana'));
		Country::create(array('code' => 'HT', 'name' => 'Haiti'));
		Country::create(array('code' => 'HM', 'name' => 'Heard Island and McDonald Islands'));
		Country::create(array('code' => 'HN', 'name' => 'Honduras'));
		Country::create(array('code' => 'HK', 'name' => 'Hong Kong SAR China'));
		Country::create(array('code' => 'HU', 'name' => 'Hungary'));
		Country::create(array('code' => 'IS', 'name' => 'Iceland'));
		Country::create(array('code' => 'IN', 'name' => 'India'));
		Country::create(array('code' => 'ID', 'name' => 'Indonesia'));
		Country::create(array('code' => 'IR', 'name' => 'Iran'));
		Country::create(array('code' => 'IQ', 'name' => 'Iraq'));
		Country::create(array('code' => 'IE', 'name' => 'Ireland'));
		Country::create(array('code' => 'IM', 'name' => 'Isle of Man'));
		Country::create(array('code' => 'IL', 'name' => 'Israel'));
		Country::create(array('code' => 'IT', 'name' => 'Italy'));
		Country::create(array('code' => 'JM', 'name' => 'Jamaica'));
		Country::create(array('code' => 'JP', 'name' => 'Japan'));
		Country::create(array('code' => 'JE', 'name' => 'Jersey'));
		Country::create(array('code' => 'JT', 'name' => 'Johnston Island'));
		Country::create(array('code' => 'JO', 'name' => 'Jordan'));
		Country::create(array('code' => 'KZ', 'name' => 'Kazakhstan'));
		Country::create(array('code' => 'KE', 'name' => 'Kenya'));
		Country::create(array('code' => 'KI', 'name' => 'Kiribati'));
		Country::create(array('code' => 'KW', 'name' => 'Kuwait'));
		Country::create(array('code' => 'KG', 'name' => 'Kyrgyzstan'));
		Country::create(array('code' => 'LA', 'name' => 'Laos'));
		Country::create(array('code' => 'LV', 'name' => 'Latvia'));
		Country::create(array('code' => 'LB', 'name' => 'Lebanon'));
		Country::create(array('code' => 'LS', 'name' => 'Lesotho'));
		Country::create(array('code' => 'LR', 'name' => 'Liberia'));
		Country::create(array('code' => 'LY', 'name' => 'Libya'));
		Country::create(array('code' => 'LI', 'name' => 'Liechtenstein'));
		Country::create(array('code' => 'LT', 'name' => 'Lithuania'));
		Country::create(array('code' => 'LU', 'name' => 'Luxembourg'));
		Country::create(array('code' => 'MO', 'name' => 'Macau SAR China'));
		Country::create(array('code' => 'MK', 'name' => 'Macedonia'));
		Country::create(array('code' => 'MG', 'name' => 'Madagascar'));
		Country::create(array('code' => 'MW', 'name' => 'Malawi'));
		Country::create(array('code' => 'MY', 'name' => 'Malaysia'));
		Country::create(array('code' => 'MV', 'name' => 'Maldives'));
		Country::create(array('code' => 'ML', 'name' => 'Mali'));
		Country::create(array('code' => 'MT', 'name' => 'Malta'));
		Country::create(array('code' => 'MH', 'name' => 'Marshall Islands'));
		Country::create(array('code' => 'MQ', 'name' => 'Martinique'));
		Country::create(array('code' => 'MR', 'name' => 'Mauritania'));
		Country::create(array('code' => 'MU', 'name' => 'Mauritius'));
		Country::create(array('code' => 'YT', 'name' => 'Mayotte'));
		Country::create(array('code' => 'FX', 'name' => 'Metropolitan France'));
		Country::create(array('code' => 'MX', 'name' => 'Mexico'));
		Country::create(array('code' => 'FM', 'name' => 'Micronesia'));
		Country::create(array('code' => 'MI', 'name' => 'Midway Islands'));
		Country::create(array('code' => 'MD', 'name' => 'Moldova'));
		Country::create(array('code' => 'MC', 'name' => 'Monaco'));
		Country::create(array('code' => 'MN', 'name' => 'Mongolia'));
		Country::create(array('code' => 'ME', 'name' => 'Montenegro'));
		Country::create(array('code' => 'MS', 'name' => 'Montserrat'));
		Country::create(array('code' => 'MA', 'name' => 'Morocco'));
		Country::create(array('code' => 'MZ', 'name' => 'Mozambique'));
		Country::create(array('code' => 'MM', 'name' => 'Myanmar [Burma]'));
		Country::create(array('code' => 'NA', 'name' => 'Namibia'));
		Country::create(array('code' => 'NR', 'name' => 'Nauru'));
		Country::create(array('code' => 'NP', 'name' => 'Nepal'));
		Country::create(array('code' => 'NL', 'name' => 'Netherlands'));
		Country::create(array('code' => 'AN', 'name' => 'Netherlands Antilles'));
		Country::create(array('code' => 'NT', 'name' => 'Neutral Zone'));
		Country::create(array('code' => 'NC', 'name' => 'New Caledonia'));
		Country::create(array('code' => 'NZ', 'name' => 'New Zealand'));
		Country::create(array('code' => 'NI', 'name' => 'Nicaragua'));
		Country::create(array('code' => 'NE', 'name' => 'Niger'));
		Country::create(array('code' => 'NG', 'name' => 'Nigeria'));
		Country::create(array('code' => 'NU', 'name' => 'Niue'));
		Country::create(array('code' => 'NF', 'name' => 'Norfolk Island'));
		Country::create(array('code' => 'KP', 'name' => 'North Korea'));
		Country::create(array('code' => 'VD', 'name' => 'North Vietnam'));
		Country::create(array('code' => 'MP', 'name' => 'Northern Mariana Islands'));
		Country::create(array('code' => 'NO', 'name' => 'Norway'));
		Country::create(array('code' => 'OM', 'name' => 'Oman'));
		Country::create(array('code' => 'PC', 'name' => 'Pacific Islands Trust Territory'));
		Country::create(array('code' => 'PK', 'name' => 'Pakistan'));
		Country::create(array('code' => 'PW', 'name' => 'Palau'));
		Country::create(array('code' => 'PS', 'name' => 'Palestinian Territories'));
		Country::create(array('code' => 'PA', 'name' => 'Panama'));
		Country::create(array('code' => 'PZ', 'name' => 'Panama Canal Zone'));
		Country::create(array('code' => 'PG', 'name' => 'Papua New Guinea'));
		Country::create(array('code' => 'PY', 'name' => 'Paraguay'));
		Country::create(array('code' => 'YD', 'name' => 'People\'s Democratic Republic of Yemen'));
		Country::create(array('code' => 'PE', 'name' => 'Peru'));
		Country::create(array('code' => 'PH', 'name' => 'Philippines'));
		Country::create(array('code' => 'PN', 'name' => 'Pitcairn Islands'));
		Country::create(array('code' => 'PL', 'name' => 'Poland'));
		$portugal = Country::create(array('code' => 'PT', 'name' => 'Portugal'));
		Country::create(array('code' => 'PR', 'name' => 'Puerto Rico'));
		Country::create(array('code' => 'QA', 'name' => 'Qatar'));
		Country::create(array('code' => 'RO', 'name' => 'Romania'));
		$russia = Country::create(array('code' => 'RU', 'name' => 'Russia'));
		Country::create(array('code' => 'RW', 'name' => 'Rwanda'));
		Country::create(array('code' => 'RE', 'name' => 'Réunion'));
		Country::create(array('code' => 'BL', 'name' => 'Saint Barthélemy'));
		Country::create(array('code' => 'SH', 'name' => 'Saint Helena'));
		Country::create(array('code' => 'KN', 'name' => 'Saint Kitts and Nevis'));
		Country::create(array('code' => 'LC', 'name' => 'Saint Lucia'));
		Country::create(array('code' => 'MF', 'name' => 'Saint Martin'));
		Country::create(array('code' => 'PM', 'name' => 'Saint Pierre and Miquelon'));
		Country::create(array('code' => 'VC', 'name' => 'Saint Vincent and the Grenadines'));
		Country::create(array('code' => 'WS', 'name' => 'Samoa'));
		Country::create(array('code' => 'SM', 'name' => 'San Marino'));
		Country::create(array('code' => 'SA', 'name' => 'Saudi Arabia'));
		Country::create(array('code' => 'SN', 'name' => 'Senegal'));
		Country::create(array('code' => 'RS', 'name' => 'Serbia'));
		Country::create(array('code' => 'CS', 'name' => 'Serbia and Montenegro'));
		Country::create(array('code' => 'SC', 'name' => 'Seychelles'));
		Country::create(array('code' => 'SL', 'name' => 'Sierra Leone'));
		Country::create(array('code' => 'SG', 'name' => 'Singapore'));
		Country::create(array('code' => 'SK', 'name' => 'Slovakia'));
		Country::create(array('code' => 'SI', 'name' => 'Slovenia'));
		Country::create(array('code' => 'SB', 'name' => 'Solomon Islands'));
		Country::create(array('code' => 'SO', 'name' => 'Somalia'));
		Country::create(array('code' => 'ZA', 'name' => 'South Africa'));
		Country::create(array('code' => 'GS', 'name' => 'South Georgia and the South Sandwich Islands'));
		Country::create(array('code' => 'KR', 'name' => 'South Korea'));
		$spain = Country::create(array('code' => 'ES', 'name' => 'Spain'));
		Country::create(array('code' => 'LK', 'name' => 'Sri Lanka'));
		Country::create(array('code' => 'SD', 'name' => 'Sudan'));
		Country::create(array('code' => 'SR', 'name' => 'Suriname'));
		Country::create(array('code' => 'SJ', 'name' => 'Svalbard and Jan Mayen'));
		Country::create(array('code' => 'SZ', 'name' => 'Swaziland'));
		Country::create(array('code' => 'SE', 'name' => 'Sweden'));
		Country::create(array('code' => 'CH', 'name' => 'Switzerland'));
		Country::create(array('code' => 'SY', 'name' => 'Syria'));
		Country::create(array('code' => 'ST', 'name' => 'São Tomé and Príncipe'));
		Country::create(array('code' => 'TW', 'name' => 'Taiwan'));
		Country::create(array('code' => 'TJ', 'name' => 'Tajikistan'));
		Country::create(array('code' => 'TZ', 'name' => 'Tanzania'));
		Country::create(array('code' => 'TH', 'name' => 'Thailand'));
		Country::create(array('code' => 'TL', 'name' => 'Timor-Leste'));
		Country::create(array('code' => 'TG', 'name' => 'Togo'));
		Country::create(array('code' => 'TK', 'name' => 'Tokelau'));
		Country::create(array('code' => 'TO', 'name' => 'Tonga'));
		Country::create(array('code' => 'TT', 'name' => 'Trinidad and Tobago'));
		Country::create(array('code' => 'TN', 'name' => 'Tunisia'));
		Country::create(array('code' => 'TR', 'name' => 'Turkey'));
		Country::create(array('code' => 'TM', 'name' => 'Turkmenistan'));
		Country::create(array('code' => 'TC', 'name' => 'Turks and Caicos Islands'));
		Country::create(array('code' => 'TV', 'name' => 'Tuvalu'));
		Country::create(array('code' => 'UM', 'name' => 'U.S. Minor Outlying Islands'));
		Country::create(array('code' => 'PU', 'name' => 'U.S. Miscellaneous Pacific Islands'));
		Country::create(array('code' => 'VI', 'name' => 'U.S. Virgin Islands'));
		Country::create(array('code' => 'UG', 'name' => 'Uganda'));
		Country::create(array('code' => 'UA', 'name' => 'Ukraine'));
		Country::create(array('code' => 'SU', 'name' => 'Union of Soviet Socialist Republics'));
		Country::create(array('code' => 'AE', 'name' => 'United Arab Emirates'));
		Country::create(array('code' => 'GB', 'name' => 'United Kingdom'));
		Country::create(array('code' => 'US', 'name' => 'United States'));
		Country::create(array('code' => 'ZZ', 'name' => 'Unknown or Invalid Region'));
		Country::create(array('code' => 'UY', 'name' => 'Uruguay'));
		Country::create(array('code' => 'UZ', 'name' => 'Uzbekistan'));
		Country::create(array('code' => 'VU', 'name' => 'Vanuatu'));
		Country::create(array('code' => 'VA', 'name' => 'Vatican City'));
		Country::create(array('code' => 'VE', 'name' => 'Venezuela'));
		Country::create(array('code' => 'VN', 'name' => 'Vietnam'));
		Country::create(array('code' => 'WK', 'name' => 'Wake Island'));
		Country::create(array('code' => 'WF', 'name' => 'Wallis and Futuna'));
		Country::create(array('code' => 'EH', 'name' => 'Western Sahara'));
		Country::create(array('code' => 'YE', 'name' => 'Yemen'));
		Country::create(array('code' => 'ZM', 'name' => 'Zambia'));
		Country::create(array('code' => 'ZW', 'name' => 'Zimbabwe'));
		Country::create(array('code' => 'AX', 'name' => 'Åland Islands'));


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

        $admin     = User::create(array('username' => 'admin1',     'firstname' => 'Admin',     'lastname' => 'Silva', 'email' => 'admin@spotalert.com',     'password' => Hash::make('111111'), 'password_temp' => '', 'code' => '', 'created_at' => '2014-05-15', 'phonenumber' => '+351915283154', 'address' => 'Address 1', 'postalCode' => '4200-000', 'city' => 'Porto',   'activated' => 'true', 'type' => 'admin',     'age_id' =>$age20->id, 'residence_country_id' => $portugal->id, 'nationality_country_id' => $portugal->id, 'organization'=>'Department Admin' ));
        $manager   = User::create(array('username' => 'manager1',   'firstname' => 'Manager',   'lastname' => 'Silva', 'email' => 'manager@spotalert.com',   'password' => Hash::make('111111'), 'password_temp' => '', 'code' => '', 'created_at' => '2014-05-15', 'phonenumber' => '+351912345678', 'address' => 'Address 2', 'postalCode' => '4900-000', 'city' => 'Lisboa',  'activated' => 'true', 'type' => 'manager',   'age_id' =>$age30->id, 'residence_country_id' => $portugal->id, 'nationality_country_id' => $portugal->id, 'organization'=>'Department Manager' ));
        $publisher = User::create(array('username' => 'publisher1', 'firstname' => 'Publisher', 'lastname' => 'Silva', 'email' => 'publisher@spotalert.com', 'password' => Hash::make('111111'), 'password_temp' => '', 'code' => '', 'created_at' => '2014-05-15', 'phonenumber' => '+351918765432', 'address' => 'Address 3', 'postalCode' => '4100-000', 'city' => 'Aveiro',  'activated' => 'true', 'type' => 'publisher', 'age_id' =>$age20->id, 'residence_country_id' => $spain->id,    'nationality_country_id' => $spain->id,    'organization'=>'Department Publisher' ));
        $normal    = User::create(array('username' => 'normal1',    'firstname' => 'Normal',    'lastname' => 'Silva', 'email' => 'normal@spotalert.com',    'password' => Hash::make('111111'), 'password_temp' => '', 'code' => '', 'created_at' => '2014-05-15', 'phonenumber' => '+351915821654', 'address' => 'Address 4', 'postalCode' => '4500-000', 'city' => 'Coimbra', 'activated' => 'true', 'type' => 'normal',    'age_id' =>$age30->id, 'residence_country_id' => $france->id,   'nationality_country_id' => $spain->id ));

        $publisher->supervisor_id = $admin->id;
        $publisher->save();
        $manager->supervisor_id = $admin->id;
        $manager->save();
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
			'user_id'       => $publisher->id
		));

		$content1EN = PublicationContent::create(array(
			'title'			=> 'Hurricane in Spain',
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
			'last_update'   => '2014-05-23',
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
			'user_id'       => $manager->id
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
			'last_update'   => '2014-05-23',
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
			'is_public'		=> false,
			'risk'			=> 5,
			'type'			=> 'alert',
			'user_id'       => $admin->id
		));

		$content8EN = PublicationContent::create(array(
			'title'			=> 'Hurricane in Somewhere',
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
			'approved'=> "false",
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
			'approved'=> "false",
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

