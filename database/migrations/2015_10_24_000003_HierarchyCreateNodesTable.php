<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;

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

            NestedSet::columns($table);

            $table->boolean('visible')->default(1);
            $table->boolean('sterile')->default(0);
            $table->boolean('home')->default(0);
            $table->boolean('locked')->default(0);
            $table->integer('status')->default(30);
            $table->boolean('hides_children')->default(0);
            $table->double('priority')->unsigned()->default(1);

            $table->timestamp('published_at')
                ->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('children_order')->default('_lft');
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
