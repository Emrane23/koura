<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournoisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournois', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organisateur_id');
            $table->foreign('organisateur_id')
            ->references('id')->on('users')
            ->onDelete('cascade');

            $table->unsignedBigInteger('stade_id');
            $table->foreign('stade_id')
            ->references('id')->on('stades')
            ->onDelete('cascade');
            $table->mediumText('image');
            $table->string('nom') ;
            $table->datetime('date_debut') ;
            $table->datetime('date_fin') ;
            $table->string('places') ;
            $table->string('cotisation') ;
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
        Schema::dropIfExists('tournois');
    }
}
