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
    <div class="container header" style="width: 100%; border-collapse: collapse; margin-top: -50px">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <img
                        src="https://sebcompanyes.com/vendor/adminlte/dist/img/5800979007360058229.jpg"
                        alt="Logo"
                        style="width: 100%; max-height: 150px;"
                    />
                </td>
                <td style="width: 50%; text-align: start; vertical-align: top;">
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
                        style="width: 100%; height: 150px;"
                    />
                </td>
                <td style="width: 50%; text-align: start; vertical-align: top;">
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
                    <th>Capitulos - Descripcion</th>
                    <th>UDS</th>
                    <th>Precio</th>
                    <th>D%</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($parte->partesPresu as $parteP)
                    <tr>
                        <td>{{ $parteP->Asunto }}</td>
                        <td>1</td>
                        <td>{{ number_format($parteP->suma, 2, ',', '.') }} €</td>
                        <td>0</td>
                        <td>{{ number_format($parteP->suma, 2, ',', '.') }} €</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3 style="text-align: right; margin-top: 20px">Total Oferta: {{ number_format($parte->suma, 2, ',', '.') }} €</h3>

    </div>

    {{-- salto de pagina --}}
    <div style="page-break-after: always;"></div>

    @foreach ($parte->partesPresu as $index => $parteP)
        @php
            $indice = $index + 1;
        @endphp
        <!-- Contenedor principal de cada capítulo -->
        <div class="container header" style="width: 100%; margin-bottom: 30px;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <!-- Columna izquierda: Información del trabajo y materiales -->
                    <td style="width: 50%; vertical-align: top; padding-right: 2px;">
                        <div style="margin-bottom: 2px;">
                            {{-- primera columna de detalles y segunda columna con la foto del encabezado --}}
                            <table style="width: 100%;">
                                <tr>
                                    <td style="width: 50%; text-align: start; vertical-align: top;">
                                        <p style="font-weight: bold;">TRABAJO CAPÍTULO {{ $indice }}</p>
                                        <p style="font-weight: bold;">No Capítulo: {{ $parteP->idParteTrabajo }}</p>
                                        <p><strong>Descripción:</strong> {{ $parteP->Asunto }}</p>
                                    </td>
                                    <td style="width: 50%; vertical-align: top;">
                                        <img
                                            src="https://sebcompanyes.com/vendor/adminlte/dist/img/5800979007360058229.jpg"
                                            alt="Logo"
                                            style="max-width: 350px; max-height: 150px;"
                                        />
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <hr>
                        <div style="margin-top: 1px;">
                            <div class="content" style="text-align: center; margin-bottom: 2px">
                                <h3 style="text-decoration: underline">Trabajos Capitulo</h3>
                                <p>{{ $parteP->solucion }}</p>
                            </div>

                            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                                <thead>
                                    <tr>
                                        <th style="padding: 5px 10px; text-align: left;">ART</th>
                                        <th style="padding: 5px 10px; text-align: left;">UDS</th>
                                        <th style="padding: 5px 10px; text-align: left;">PRECIO</th>
                                        <th style="padding: 5px 10px; text-align: left;">D%</th>
                                        <th style="padding: 5px 10px; text-align: left;">Imp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($parteP->partesTrabajoLineas as $linea)
                                        <tr>
                                            <td style="padding: 5px 10px; font-size: 10px">{{ $linea->articuloPDF->nombreArticulo }}</td>
                                            <td style="padding: 5px 10px;">{{ $linea->cantidad }}</td>
                                            <td style="padding: 5px 10px;">{{ number_format($linea->precioSinIva, 2, ',', '.') }} €</td>
                                            <td style="padding: 5px 10px;">{{ $linea->descuento }}%</td>
                                            <td style="padding: 5px 10px;">{{ number_format($linea->total, 2, ',', '.') }} €</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <h3 style="text-align: right; margin-top: 20px">Total Capitulo: {{ number_format($parteP->suma, 2, ',', '.') }} €</h3>
                        </div>
                    </td>

                    <!-- Columna derecha: Imágenes -->
                    <td style="width: 50%; vertical-align: top; padding-left: 10px; text-align: center;">
                        <div style="display: flex; flex-direction: column; align-items: center;">
                            @foreach ($parteP->archivos as $img)
                                @php
                                    $path      = $img->archivo->pathFile;
                                    $serverUrl = "https://sebcompanyes.com";
                                    $rutaArchivo = "/home/u657674604/domains/sebcompanyes.com/public_html";
                                    $rutaCompleta = $path;
                                    
                                    // Reemplazar la ruta del archivo del servidor por la URL pública
                                    $rutaModificada = str_replace($rutaArchivo, $serverUrl, $rutaCompleta);
                                @endphp
                                <img 
                                    src="{{ $rutaModificada }}" 
                                    alt="Imagen" 
                                    style="max-width: 200px; max-height: 150px; margin-bottom: 10px;"
                                >
                                <p style="margin-top: 10px;">{{ $img->comentarioArchivo }}</p>
                            @endforeach
                        </div>
                    </td>
                </tr>
            </table>
        </div>

      
        <div style="page-break-after: always;"></div>
    @endforeach

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
