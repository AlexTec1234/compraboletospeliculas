<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class WebUsuarioController extends Controller
{
  // Vista principal
    public function showHome()
    {
        $usuario = Auth::user();
        return view('layouts.home', compact('usuario'));
    }

    // Muestra el formulario de registro
    public function showRegistrationForm()
    {
        $token = csrf_token(); // Obtiene el token CSRF
        return view('layouts.usuarios.registro', compact('token'));
        return view('layouts.usuarios.registro');
    }

    // Procesa el registro de un nuevo usuario
    public function register(Request $request)
{
    // Validación de los datos del formulario o JSON
    $request->validate([
        'nombre' => 'required',
        'email' => 'required|email|unique:usuarios,email',
        'password' => 'required'
    ]);

    try {
        // Verifica si la solicitud es JSON
        if ($request->isJson()) {
            // Si es JSON, accede a los datos de JSON
            $data = $request->json()->all();
        } else {
            // Si no es JSON, asume que son datos de formulario HTML
            $data = $request->all();
        }

        // Crea un nuevo usuario en la base de datos usando Eloquent
        $usuario = Usuario::create([
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'contraseña' => bcrypt($data['password'])
        ]);

        // Si la solicitud es JSON, devuelve una respuesta JSON
        if ($request->isJson()) {
            return response()->json(['message' => '¡Registro exitoso!', 'usuario' => $usuario], 201);
        } else {
            // Si no es JSON (formulario HTML), redirige con un mensaje de éxito
            return redirect()->route('login')->with('success', '¡Registro exitoso! Por favor inicia sesión.');
        }
    } catch (\Exception $e) {
        // Si la solicitud es JSON, devuelve una respuesta JSON con el error
        if ($request->isJson()) {
            return response()->json(['error' => 'Error al crear usuario: ' . $e->getMessage()], 500);
        } else {
            // Si no es JSON (formulario HTML), redirige con un mensaje de error
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al crear usuario: ' . $e->getMessage()]);
        }
    }
}

    // Procesa el inicio de sesión
   public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            return redirect()->route('home')->with('success', '¡Bienvenido de nuevo!');
        } else {
            return redirect()->route('login')->with('error', 'Usuario inválido. Por favor, regístrese.');
        }
    }
    //prueba api login usuario
    public function loginAPI(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            // Login exitoso, retornar un mensaje JSON
            return response()->json(['message' => '¡Bienvenido de nuevo!']);
        } else {
            // Error de login, retornar un mensaje JSON
            return response()->json(['error' => 'Usuario inválido. Por favor, regístrese.'], 401);
        }
    }
    
    // Procesa la actualización del perfil del usuario
    public function updateProfile(Request $request)
{
    // Validación de los datos del formulario o JSON
    $request->validate([
        'nombre' => 'required',
        'email' => 'required|email|unique:usuarios,email,'.Auth::id(),
    ]);

    try {
        // Verifica si la solicitud es JSON
        if ($request->isJson()) {
            // Si es JSON, accede a los datos de JSON
            $data = $request->json()->all();
        } else {
            // Si no es JSON, asume que son datos de formulario HTML
            $data = $request->all();
        }

        // Obtiene el usuario autenticado
        $usuario = Auth::user();

        // Actualiza el perfil del usuario usando Eloquent
        $usuario->nombre = $data['nombre'];
        $usuario->email = $data['email'];
        $usuario->save();

        return redirect()->route('perfil')->with('success', 'Perfil actualizado correctamente');
    } catch (\Exception $e) {
        return redirect()->back()->withInput()->withErrors(['error' => 'Error al actualizar el perfil: ' . $e->getMessage()]);
    }
}


    // Vista: Muestra el formulario de inicio de sesión
    public function showLoginForm()
    {
        return view('layouts.usuarios.login');
    }

    // Vista: Muestra la vista principal del home o index del proyecto después del logueo
    public function showProfile()
    {
        $usuario = Auth::user();
        return view('layouts.home', compact('usuario'));
    }

    // Vista: Muestra la vista para editar el perfil
    public function editarProfile()
    {
        $usuario = Auth::user();
        return view('layouts.usuarios.editar', compact('usuario'));
    }

    // Elimina la cuenta del usuario
    public function deleteAccount()
    {
        $usuario = Auth::user();
        
        // Elimina el usuario y luego cierra la sesión
        $usuario->delete();
        Auth::logout();
        
        return redirect('/')->with('success', 'Cuenta eliminada correctamente');
    }

    // Cierra la sesión del usuario
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/home')->with('success', '¡Has cerrado sesión correctamente!');
    }
    public function deleteUser($id)
{
    \Log::info('Solicitud DELETE recibida para el usuario ID: ' . $id);

    try {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
    } catch (\Exception $e) {
        \Log::error('Error al eliminar el usuario: ' . $e->getMessage());

        return response()->json(['error' => 'Error al eliminar el usuario: ' . $e->getMessage()], 500);
    }
}



}
