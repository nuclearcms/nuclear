<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HierarchyCreateSubscribersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribers', function (Blueprint $table)
        {
            $table->increments('id');

            $table->string('email')->unique();
            $table->string('name', 128)->nullable();

            $table->string('address')->nullable();
            $table->string('city', 64)->nullable();
            $table->string('country', 64)->nullable();
            $table->string('postal_code', 16)->nullable();
            $table->string('nationality', 64)->nullable();
            $table->string('national_id', 64)->nullable();

            $table->string('tel', 32)->nullable();
            $table->string('tel_mobile', 32)->nullable();
            $table->string('fax', 32)->nullable();

            $table->text('additional')->nullable();

            $table->timestamps();
        });

        Schema::create('mailing_list_subscriber', function (Blueprint $table)
        {
            $table->integer('subscriber_id')->unsigned();
            $table->integer('mailing_list_id')->unsigned();

            $table->foreign('subscriber_id')
                ->references('id')
                ->on('subscribers')
                ->onDelete('cascade');

            $table->foreign('mailing_list_id')
                ->references('id')
                ->on('mailing_lists')
                ->onDelete('cascade');

            $table->primary(['subscriber_id', 'mailing_list_id']);
        });

        Schema::create('mailing_list_node', function (Blueprint $table)
        {
            $table->integer('mailing_list_id')->unsigned();
            $table->integer('node_id')->unsigned();

            $table->string('external_mailing_id')->nullable();

            $table->foreign('mailing_list_id')
                ->references('id')
                ->on('mailing_lists')
                ->onDelete('cascade');

            $table->foreign('node_id')
                ->references('id')
                ->on('nodes')
                ->onDelete('cascade');

            $table->primary(['mailing_list_id', 'node_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('subscribers');
        Schema::drop('mailing_list_subscriber');
        Schema::drop('mailing_list_node');
    }
}
