<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    @vite('resources/css/login.css')

</head>

<body>
    <div class="container">
        <div class="header">
            <header>¡Bienvenido a ByteQuest!</header>
        </div>

        <div class="caja1">
            <img src="{{ asset('img/robot.png') }}" alt="ROBOT">
        </div>

        <div class="card">
            <div class="card-form">
                <h2>POR FAVOR INGRESA TUS DATOS</h2>

                @if(session('error'))
                <p style="color: red;">{{ session('error') }}</p>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="email" name="correo" placeholder="Ingresa tu correo" required>
                    <input type="password" name="password" placeholder="Contraseña" required>
                    <button class="button" type="submit">Ingresar</button>
                    <a href="{{ route('register') }}">¿No tienes cuenta?
                        <br>
                        ¡Registrate Ahora!</a>
                    <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                </form>
            </div>
        </div>

        <div class="footer">
            <h5>Derechos reservados ByteQuest &copy; 2025</h5>
        </div>
    </div>
</body>

</html>