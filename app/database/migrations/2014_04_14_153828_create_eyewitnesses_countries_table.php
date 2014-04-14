<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEyewitnessesCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('eyewitnesses_countries', function(Blueprint $table)
		{
			$table->integer('eyewitness_id')->unsigned();
			$table->integer('country_id')->unsigned();
			
			$table->foreign('eyewitness_id')
				  ->references('id')->on('eyewitnesses');
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
		Schema::drop('eyewitnesses_countries');
	}

}
