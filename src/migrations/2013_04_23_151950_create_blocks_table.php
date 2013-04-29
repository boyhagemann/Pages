<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlocksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('blocks', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('action');
            $table->text('defaults');
            $table->tinyInteger('available');

            $table->index('action');
            $table->index('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('blocks');
    }

}
