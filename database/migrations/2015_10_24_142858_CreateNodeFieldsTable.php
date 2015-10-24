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

            $table->string('rules');
            $table->text('default_value');
            $table->text('value');
            $table->text('options');

            $table->timestamps();
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
