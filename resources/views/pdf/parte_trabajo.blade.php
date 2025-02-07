<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parte de Trabajo PDF</title>
    <style>
        /* Importar la fuente Comic Sans*/
        @import url('https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
        /* Importar Comic sans Bold */

        body { 
            font-size: 12px; 
            margin: 20px;
        }    
        body {
            font-family: "Comic Neue", cursive;
        }
        
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

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: left;
            font-size: 12px;
            padding-top: 5px;
            background-color: white;
        }
        .footerPartes {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 50%;
            text-align: left;
            font-size: 12px;
            padding-top: 5px;
            background-color: white;
        }
        .signature img { width: 150px; }

        .title { font-size: 14px; font-weight: bold; }
        .subtitle { font-size: 12px; font-weight: bold; }

        .sinborde, .sinborde th, .sinborde td, .sinborde tr {
            border: none !important;
        }

        .page:after {
            content: counter(page) ' de ';
        }

        .cajonUnidoIzquierda {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            border-left: 1px solid #000;
            border-right: 0; /* Evita cualquier borde derecho */
            padding: 5px; /* Ajusta el espaciado */
        }

        .cajonUnidoDerecha {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            border-right: 1px solid #000;
            border-left: 0; /* Evita cualquier borde izquierdo */
            padding: 5px; /* Ajusta el espaciado */
        }

        /* Evitar saltos de página no deseados */
        .no-break {
            page-break-inside: avoid;
        }

    </style>
</head>
<body>

    <div class="container header no-break" style="width: 100%; margin-bottom: 5px;">
        <table style="width: 100%; border-collapse: collapse; margin-top: -50px; no-break">
            <tr>
                <!-- Columna izquierda: Información del trabajo y materiales -->
                <td style="width: 50%; vertical-align: top; padding-right: 2px; no-break">
                    <div style="margin-bottom: 1px;">
                        {{-- primera columna de detalles y segunda columna con la foto del encabezado --}}
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 50%; text-align: start; vertical-align: top;">
                                    <p style="font-weight: bold; font-size: 9px;">Num Trabajo: {{ $parte->idParteTrabajo }}</p>
                                    <p style="font-weight: bold; font-size: 9px;">Fecha: {{ formatDate($parte->FechaVisita) }}</p>
                                    <p style="font-weight: bold; font-size: 9px;">Estado: {{ ($parte->Estado == 3) ? 'Finalizado' : ($parte->Estado == 2 ? 'En proceso' : 'Pendiente') }}</p>
                                    <p style="font-weight: bold; font-size: 9px; word-wrap: break-word;">Cliente: 
                                        {{ $parte->cliente->NombreCliente }} {{ $parte->cliente->ApellidosCliente }}
                                    </p>
                                    <p style="word-wrap: break-word;">
                                        <strong style="text-decoration: underline; font-size: 9px">Asunto:</strong> 
                                        @if (strlen($parte->Asunto) > 30)
                                            <span
                                                style="word-wrap: break-word; font-size: 8px"
                                            >
                                                {{ $parte->Asunto }}
                                            </span>
                                        @else
                                            {{ $parte->Asunto }}
                                        @endif
                                    </p>
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
                    <div style="margin-top: -50px;">
                        <div class="content" style="text-align: left; margin-bottom: 20px; margin-top: -8px">
                            <h3 style="text-decoration: underline; text-align: center;">Trabajo Realizado:</h3>
                            @if (strlen($parte->solucion) > 100)
                                <p
                                    style="word-wrap: break-word; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; font-size: 8px;
                                    margin-top: -3px;
                                    "
                                >
                                    {{ $parte->solucion }}
                                </p>
                            @else
                                <p>{{ $parte->solucion }}</p>
                            @endif
                        </div>

                        <table style="width: 100%; border-collapse: collapse; margin-top: -10px">
                            <thead>
                                <tr>
                                    <th style="text-align: left;">ARTICULOS</th>
                                    <th style="padding: 5px 5px; text-align: right;">UNI</th>
                                    <th style="padding: 5px 5px; text-align: right;">PVP</th>
                                    <th style="padding: 5px 5px; text-align: right;">D%</th>
                                    <th style="padding: 5px 5px; text-align: right; min-width: 35px;">IMPORTE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $descuentoAcumulado = 0;
                                    $totalLineas = 0;
                                    $totalSinDescuentos = 0;
                                @endphp
                            
                                @foreach ($lineas as $linea)
                                    <tr>
                                        <td style="padding: 2px 2px; font-size: 7px; text-align: left;">{{ $linea->articulo->nombreArticulo }}</td>
                                        <td style="padding: 2px 2px; font-size: 7px; text-align: right;">{{ number_format($linea->cantidad, 2, ',', '.') }}</td>
                                        <td style="padding: 2px 2px; font-size: 7px; text-align: right;">{{ number_format($linea->precioSinIva, 2, ',', '.') }} €</td>
                                        <td style="padding: 2px 2px; font-size: 7px; text-align: right;">{{ number_format($linea->descuento) }}</td>
                                        <td style="padding: 2px 2px; font-size: 7px; text-align: right;">{{ number_format($linea->total, 2, ',', '.') }} €</td>
                                    </tr>
                                    @php
                                        if ($linea->descuento > 0) {
                                            $precioVenta = floatval($linea->precioSinIva);
                                            $descuento = floatval($linea->descuento);
                                            $resultado = $precioVenta * floatval($linea->cantidad);
                                            $descuentoEuros = ($resultado * $descuento) / 100;
                                            $descuentoAcumulado += $descuentoEuros;
                                        }
                                        $totalLineas += $linea->total;
                                        $totalSinDescuentos += $linea->precioSinIva * $linea->cantidad;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                        {{-- @php
                            // calcular el total del iva de la venta dependiendo del tipo de iva de $venta->IVAVenta
                            $totalIva = 0;
                            $totalImporte = $linea->suma;
                            $iva = 21;
                
                            if ( $iva == 21 || $iva == 21.00 ) {
                                $totalIva = $totalImporte * 0.21;
                            } elseif ( $iva == 10 || $iva == 10.00 ) {
                                $totalIva = $totalImporte * 0.10;
                            }
                        @endphp --}}
                        @php
                            // Total del descuento sobre el valor total
                            $totalDescuentoParte = number_format($totalLineas, 2) * ($parte->descuentoParte / 100);

                            // Venta sin descuento aplicado (valor bruto)
                            $ventaLimpia = number_format($totalLineas, 2);

                            // Subtotal después de aplicar el descuento acumulado
                            $subtotalMenosMateriales = $parte->suma;

                            // Calcular el IVA sobre el subtotal menos materiales
                            $totalIva = $subtotalMenosMateriales * ($iva / 100);

                            // Total final, que es el subtotal más el IVA
                            $totalVenta = $subtotalMenosMateriales + $totalIva;

                        @endphp
                        <div class="footerPartes sinborder" style="margin-top: 10px; font-size: 9px;">
                            <table class="sinborder" style="width: 100%">
                                <tr>
                                    <td style="width: 50%"></td>
                                    <td>
                                        <table class="table sinborder" style="width: 100%; table-layout: fixed;">
                                            {{-- <tr>
                                                <td style="text-align: left; padding: 5px; width: 25%; border-right: 0px">Precio sin Dto:</td>
                                                <td style="text-align: right; padding: 5px; width: 25%; border-left: 0px"><strong>{{ formatPrice($totalSinDescuentos) }}</strong></td>
                                                <td style="text-align: left; padding: 5px; width: 25%; border-right: 0px">Dto Materiales:</td>
                                                <td style="text-align: right; padding: 5px; width: 25%; border-left: 0px"><strong>{{ formatPrice($descuentoAcumulado) }}</strong></td>
                                            </tr> --}}
                                            <tr>
                                                <td style="text-align: left; padding: 5px; border-right: 0px">Importe:</td>
                                                <td style="text-align: right; padding: 5px; border-left: 0px"><strong>{{ formatPrice($ventaLimpia) }}</strong></td>
                                                <td style="text-align: left; padding: 5px; border-right: 0px">Dto Parte:</td>
                                                <td style="text-align: right; padding: 5px; border-left: 0px">
                                                    <strong>
                                                        @if($parte->descuentoParte)
                                                            {{ $parte->descuentoParte }}% | | {{ formatPrice($totalDescuentoParte) }}
                                                        @else
                                                            0% | {{ formatPrice($totalDescuentoParte) }}
                                                        @endif
                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left; padding: 5px; border-right: 0px">Subtotal:</td>
                                                <td style="text-align: right; padding: 5px; border-left: 0px"><strong>{{ formatPrice($subtotalMenosMateriales) }}</strong></td>
                                                <td style="text-align: left; padding: 5px; border-right: 0px">IVA:</td>
                                                <td style="text-align: right; padding: 5px; border-left: 0px"><strong>{{ $iva }}% | {{ formatPrice($totalIva) }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="text-align: center; padding: 5px; font-size: 12px; border-top: 1px solid #000;">
                                                    <strong>Total I.I: {{ formatPrice($totalVenta) }}</strong>
                                                </td>
                                            </tr>
                                        </table>
                                        <p style="margin-top: 10px; font-size: 8px;">
                                            Nota: Este trabajo tiene 3 meses de garantía. <br>
                                            Página <strong class="page"></strong> <strong>{{ $totalPages ?? 0 }}</strong>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>

                <!-- Columna derecha: Imágenes -->
                <td style="width: 50%; vertical-align: top; padding-left: 10px; no-break">
                    <table style="width: 100%; text-align: center; border-collapse: collapse;">
                        @php
                            $archivosValidosSoloImagenes = ['img', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'webp'];
                            $counter = 0;
                        @endphp
                        <tr>
                        @foreach ($parte->archivos as $img)
                            @if ( in_array($img->archivo->typeFile, $archivosValidosSoloImagenes) && $img->comentarioArchivo != 'firma_digital_bd' )
                                @php
                                    $path = $img->archivo->pathFile;
                                    $rutaModificada = public_path($path);
                                @endphp

                                <!-- Crear una nueva fila cada dos imágenes -->
                                @if ($counter > 0 && $counter % 2 == 0)
                                    </tr><tr>
                                @endif

                                <td style="width: 50%; padding: 10px; text-align: center; vertical-align: top; page-break-inside: avoid;">
                                    <div style="max-width: 300px; max-height: 350px; margin: auto;">
                                        <img 
                                            src="{{ $rutaModificada }}" 
                                            alt="Imagen" 
                                            style="width: 100%; height: 100%; max-height: 290px; object-fit: contain; margin-bottom: 2px; page-break-inside: avoid;"
                                        >
                                        {{-- medir la longitud en caracteres para hacer mas pequeño el comentario si tiene mucho texto --}}
                                        @if ( strlen($img->comentarioArchivo) < 70 )
                                            <p style="font-size: 8px; word-wrap: break-word;">
                                                {{ $img->comentarioArchivo }}
                                            </p>
                                        @elseif ( strlen($img->comentarioArchivo) > 70 )
                                            <p style="font-size: 7px; word-wrap: break-word;">
                                                {{ $img->comentarioArchivo }}
                                            </p>
                                        @endif
                                    </div>
                                </td>

                                @php $counter++; @endphp
                            @endif
                        @endforeach
                        </tr>
                    </table>
                    <p style="margin: 0;">Página <span class="page"></span>{{ $totalPages ?? 0 }}</p>
                </td>
            </tr>
        </table>
        
    </div>

</body>
</html>
