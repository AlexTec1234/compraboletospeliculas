@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Compras Realizadas</h2>
        @if($comprasCompletadas->isEmpty())
            <p>No hay compras realizadas.</p>
        @else
            <div class="ticket">
                <div class="ticket-header">
                <h3 class="mb-4 text-center">Historial de compra</h3>
                    <p>Fecha: {{ now()->format('d/m/Y H:i') }}</p>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Película</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comprasCompletadas as $compra)
                            <tr>
                                <td>{{ $compra->nombre }}</td>
                                <td>{{ $compra->cantidad }}</td>
                                <td>${{ $compra->total_pagar }}</td>
                                <td>{{ $compra->estado ? 'Pagada' : 'Pendiente' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="ticket-footer">
                    <p>Gracias por sus compras</p>
                </div>
            </div>
        @endif
    </div>
@endsection
