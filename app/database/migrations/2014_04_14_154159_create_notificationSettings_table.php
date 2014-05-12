<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationSettingsTable extends Migration 
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notificationSettings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('risk');
			$table->integer('user_id')->unsigned();
			$table->integer('country_id')->unsigned();
			
			$table->foreign('user_id')
				  ->references('id')->on('users')
				  ->onDelete('cascade');
			$table->foreign('country_id')
				  ->references('id')->on('countries')
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
		Schema::drop('notificationSettings');
	}

}
