<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'correo' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['correo' => $credentials['correo'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'correo' => 'Credenciales incorrectas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }



    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuarios,correo',
            'password' => 'required|min:6|confirmed',
        ]);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
        ]);


        return redirect('/login')->with('success', 'Registro exitoso. Ya puedes iniciar sesión.');
    }

    // Mostrar formulario para recuperar contraseña
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // Enviar enlace de recuperación de contraseña
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Buscar usuario por correo
        $usuario = \App\Models\Usuario::where('correo', $request->email)->first();
        if (!$usuario) {
            return back()->withErrors(['email' => 'No se encontró un usuario con ese correo.']);
        }

        // Generar token único
        $token = \Str::random(60);
        \DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => now()
            ]
        );

        // Enviar correo con el enlace (aquí solo se muestra el enlace en pantalla para pruebas)
        $resetLink = url('/password/reset/' . $token . '?email=' . urlencode($request->email));
        // En producción deberías enviar el correo aquí
        return back()->with('status', 'Enlace de recuperación: ' . $resetLink);
    }

    // Mostrar formulario para restablecer contraseña
    public function showResetForm(Request $request, $token)
    {
        $email = $request->query('email');
        return view('auth.reset-password', ['token' => $token, 'email' => $email]);
    }

    // Procesar el restablecimiento de contraseña
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        // Buscar el registro de password_resets
        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->withErrors(['email' => 'El enlace de recuperación no es válido o ha expirado.']);
        }

        // Buscar el usuario y actualizar la contraseña
        $usuario = \App\Models\Usuario::where('correo', $request->email)->first();
        if (!$usuario) {
            return back()->withErrors(['email' => 'No se encontró un usuario con ese correo.']);
        }
        $usuario->password = Hash::make($request->password);
        $usuario->save();

        // Eliminar el registro de password_resets
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', '¡Contraseña restablecida correctamente! Ya puedes iniciar sesión.');
    }

    // Actualizar perfil de usuario
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->nombre = $request->nombre;
        $user->apellido = $request->apellido;

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('profile', 'public');
            $user->imagen = $path;
        }

        $user->save();
        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}
