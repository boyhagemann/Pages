<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageBlocksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('page_blocks', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('page_id');
            $table->integer('zone_id');
            $table->integer('block_id');
            $table->integer('position');
            $table->text('defaults');
            $table->tinyInteger('global');

            $table->unique(array('page_id', 'zone_id', 'block_id', 'position'));
            $table->index('global');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('page_blocks');
    }

}
