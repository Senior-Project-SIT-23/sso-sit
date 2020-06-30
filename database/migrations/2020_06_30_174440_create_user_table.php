<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('user_id', 30)->primary();
            $table->bigInteger('user_group_id')->unsigned()->nullable();
            $table->string('name_th')->nullable();
            $table->string('name_en')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();

            $table->foreign('user_group_id')->references('user_group_id')->on('user_group')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
