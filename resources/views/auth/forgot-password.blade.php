<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="container">
        <h2>¿Olvidaste tu contraseña?</h2>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <input type="email" name="email" placeholder="Ingresa tu correo" required>
            <button type="submit">Enviar enlace de recuperación</button>
        </form>
        @if(session('status'))
            <p style="color: green;">{{ session('status') }}</p>
        @endif
        <a href="{{ route('login') }}">Volver al login</a>
    </div>
</body>
</html>
