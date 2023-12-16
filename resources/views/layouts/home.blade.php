@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        @auth
            <h1 class="text-center">¡Hola de nuevo, {{ Auth::user()->nombre }}!</h1>
        @else
            <p class="text-center">Bienvenido a nuestra aplicación. Por favor, inicia sesión para continuar.</p>
        @endauth

        @if(isset($peliculas) && $peliculas->isNotEmpty())
    <div class="row mt-5">
        @foreach($peliculas as $pelicula)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ $pelicula->getImagen() }}" 
                         alt="Imagen de la película" 
                         class="card-img-top" 
                         style="height: 400px; object-fit: contain;">
                    <div class="card-body">
                        <h4 class="card-title">{{ $pelicula->titulo }}</h4>
                        <!-- Precio omitido -->
                                          
                        <form method="POST" action="{{ route('carrito.agregar', $pelicula->id) }}">
                           @csrf
                       <!-- Campo oculto para el ID del usuario -->
                       <input type="hidden" name="usuario_id" value="{{ Auth::id() }}">
                               <div class="mb-3">
                          <label for="cantidad{{ $pelicula->id }}" class="form-label">Cantidad de boletos:</label>
                                   <input type="number" id="cantidad{{ $pelicula->id }}" 
                                    name="cantidad" min="1" value="1" class="form-control">
                                  </div>
                        <button type="submit" class="btn btn-primary">Agregar al carrito</button>
                          </form>

                    </div>
                </div>
            </div>
                @endforeach
            </div>
        @else
            <p class="text-center">No hay películas disponibles.</p>
        @endif
    </div>
@endsection
