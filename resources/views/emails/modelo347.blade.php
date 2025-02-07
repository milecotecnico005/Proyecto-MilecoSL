<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modelo 347</title>
</head>
<body style="background-color:#e2e1e0;font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;">
    <table style="max-width:670px;margin:50px auto 10px;background-color:#fff;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-top: solid 10px green;">
        <thead>
            <tr>
                <th style="text-align:left;">
                    <img style="max-width: 150px;" src="https://www.sebcompanyes.com/vendor/adminlte/dist/img/mileco.jpeg" alt="bachana tours">
                </th>
                <th style="text-align:right;font-weight:400;">{{ date('d M, Y') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2" style="border: solid 1px #ddd; padding:10px 20px;">
                    <p><strong>Cliente:</strong> {{ $cliente->NombreCliente }} {{ $cliente->ApellidoCliente }}</p>
                    <p><strong>Email:</strong> {{ $cliente->EmailCliente }}</p>
                    @foreach ($cliente->telefonos as $index => $telefono)
                        @php
                            $index = $index + 1;
                        @endphp
                        <p><strong>Teléfono {{ $index }}:</strong> {{ $telefono->telefono }}</p>
                    @endforeach
                    <p><strong>Dirección:</strong> {{ $cliente->Direccion }}</p>
                    <p><strong>Año:</strong> {{ $year }}</p>
                </td>
            </tr>
            <tr>
                <td style="height:35px;"></td>
            </tr>
            <tr>
                <td colspan="2" style="font-size:20px;padding:30px 15px 0 15px;">Trimestres</td>
            </tr>
            @foreach ($trimestres as $trim => $suma)
                <tr>
                    <td colspan="2" style="padding:15px;">
                        <p><strong>Trimestre: {{ $trim }}</strong></p>
                        <p><strong>Suma:</strong> {{ number_format($suma->total, 2, ',', '.') }}€</p>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" style="font-size:20px;padding:30px 15px 0 15px;">Archivo Adjuntado</td>
            </tr>
            <tr>
                <td colspan="2" style="padding:15px;">
                    <p>Archivo adjunto: {{ $archivo }}</p>
                </td>
            </tr>
        </tbody>
        <tfooter>
            <tr>
                <td colspan="2" style="font-size:14px;padding:50px 15px 0 15px;">
                    <strong>Saludos</strong><br>
                    MilecoSL<br>
                    <b>Teléfono:</b> 957 826 851 | 658 97 23 40.<br>
                    <b>Email:</b> milecosl@gmail.com
                </td>
            </tr>
        </tfooter>
    </table>
</body>
</html>
