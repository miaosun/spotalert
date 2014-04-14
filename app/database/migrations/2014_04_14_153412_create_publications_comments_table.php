<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationsCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('publications_comments', function(Blueprint $table)
		{
			$table->integer('publication_id')->unsigned();
			$table->integer('comment_id')->unsigned();
			
			$table->foreign('publication_id')
				  ->references('id')->on('publications');
			$table->foreign('comment_id')
				  ->references('id')->on('comments');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('publications_comments');
	}

}
