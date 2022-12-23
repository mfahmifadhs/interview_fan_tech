<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Epresence extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eprecense', function (Blueprint $table) {
            $table->id();
            $table->integer('id_users');
            $table->enum('type',['IN','OUT']);
            $table->enum('is_approve',['TRUE','FALSE']);
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
        Schema::dropIfExists('eprecense');
    }
}
