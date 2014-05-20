<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserToPublications extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('publications', function($table)
		{
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
		Schema::table('publications', function($table)
		{
		    $table->dropColumn('user_id');
		});
	}

}
