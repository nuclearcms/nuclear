<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSEOFieldsToNodeSourcesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('node_sources', function (Blueprint $table)
        {
            $table->string('meta_author')->nullable();
            $table->integer('meta_image')->unsigned();
        });
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('node_sources', function (Blueprint $table)
        {
            $table->dropColumn('meta_author');
            $table->dropColumn('meta_image');
        });
    }

}