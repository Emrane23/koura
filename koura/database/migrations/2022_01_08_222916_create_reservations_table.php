<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')
            ->references('id')->on('users')
            ->onDelete('cascade');

            $table->unsignedBigInteger('stade_id');
            $table->foreign('stade_id')
            ->references('id')->on('stades')
            ->onDelete('cascade');
           
            $table->date('date');
            $table->string('horaire_debut');
            $table->string('horaire_fin');
            $table->string('message')->nullable();
            $table->string('service')->nullable();
            $table->string('etat');
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
        Schema::dropIfExists('reservations');
    }
}
