<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEyewitnessesTable extends Migration 
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('eyewitnesses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->string('description', 2000);
			$table->date('created_at');
			$table->integer('user_id')->unsigned();

			$table->foreign('user_id')
				  ->references('id')->on('users')
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
		Schema::drop('eyewitnesses');
	}

}
