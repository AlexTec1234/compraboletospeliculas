<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompraBoletosTable extends Migration
{
    public function up()
    {
        Schema::create('compra_boletos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('pelicula_id');
            $table->integer('cantidad');
            $table->string('nombre');
            $table->string('token')->unique();
            $table->decimal('total_pagar', 8, 2);
            $table->boolean('estado')->default(false);
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('pelicula_id')->references('id')->on('peliculas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('compra_boletos');
    }
};