<!DOCTYPE html>
<html>

<head>
    <title>Registro - ByteQuest</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    @vite('resources/css/register.css')
</head>

<body>
    <div class="container">
        <header class="header">
            <h2>Registrarse</h2>
        </header>
        <div class="formulario">

            <div class="card-form">
                @if ($errors->any())
                <div style="color:red;font-size: 12px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" action="/register">
                    @csrf
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" required placeholder="Nombre">

                    <label for="apellido">Apellido:</label>
                    <input type="text" name="apellido" id="apellido" required placeholder="Apellido">

                    <label for="correo">Correo:</label>
                    <input type="email" name="correo" id="correo" placeholder="Correo" required><br>

                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" id="password" placeholder="Contraseña" required><br>

                    <label for="password_confirmation">Confirmar Contraseña:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Confirmar Contraseña"><br>

                    <button type="submit">Registrarse</button>
                </form>
                <br>
                <a href="/login">¿Ya tienes cuenta? Inicia sesión</a>
            </div>
        </div>
    </div>
</body>

</html>
