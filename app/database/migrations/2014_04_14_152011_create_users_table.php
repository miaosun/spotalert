<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration 
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username');
			$table->string('firstname')->nullable();
			$table->string('lastname')->nullable();
			$table->string('email');
			$table->bigInteger('facebookId')->nullable();
			$table->bigInteger('googleId')->nullable();
			$table->string('organization')->nullable();
			$table->string('password');
			$table->integer('phonenumber')->nullable();
			$table->string('address')->nullable();
			$table->string('postalCode')->nullable();
			$table->string('city')->nullable();
			$table->boolean('activated')->default(false);
			$table->enum('type', array('normal', 'admin', 'manager', 'publisher'));
			$table->integer('age_id')->unsigned();
			$table->integer('residence_country_id')->unsigned();
			$table->integer('nacionality_country_id')->unsigned();
			$table->integer('supervisor_id')->unsigned()->nullable();
			
			$table->foreign('age_id')
				  ->references('id')->on('ages');
			$table->foreign('residence_country_id')
				  ->references('id')->on('countries');
			$table->foreign('nacionality_country_id')
				  ->references('id')->on('countries');
			$table->foreign('supervisor_id')
				  ->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
