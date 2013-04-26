<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
            $table->string('name'); 
            $table->string('path');
            $table->string('title'); 
            $table->integer('layout_id'); 
                        
            $table->unique('name'); 
            $table->index('path'); 
            $table->index('layout_id'); 
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pages');
	}

}
