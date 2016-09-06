<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HierarchyCreateMailingListsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailing_lists', function (Blueprint $table)
        {
            $table->increments('id');

            $table->string('name');
            $table->enum('type', ['default', 'mailchimp'])->default('default');

            $table->string('from_name')->nullable();
            $table->string('reply_to')->nullable();
            $table->text('options')->nullable();
            $table->string('external_id')->nullable();

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
        Schema::drop('mailing_lists');
    }
}
