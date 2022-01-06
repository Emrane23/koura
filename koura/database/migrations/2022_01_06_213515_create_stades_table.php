<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proprietaire_id');
            $table->foreign('proprietaire_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
            $table->string('name');
            $table->string('gouvernorat');
            $table->string('delegation');
            $table->string('image')->nullable();
            $table->string('nbr_terrain');
            $table->string('capacite');
            $table->string('horaire_ouverture');
            $table->string('horaire_fermeture');
            $table->string('adresse');
            $table->string('tarif');
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
        Schema::dropIfExists('stades');
    }
}
