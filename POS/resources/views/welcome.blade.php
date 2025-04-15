<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Cargar CSS de W3Schools -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
    <div class="w3-container w3-center w3-padding-64">
        <h1 class="w3-xxxlarge">¡Hola, bienvenido!</h1>
        <p class="w3-large">Explora nuestra aplicación.</p>
        <br>
        <!-- Botón para Login -->
        <a href="{{ route('login') }}" class="w3-button w3-green w3-large w3-margin-right">Log in</a>
        <!-- Botón para Información -->
        <a href="{{ url('/info') }}" class="w3-button w3-blue w3-large">Información</a>
    </div>
</body>
</html>
