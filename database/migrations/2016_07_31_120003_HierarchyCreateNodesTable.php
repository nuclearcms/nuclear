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
            $table->integer('user_id')->unsigned();

            NestedSet::columns($table);

            $table->boolean('mailing')->default(0);
            $table->boolean('visible')->default(1);
            $table->boolean('sterile')->default(0);
            $table->boolean('home')->default(0);
            $table->boolean('locked')->default(0);
            $table->integer('status')->default(30);
            $table->boolean('hides_children')->default(0);
            $table->double('priority')->unsigned()->default(1);

            $table->timestamp('published_at')->nullable();
            $table->string('children_order')->default('_lft');
            $table->string('children_order_direction', 4)->default('asc');
            $table->enum('children_display_mode', ['tree', 'list'])->default('list');

            $table->timestamps();

            $table->index('mailing');
            $table->index('home');
            $table->index('node_type_id');

            $table->foreign('node_type_id')
                ->references('id')
                ->on('node_types')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
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
