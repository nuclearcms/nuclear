<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HierarchyCreateTagsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table)
        {
            $table->increments('id');

            $table->timestamps();
        });

        Schema::create('node_tag', function (Blueprint $table)
        {
            $table->integer('node_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->foreign('node_id')
                ->references('id')
                ->on('nodes')
                ->onDelete('cascade');

            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onDelete('cascade');

            $table->primary(['node_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('node_tag');
        Schema::drop('tags');
    }
}
