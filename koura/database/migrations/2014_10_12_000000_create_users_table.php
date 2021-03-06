<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_de_naissance');
            $table->string('nom_entreprise')->nullable();
            $table->string('patente')->nullable();
            $table->string('poste_1')->nullable();
            $table->string('poste_2')->nullable();
            $table->string('pied')->nullable();
            $table->string('role');
            $table->string('gouvernorat');
            $table->string('sexe');
            $table->string('delegation');
            $table->string('type_user');
            $table->string('pseudo')->unique();
            $table->string('nbr_terrain')->nullable();
            $table->string('localisation')->nullable();
            $table->string('telephone')->nullable();
            $table->string('image')->nullable();
            $table->string('test')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at');
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
