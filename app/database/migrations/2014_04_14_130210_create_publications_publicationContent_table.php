<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationsPublicationContentTable extends Migration 
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('publications_publicationContents', function(Blueprint $table)
		{
			$table->integer('publication_id')->unsigned();
			$table->integer('publicationContent_id')->unsigned();
			$table->foreign('publication_id')
				  ->references('id')->on('publications');
			$table->foreign('publicationContent_id')
				  ->references('id')->on('publicationContents');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('publications_publicationContents');
	}

}
