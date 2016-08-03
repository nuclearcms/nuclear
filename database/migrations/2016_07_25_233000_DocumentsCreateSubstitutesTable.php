<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DocumentsCreateSubstitutesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('substitutes', function (Blueprint $table)
        {
            $table->increments('id');

            $table->string('path');
            $table->string('extension');
            $table->string('mimetype');
            $table->bigInteger('size')->unsigned();

            $table->integer('media_id')->unsigned()->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('substitutes');
    }

}
