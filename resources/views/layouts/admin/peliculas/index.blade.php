@extends('layouts.admin.adminIndex')

@section('content')
    <div class="container mt-5">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            <script>
                // Recarga la página después de mostrar el mensaje de éxito
                setTimeout(function() {
                    location.reload();
                }, 3000); // Recarga la página después de 3 segundos (3000 milisegundos)
            </script>
        @endif

        <!-- Mostrar registros existentes -->
        <h2>Registros existentes</h2>
        <table class="table">
            <!-- Encabezados de la tabla -->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Ejemplo de registros de películas existentes -->
                @foreach ($viewData["peliculas"] as $pelicula)
                    <tr>
                        <td>{{ $pelicula->id }}</td>
                        <td>{{ $pelicula->titulo }}</td>
                        <td>{{ $pelicula->descripcion }}</td>
                        <td>
                            <a href="{{ route('admin.pelicula.show', ['id' => $pelicula->id]) }}" class="btn btn-info">Ver mas</a>
                            </td>
                            <td>
                            <a href="{{ route('admin.pelicula.edit', $pelicula->id) }}" class="btn btn-primary">Editar</a>
                            </td>
                            <td>
                           <form action="{{ route('admin.pelicula.destroy', $pelicula->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                           <button type="submit" class="btn btn-danger">Eliminar</button>
                           </form>
                           </td>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Botón para mostrar el formulario -->
        <button id="showFormBtn" class="btn btn-primary">Agregar Nueva Película</button>

        <!-- Formulario para agregar una nueva película -->
        <div id="formContainer" style="display: none;">
            <h2>Registrar Nueva Película</h2>
            <form id="newMovieForm" method="POST" action="{{ route('admin.pelicula.store') }}" enctype="multipart/form-data">
                @csrf
                <!-- Campos para la nueva película -->
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título:</label>
                    <input name="titulo" type="text" class="form-control" id="titulo" required>
                </div>
                <div class="mb-3">
                        <!-- Campo para la descripción -->
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea name="descripcion" class="form-control" id="descripcion" required></textarea>
                    </div>
                    <div class="mb-3">
                        <!-- Campo para el horario -->
                        <label for="horario" class="form-label">Horario:</label>
                        <input name="horario" type="datetime-local"class="form-control" id="horario" required>
                    </div>
                    <div class="mb-3">
                        <!-- Campo para el precio -->
                        <label for="precio" class="form-label">Precio:</label>
                        <input name="precio" type="number" class="form-control" id="precio" required min="0" step="0.01">
                    </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen:</label>
                    <input type="file" class="form-control" id="imagen" name="imagen">
                </div>
                <!-- Botones para enviar o cancelar el formulario -->
                <div class="mb-3">
                    <button id="submitButton" type="submit" class="btn btn-primary">Registrar Película</button>
                    <button id="cancelButton" type="button" class="btn btn-secondary">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script para mostrar/ocultar el formulario -->
    <script>
       document.addEventListener('DOMContentLoaded', function () {
    const showFormBtn = document.getElementById('showFormBtn');
    const formContainer = document.getElementById('formContainer');
    const cancelButton = document.getElementById('cancelButton'); // Agrega esta línea para obtener el botón Cancelar

    showFormBtn.addEventListener('click', function() {
        if (formContainer.style.display === 'none') {
            formContainer.style.display = 'block';
        } else {
            formContainer.style.display = 'none';
        }
    });

    // Agrega un evento click al botón Cancelar para ocultar el formulario
    cancelButton.addEventListener('click', function() {
        formContainer.style.display = 'none';
    });

    // Lógica para validar y enviar el formulario...
});
    </script>
@endsection
