<?php

//controlador de api  Compra de Boletos
namespace App\Http\Controllers;

use App\Models\CompraBoletos;
use Illuminate\Http\Request;
use App\Models\Pelicula;

class CompraBoletosController extends Controller
{
    public function mostrarCompras()
    {
        $compras = CompraBoleto::where('usuario_id', auth()->id())->get();
        return view('compras', compact('compras'));
    }
    
}    