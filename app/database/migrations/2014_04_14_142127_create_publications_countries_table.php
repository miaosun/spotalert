<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationsCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('publications_countries', function(Blueprint $table)
		{
			$table->integer('publication_id')->unsigned();
			$table->integer('country_id')->unsigned();
			
			$table->foreign('publication_id')
				  ->references('id')->on('publications');
			$table->foreign('country_id')
				  ->references('id')->on('countries');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('publications_countries');
	}

}
