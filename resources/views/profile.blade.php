<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    @vite('resources/css/profile.css')
</head>
<body>
    <div class="profile-container">
        <h2>Mi Perfil</h2>
        <form class="profile-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <img src="{{ Auth::user()->imagen ? asset('storage/' . Auth::user()->imagen) : asset('img/robot.png') }}" alt="Foto de perfil" class="profile-img">
            <label for="imagen">Imagen de perfil</label>
            <input type="file" name="imagen" id="imagen" accept="image/*">

            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="{{ Auth::user()->nombre }}" required>

            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" value="{{ Auth::user()->apellido }}" required>

            <button type="submit">Guardar cambios</button>
        </form>
        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif
        @if($errors->any())
            <ul style="color: red;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <a href="{{ route('views.dashboard') }}">Volver al inicio</a>
    </div>
</body>
</html>