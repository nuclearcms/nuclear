<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HierarchyCreateNodesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nodes', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('node_type_id')->unsigned();

            $table->integer('parent_id')->nullable();
            $table->integer('lft')->nullable();
            $table->integer('rgt')->nullable();
            $table->integer('depth')->nullable();

            $table->boolean('visible')->default(1);
            $table->boolean('sterile')->default(0);
            $table->boolean('home')->default(0);
            $table->boolean('locked')->default(0);
            $table->integer('status')->default(30);
            $table->boolean('hides_children')->default(0);
            $table->double('priority')->unsigned()->default(1);

            $table->timestamp('published_at')->nullable();
            $table->string('children_order')->default('lft');
            $table->string('children_order_direction', 4)->default('asc');

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
        Schema::drop('nodes');
    }
}
