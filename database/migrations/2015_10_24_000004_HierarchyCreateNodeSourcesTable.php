<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HierarchyCreateNodeSourcesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('node_sources', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('node_id')->unsigned()->nullable();

            $table->string('title');
            $table->string('node_name');
            $table->string('locale', 16);
            $table->string('source_type');

            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();

            $table->unique(['node_id','locale']);
            $table->foreign('node_id')
                ->references('id')
                ->on('nodes')
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
        Schema::drop('node_sources');
    }
}
