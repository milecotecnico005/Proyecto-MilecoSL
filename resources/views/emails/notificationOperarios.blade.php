<!DOCTYPE html>
<html>
<head>
    <title>Notificación de Nueva Orden</title>
</head>
<body>
    <h1>Hola, {{ $userName }}!</h1>
    <p>Tienes una nueva orden de trabajo.</p>

    <h3>Detalles:</h3>
    <p>Otros datos:</p>
    <ul>
        @foreach($otherData as $key => $value)
            <li>{{ $key }}: {{ $value }}</li>
        @endforeach
    </ul>

    <h3>Imágenes:</h3>
    @foreach($imagePaths as $image)
        <p><img src="{{ $message->embed($image) }}" alt="Imagen de la orden" style="max-width: 600px;"></p>
    @endforeach

    <p>Gracias!</p>
</body>
</html>
