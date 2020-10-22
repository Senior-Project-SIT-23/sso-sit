<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_config', function (Blueprint $table) {
            $table->bigIncrements("manage_id");
            $table->text("redirect_uri");
            $table->bigInteger("app_id")->unsigned();
            $table->timestamps();

            $table->foreign('app_id')->references('id')->on('applications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_config');
    }
}
