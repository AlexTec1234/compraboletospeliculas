@extends('layouts.admin.adminIndex')

@section('title', 'Editar Película')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Editar Película</h2>

        <!-- Formulario de edición -->
        <form method="POST" action="{{ route('admin.pelicula.update', ['id' => $viewData['pelicula']->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <label for="titulo" class="col-sm-2 col-form-label">Título</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $viewData['pelicula']->titulo }}">
                </div>
            </div>

            <div class="row mb-3">
                <label for="descripcion" class="col-sm-2 col-form-label">Descripción</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="4">{{ $viewData['pelicula']->descripcion }}</textarea>
                </div>
            </div>

            <div class="row mb-3">
                <label for="precio" class="col-sm-2 col-form-label">Precio</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="precio" name="precio" value="{{ $viewData['pelicula']->precio }}">
                </div>
            </div>

            <div class="row mb-3">
                <label for="horario" class="col-sm-2 col-form-label">Horario</label>
                <div class="col-sm-10">
                    <input type="datetime-local" class="form-control" id="horario" name="horario" value="{{ date('Y-m-d\TH:i', strtotime($viewData['pelicula']->horario)) }}">
                </div>
            </div>

            <div class="row mb-3">
                <label for="imagen" class="col-sm-2 col-form-label">Imagen</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" id="imagen" name="imagen">
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary w-100">Guardar cambios</button>
                </div>
            </div>
        </form>
    </div>
@endsection
