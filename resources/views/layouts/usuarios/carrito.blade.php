@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <h2>Carrito de Compras</h2>
        <p>Total de elementos en el carrito: {{ count($comprasEnCarrito) }}</p>
        @if($comprasEnCarrito->isEmpty())
            <p>El carrito está vacío.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Película</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comprasEnCarrito as $compra)
                        <tr>
                            <td>{{ $compra->nombre }}</td>
                            <td>{{ $compra->cantidad }}</td>
                            <td>${{ $compra->total_pagar }}</td>
                            <td>
                            <form action="{{ route('carrito.eliminar', $compra->pelicula_id) }}" method="POST">
                                   @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                             </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            <form action="{{ route('carrito.vaciar') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Vaciar Carrito</button>
            </form>
            </br>
            <div>
            <form action="{{ route('carrito.pagar') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Pagar Carrito</button>
            </form>
           </div>
        @endif
    </div>
@endsection
