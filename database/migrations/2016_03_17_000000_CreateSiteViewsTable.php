<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteViewsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_views', function (Blueprint $table)
        {
            $table->increments('id');

            $table->unsignedInteger('user_id')->nullable();

            $table->string('http_referer', 2000)->nullable();
            $table->string('url', 2000);

            $table->string('request_method', 10);
            $table->string('request_path');

            $table->string('http_user_agent')->nullable();
            $table->string('http_accept_language')->nullable();
            $table->string('locale')->index();

            $table->bigInteger('request_time');
            $table->float('app_time');
            $table->bigInteger('memory');

            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('site_views');
    }

}