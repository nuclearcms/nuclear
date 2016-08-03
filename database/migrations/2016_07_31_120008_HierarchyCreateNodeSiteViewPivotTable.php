<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HierarchyCreateNodeSiteViewPivotTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('node_site_view', function (Blueprint $table)
        {
            $table->integer('node_id')->unsigned();
            $table->integer('site_view_id')->unsigned();

            $table->foreign('node_id')
                ->references('id')
                ->on('nodes')
                ->onDelete('cascade');

            $table->foreign('site_view_id')
                ->references('id')
                ->on('site_views')
                ->onDelete('cascade');

            $table->primary(['node_id', 'site_view_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('node_site_view');
    }
}