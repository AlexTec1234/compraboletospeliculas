@extends('layouts.admin.adminIndex')

@section('content')
  <div>
    <div class="container mt-5">
        <h2>Detalles de la película</h2>
           <div>
            <h3>{{ $pelicula->titulo }}</h3>
            <p>{{ $pelicula->descripcion }}</p>
            <p>Horario: {{ $pelicula->horario }}</p>
            <p>Precio: {{ $pelicula->precio }}</p>
             <div class="col-md-4">
               <img src="{{ $pelicula->getImagen() }}" alt="Imagen de la película" width="300">

              </div>
         </div>
    </div>
@endsection
