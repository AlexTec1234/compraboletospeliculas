<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula;
use App\Models\CompraBoleto;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
     //carrito no pagado
    public function showCart(Request $request) {
        $usuario = Auth::user();
         $usuarioId = $usuario->id;
        $comprasEnCarrito = CompraBoleto::where('usuario_id', $usuarioId)
            ->where('estado', false)
            ->get();
    
        return view('layouts.usuarios.carrito', ['comprasEnCarrito' => $comprasEnCarrito]);
    }
    //vista del compras 
    public function comprasCompletadas(Request $request) {
        $usuario = Auth::user();
         $usuarioId = $usuario->id;
        $comprasCompletadas = CompraBoleto::where('usuario_id', $usuarioId)
            ->where('estado', true)
            ->get();
    
        return view('layouts.usuarios.compras', ['comprasCompletadas' => $comprasCompletadas]);
    }
    
    public function addToCart(Request $request, $peliculaId) {

         // Obtener el ID del usuario autenticado
         $usuario = Auth::user();
         $usuarioId = $usuario->id;
        // Lógica para agregar una película al carrito
        $pelicula = Pelicula::find($peliculaId);
        if (!$pelicula) {
            return redirect()->back()->with('error', 'Película no encontrada.');
        }
        // Calcular el total a pagar
        $cantidadBoletos = $request->input('cantidad', 1);
        $totalPagar = $pelicula->precio * $cantidadBoletos;
    
        // Agregar la película al carrito del usuario
        CompraBoleto::create([
            'usuario_id' => $usuarioId,
            'pelicula_id' => $pelicula->id,
            'cantidad' => $cantidadBoletos,
            'nombre' => $pelicula->titulo,
            'token' => hash('sha256', $usuarioId . $peliculaId . time()),
            'total_pagar' => $totalPagar,
            'estado' => false, // Por defecto, la compra no está completada
        ]);
    
        return redirect()->back()->with('success', 'Película agregada al carrito.');
    }
    
    
    public function pagarCarrito(Request $request) {
        // Obtener el usuario autenticado
        $usuario = Auth::user();
         $usuarioId = $usuario->id;

        // Obtener los elementos del carrito del usuario actual que no han sido pagados
        $carrito = CompraBoleto::where('usuario_id', $usuarioId)
            ->where('estado', false)
            ->get();

        if ($carrito->isEmpty()) {
            return redirect()->back()->with('error', 'El carrito está vacío.');
        }

        // Marcar los elementos del carrito como pagados
        foreach ($carrito as $compra) {
            $compra->estado = true;
            $compra->save();
        }

        return redirect()->route('compras.completadas')->with('success', 'Compra realizada con éxito.');
    }


    public function eliminarDelCarrito(Request $request, $peliculaId) {
        // Lógica para eliminar una película del carrito
        $usuario = Auth::user();
        $usuarioId = $usuario->id;
        $compra = CompraBoleto::where('usuario_id', $usuarioId)
            ->where('pelicula_id', $peliculaId)
            ->where('estado', false)
            ->first();

        if ($compra) {
            $compra->delete();
            return redirect()->back()->with('success', 'Película eliminada del carrito.');
        }

        return redirect()->back()->with('error', 'No se encontró la película en el carrito.');
    }

    public function vaciarCarrito(Request $request) {
        // Lógica para vaciar todo el carrito del usuario
        $usuario = Auth::user();
         $usuarioId = $usuario->id;
        CompraBoleto::where('usuario_id', $usuarioId)
            ->where('estado', false)
            ->delete();

        return redirect()->back()->with('success', 'Carrito vaciado.');
    }

}
