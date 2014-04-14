<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertsGuidelinesTable extends Migration 
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('alerts_guidelines', function(Blueprint $table)
		{
			$table->integer('alert_id')->unsigned();
			$table->integer('guideline_id')->unsigned();
			
			$table->foreign('alert_id')
				  ->references('id')->on('publications');
			$table->foreign('guideline_id')
				  ->references('id')->on('publications');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('alerts_guidelines');
	}

}
