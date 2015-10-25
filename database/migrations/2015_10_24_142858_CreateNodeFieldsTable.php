<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodeFieldsTable extends Migration {

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
            $table->integer('node_type_id')->unsigned();

            $table->string('name');
            $table->string('label');
            $table->text('description');
            $table->double('position')->unsigned();
            $table->string('type');
            $table->boolean('visible');

            $table->text('rules')->nullable();
            $table->text('default_value')->nullable();
            $table->text('value')->nullable();
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
