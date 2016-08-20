<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DocumentsCreateMediaTranslationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_translations', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('media_id')->unsigned();
            $table->string('locale')->index();

            $table->string('caption');
            $table->text('description');
            $table->string('alttext');

            $table->unique(['media_id', 'locale']);
            $table->foreign('media_id')
                ->references('id')
                ->on('media')
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
        Schema::drop('media_translations');
    }
}
