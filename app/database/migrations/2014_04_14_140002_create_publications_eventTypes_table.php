<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationsEventTypesTable extends Migration 
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('publications_eventTypes', function(Blueprint $table)
		{
			$table->integer('publication_id')->unsigned();
			$table->integer('eventType_id')->unsigned();
			
			$table->foreign('publication_id')
				  ->references('id')->on('publications')
				  ->onDelete('cascade');
			$table->foreign('eventType_id')
				  ->references('id')->on('eventTypes')
				  ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('publications_eventTypes');
	}

}
