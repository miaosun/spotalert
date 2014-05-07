<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationContentTable extends Migration 
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('publicationContents', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->string('content');
			$table->integer('language_id')->unsigned();
			$table->integer('publication_id')->unsigned();

			$table->foreign('language_id')
				  ->references('id')->on('languages')
				  ->onDelete('restrict');
			$table->foreign('publication_id')
				  ->references('id')->on('publications')
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
		Schema::drop('publicationContents');
	}

}
