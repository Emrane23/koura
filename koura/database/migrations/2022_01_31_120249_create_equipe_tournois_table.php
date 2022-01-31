<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipeTournoisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipe_tournois', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournoi_id');
            $table->foreign('tournoi_id')
            ->references('id')->on('tournois')
            ->onDelete('cascade');
            
            $table->unsignedBigInteger('equipe_id');
            $table->foreign('equipe_id')
            ->references('id')->on('equipes')
            ->onDelete('cascade');
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
        Schema::dropIfExists('equipe_tournois');
    }
}
