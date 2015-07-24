<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('matches', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('team_id')->unsigned();
			$table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');;
			$table->integer('opponent_id')->unsigned();
			$table->foreign('opponent_id')->references('id')->on('opponents')->onDelete('cascade');
			$table->integer('game_id')->unsigned();
			$table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');;
            $table->string('matchlink')->nullable();
            $table->text('opponent_participants')->nullable();
            $table->text('standins')->nullable();
            $table->datetime('date')->default(date("Y-m-d H:i:s"));
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('matches');
	}

}
