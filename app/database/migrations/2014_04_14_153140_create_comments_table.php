<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration 
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('content');
			$table->date('created_at');
			$table->boolean('approved');
			$table->integer('user_id')->unsigned();
			$table->integer('publication_id')->unsigned();

			$table->foreign('user_id')
				  ->references('id')->on('users');
			$table->foreign('publication_id')
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
		Schema::drop('comments');
	}

}
