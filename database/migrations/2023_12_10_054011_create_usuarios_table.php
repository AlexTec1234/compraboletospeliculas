<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('contraseña');
            $table->string('email_verificado')->nullable(); // Campo para almacenar el token de verificación
            $table->boolean('verificado')->default(false); // Campo para indicar si el correo ha sido verificado
            $table->rememberToken();
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
};
