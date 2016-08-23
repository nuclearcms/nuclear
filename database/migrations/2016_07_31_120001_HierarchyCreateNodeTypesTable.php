<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HierarchyCreateNodeTypesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('node_types', function (Blueprint $table)
        {
            $table->increments('id');

            $table->string('name');
            $table->string('label');
            $table->boolean('visible')->default(1);
            $table->boolean('hides_children')->default(0);
            $table->string('color', 32)->default('#000000');
            $table->boolean('taggable')->default(0);
            $table->boolean('mailing')->default(0);
            $table->string('allowed_children')->default('[]');
            $table->string('custom_form')->nullable();

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
        Schema::drop('node_types');
    }
}
