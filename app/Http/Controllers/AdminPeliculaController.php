<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Pelicula;
use Illuminate\Support\Facades\Storage;

class AdminPeliculaController extends Controller
{

    public function indexHome()
    {
        $peliculas = Pelicula::all();
        return view('layouts.home', compact('peliculas'));
    }

   public function index()
    { 
    $viewData = [];
    $viewData["title"] = "Admin Page - Películas";
    $viewData["peliculas"] = Pelicula::all();
    return view('layouts.admin.peliculas.index', compact('viewData'));
    }

     public function edit($id)
  {
    $viewData = [];
    $viewData["title"] = "Admin Page - Editar Película";
    $viewData["pelicula"] = Pelicula::findOrFail($id);
    return view('layouts.admin.peliculas.edit', compact('viewData'));
    }

    //regresa la vita de una solo pelicula
    public function show($id)
    {
        $pelicula = Pelicula::findOrFail($id);
        return view('layouts.admin.peliculas.show', compact('pelicula'));
    }
    
    public function store(Request $request)
{
    $request->validate([
        'titulo' => 'required',
        'descripcion' => 'required',
        'precio' => 'required|numeric|gt:0',
        'imagen' => 'image',
        'horario' => 'required'
    ]);

    $nuevaPelicula = new Pelicula();
    $nuevaPelicula->titulo = $request->input('titulo');
    $nuevaPelicula->descripcion = $request->input('descripcion');
    $nuevaPelicula->precio = $request->input('precio');
    $nuevaPelicula->horario = $request->input('horario');

    $nuevaPelicula->save();

    if ($request->hasFile('imagen')) {
        $imageName = time() . '_' . $request->file('imagen')->getClientOriginalName();
        $request->file('imagen')->storeAs('public/pelicula_imagenes', $imageName);
        $nuevaPelicula->imagen = 'pelicula_imagenes/' . $imageName;
        $nuevaPelicula->save();
    }

    return redirect()->route('admin.pelicula.index')->with('success', 'Película agregada correctamente');
}
   
    public function update(Request $request, $id)
        {
            $request->validate([
                'titulo' => 'required',
                'descripcion' => 'required',
                'precio' => 'required|numeric|gt:0',
                'imagen' => 'image',
            ]);
    
            $pelicula = Pelicula::findOrFail($id);
            $pelicula->titulo = $request->input('titulo');
            $pelicula->descripcion = $request->input('descripcion');
            $pelicula->precio = $request->input('precio');
    
            if ($request->hasFile('imagen')) {
                $imageName = $pelicula->id . "." . $request->file('imagen')->extension();
                Storage::disk('public')->put(
                    $imageName,
                    file_get_contents($request->file('imagen')->getRealPath())
                );
                $pelicula->imagen = $imageName;
            }
    
            $pelicula->save();
            return redirect()->route('admin.pelicula.index');
        }
    
    public function destroy($id)
        {
            $pelicula = Pelicula::findOrFail($id);
            $pelicula->delete();
            return redirect()->route('admin.pelicula.index');
    }
}
    

