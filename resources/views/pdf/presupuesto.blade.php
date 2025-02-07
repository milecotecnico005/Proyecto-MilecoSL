<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presupuesto {{ $parte->idParteTrabajo }} PDF</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; margin: 20px; }
        .container { width: 100%; }
        .header { margin-bottom: 20px; }
        .header .left, .header .right { display: inline-block; width: 48%; vertical-align: top; }
        .header .left { text-align: left; }
        .header .right { text-align: right; }
        .content { margin-top: 20px; }
        .content .left, .content .right { display: inline-block; width: 48%; vertical-align: top; }
        .content .left { text-align: left; }
        .content .right { text-align: right; }

        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #000; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; }

        .footer { margin-top: 40px; }
        .footer .left { display: inline-block; width: 48%; vertical-align: top; }
        .footer .right { display: inline-block; width: 48%; text-align: right; vertical-align: top; }
        .signature img { width: 150px; }

        .title { font-size: 14px; font-weight: bold; }
        .subtitle { font-size: 12px; font-weight: bold; }

        .sinborde, .sinborde th, .sinborde td, .sinborde tr {
            border: none !important;
        }
    </style>
</head>
<body>

    <!-- Encabezado organizado en tablas -->
    <div class="container header" style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <img
                        src="https://sebcompanyes.com/vendor/adminlte/dist/img/5800979007360058229.jpg"
                        alt="Logo"
                        style="max-width: 350px; max-height: 150px;"
                    />
                </td>
                <td style="width: 50%; text-align: center; vertical-align: top;">
                    <p><strong>No Presupuesto:</strong> {{ $parte->idParteTrabajo }}</p>
                    <p><strong>FECHA:</strong>  {{ $parte->FechaAlta }}</p>
                    <p><strong>CLIENTE:</strong> {{ $parte->cliente->NombreCliente }} {{ $parte->cliente->ApellidoCliente }}</p>
                    <p><strong>CIF:</strong> {{ $parte->cliente->CIF }}</p>
                    <p><strong>DIRECCIÓN:</strong>{{ $parte->cliente->Direccion }} {{ $parte->cliente->CodPostalCliente }} - {{ $parte->cliente->ciudad->nameCiudad }}</p>
                </td>
            </tr>
        </table>
    </div>

    <h3>
        Construcciones, electricidad, antena, porteros, mantenimentos, fontaneria, pintura.
        Empresa instaladora registrada en el ministerio de telecomunicaciones.
    </h3>

    <hr>

    <div class="container header" style="width: 100%; border-collapse: collapse; margin-bottom: 10px; margin-top: 30px">
        <table style="width: 100%;">
            <tr>
                <td style="width: 100%; vertical-align: middle; align-content: center; text-align: center">
                    <p class="title">{{ $parte->cliente->NombreCliente }} {{ $parte->cliente->ApellidoCliente }} | {{ $parte->Asunto }}</p>
                    <img
                        src="https://sebcompanyes.com/vendor/adminlte/dist/img/logopdf.png"
                        alt="Logo"
                        style="max-width: 550px; max-height: 550px;"
                    />
                </td>
            </tr>
        </table>
    </div>

    {{-- salto de pagina --}}
    <div style="page-break-after: always;"></div>

    <!-- Encabezado organizado en tablas -->
    <div class="container header" style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <img
                        src="https://sebcompanyes.com/vendor/adminlte/dist/img/5800979007360058229.jpg"
                        alt="Logo"
                        style="max-width: 350px; max-height: 150px;"
                    />
                </td>
                <td style="width: 50%; text-align: center; vertical-align: top;">
                    <p><strong>No Presupuesto:</strong> {{ $parte->idParteTrabajo }}</p>
                    <p><strong>FECHA:</strong>  {{ $parte->FechaAlta }}</p>
                    <p><strong>CLIENTE:</strong> {{ $parte->cliente->NombreCliente }} {{ $parte->cliente->ApellidoCliente }}</p>
                    <p><strong>ASUNTO:</strong> {{ $parte->Asunto }}</p>
                </td>
            </tr>
        </table>
    </div>

    <hr>

    <div class="container content" style="width: 100%; border-collapse: collapse; margin-top: 30px">
        <table class="table sinborde">
            <thead>
                <tr class="sinborde">
                    <th>Servicio Presupuestado</th>
                    <th>UDS</th>
                    <th>PVu</th>
                    <th>D%</th>
                    <th>S.Total</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr class="sinborde">
                    <td>
                        <strong>{{ $parte->Asunto }}</strong>
                    </td>
                    <td>1</td>
                    <td>{{ number_format($parte->suma, 2, ',', '.') }} €</td>
                    <td>0</td>
                    <td>{{ number_format($parte->suma, 2, ',', '.') }} €</td>
                    <td>{{ number_format($parte->suma, 2, ',', '.') }} €</td>
                </tr>
                @foreach ($parte->partesPresu as $parteP)
                    @foreach ($parteP->partesTrabajoLineas as $linea)
                        <tr>
                            <td>{{ $linea->articuloPDF->nombreArticulo }}</td>
                            <td>{{ $linea->cantidad }}</td>
                            <td>{{ number_format($linea->precioSinIva, 2, ',', '.') }} €</td>
                            <td>{{ $linea->descuento }}%</td>
                            <td>{{ number_format($linea->total, 2, ',', '.') }} €</td>
                            <td>{{ number_format($linea->total, 2, ',', '.') }} €</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>

        <h3 style="text-align: right; margin-top: 20px">Total: {{ number_format($parte->suma, 2, ',', '.') }} €</h3>

    </div>

    {{-- salto de pagina --}}
    <div style="page-break-after: always;"></div>

    {{-- anexos --}}
    <div class="container content" style="width: 100%; border-collapse: collapse; margin-top: 30px">
        @foreach ($parte->anexos as $key => $anexo)
            <h3>Anexo {{ $key + 1 }}:</h3>
            <br>
            <p>{{ $anexo->value_anexo }}</p>
            <br>
            <hr>
        @endforeach
    </div>

    {{-- Observaciones --}}
    <div class="container content" style="width: 100%; border-collapse: collapse; margin-top: 30px">
        <h3>Observaciones:</h3>
        <br>
        <p><strong>{{ $parte->Observaciones }}</strong></p>
    </div>

    {{-- condiciones generales --}}
    <div class="container content" style="width: 100%; border-collapse: collapse; margin-top: 30px">
        <h3>Condiciones Generales:</h3>
        <br>
        <p><strong>{!! $condicionesGenerales !!}</strong></p>
    </div>
    
</body>
</html>
