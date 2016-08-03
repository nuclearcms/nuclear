<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HierarchyCreateNodeFieldsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('node_fields', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('node_type_id')->unsigned()->nullable();

            $table->string('name');
            $table->string('label');
            $table->text('description')->nullable();
            $table->double('position')->unsigned();
            $table->string('type');
            $table->boolean('visible')->default(1);
            $table->boolean('indexed')->default(0);
            $table->integer('search_priority')->default(0);

            $table->text('rules')->nullable();
            $table->text('default_value')->nullable();
            $table->text('options')->nullable();

            $table->timestamps();

            $table->foreign('node_type_id')
                ->references('id')
                ->on('node_types')
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
        Schema::drop('node_fields');
    }
}
