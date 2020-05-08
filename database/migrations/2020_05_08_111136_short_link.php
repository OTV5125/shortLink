<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ShortLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('short_link', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->string('url');
            $table->string('title');
            $table->string('description');
            $table->string('image')->nullable();
            $table->string('code')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('short_link');
    }
}
