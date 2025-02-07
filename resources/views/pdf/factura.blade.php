<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ 'Factura '.$id.' '.$cliente->NombreCliente.' '.$fecha.'.pdf' }}</title>
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

        tbody {
            font-size: 9px !important; /* Ajusta el tamaño del texto */
            line-height: 1 !important; /* Reduce la altura de línea */
        }

        tbody tr {
            padding: 0 !important; /* Elimina el relleno de las filas */
        }

        tbody td {
            padding: 2px !important; /* Espaciado interno más pequeño */
            margin: 0 !important; /* Asegúrate de que no haya margen */
            line-height: 1 !important; /* Altura mínima de línea */
        }

        table {
            border-spacing: 0 !important; /* Elimina el espacio entre celdas */
            border-collapse: collapse !important; /* Colapsa bordes para un estilo compacto */
        }

    </style>
</head>
<body>
    <!-- Encabezado organizado en tablas -->
    <div>
        <div class="container header" style="width: 100%; border-collapse: collapse; margin-top: -5px">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%; text-align: start; vertical-align: top;">
                        <p><strong>FECHA:</strong>  {{ $venta->FechaVenta }}</p>
                        <p><strong>No Factura:</strong> {{ $venta->idVenta }}</p>
                        <p><strong>CLIENTE:</strong> {{ $cliente->NombreCliente }} {{ $cliente->ApellidoCliente }}</p>
                        <p><strong>CIF:</strong> {{ $cliente->CIF }}</p>
                        <p><strong>DIRECCIÓN: </strong>{{ $cliente->Direccion }} {{ $cliente->CodPostalCliente }} - {{ $cliente->ciudad->nameCiudad }}</p>
                    </td>
                    <td style="width: 50%; vertical-align: top;">
                        @php
                            $logo = \App\Models\Archivos::where('empresa_id', $venta->empresa_id)->latest()->first()->pathFile;
                        @endphp
                        <img
                            src="{{ public_path($logo) }}"
                            alt="Logo"
                            style="
                                width: 100%; 
                                max-height: 150px;
                                object-fit: contain;
                                margin-bottom: 2px;
                            "
                        />
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="content" style="margin-top: -45px">
            <table class="table sinborde">
                <thead>
                    <tr>
                        <th>Artículo</th>
                        <th>Uni</th>
                        <th>Precio</th>
                        <th>Dto.</th>
                        <th>Importe</th>
                    </tr>
                </thead>
                <tbody style="font-size: 9px !important">
                    @php
                        $currentPage = 1;
                        $linesPerPage = 24; // Número máximo de líneas por página
                        $totalPages = ceil(count($lineasVenta) / $linesPerPage); // Calcula el total de páginas
                        $superaLimite = false;
                    @endphp
        
                    @foreach ($lineasVenta as $index => $linea)
                        <tr style="padding: 1px !important">
                            <td class="font-size: 9px;">
                                <strong>
                                    {{ Str::limit("#".$linea->parte_trabajo." - ".$linea->Descripcion, 210) }}
                                </strong>
                            </td>
                            <td class="font-size: 9px; text-align: right;">{{ $linea->Cantidad }}</td>
                            <td class="font-size: 9px; text-align: right;">{{ number_format($linea->precioSinIva, 2, ',', '.') }} €</td>
                            <td class="font-size: 9px; text-align: right;">{{ number_format($linea->descuento, 2) }}%</td>
                            <td class="font-size: 9px; text-align: right;">{{ number_format($linea->total, 2, ',', '.') }} €</td>
                        </tr>
        
                        {{-- Mostrar el paginador antes del salto de página --}}
                        @if ($loop->iteration == 24 || $loop->iteration == 48 || $loop->iteration == 72 || $loop->iteration == 96 || $loop->iteration == 120 || $loop->iteration == 144 || $loop->iteration == 126 || $loop->iteration == 144 || $loop->iteration == 168 || $loop->iteration == 192)
                            @php
                                $superaLimite = true;
                            @endphp
                            {{-- Mostrar el paginador en la página actual --}}
                            <tr>
                                <td colspan="5" style="text-align: center; font-weight: bold; font-size: 10px !important; padding-top: 10px;">
                                    <p>Factura #{{ $id }} - Página {{ $currentPage }} de {{ $totalPages }}</p>
                                </td>
                            </tr>
                            
                            {{-- Salto de página --}}
                            <tr>
                                <td colspan="5">
                                    <div style="page-break-after: always;"></div>
                                </td>
                            </tr>
                            
                            @php
                                $currentPage++; // Incrementa el contador de página
                            @endphp
                        @endif
                    @endforeach
        
                </tbody>
            </table>
        </div>
        
    
        {{-- Footer con el totalizador --}}
        <div class="footer" style="font-size: 8px !important; margin-top: 10px !important">
            <table class="table" style="width: 50%; text-align: center; border-collapse: collapse; table-layout: auto;">
                <tr>
                    <td style="padding: 0; white-space: nowrap; margin: 0; text-align: center">
                        <h4><strong>Importe:</strong> {{ number_format($venta->TotalFacturaVenta - $venta->TotalIvaVenta, 2, ',', '.') }} €</h4>
                    </td>
                    <td style="padding: 0; white-space: nowrap; margin: 0; text-align: center">
                        <h4><strong>IVA:</strong> {{ number_format($venta->IvaVenta, 2, ',', '.') }} %</h4>
                    </td>
                    <td style="padding: 0; white-space: nowrap; margin: 0; text-align: center">
                        <h4><strong>Total IVA:</strong> {{ number_format($venta->TotalIvaVenta, 2, ',', '.') }} €</h4>
                    </td>
                    <td style="padding: 0; white-space: nowrap; margin: 0; text-align: center">
                        <h4><strong>Total:</strong> {{ number_format($venta->TotalFacturaVenta, 2, ',', '.') }} €</h4>
                    </td>
                </tr>
            </table>
            <table style="width: 100%; border-collapse: collapse; text-align: left; margin-top: 10px">
                <tr>
                    <td style="text-align: center; margin-top: 10px; font-weight: bold; font-size: 10px !important">
                        <p
                            style="text-align: center; font-weight: bold; font-size: 10px !important; padding-top: 10px;"
                        >
                            Factura #{{ $id }} - Página {{ $currentPage }} de {{ $totalPages }}
                        </p>
                    </td>
                </tr>
            </table>
        </div>

        {{-- agregar salto de linea si --}}
        @if (!$superaLimite)
            <div style="page-break-after: always;"></div>
        @endif

    </div>

    @foreach ($lineasVenta as $index => $parte)
        @php
            $indice = $index + 1;
            $parte = $parte->parteTrabajo;
            $lineas = $parte->partesTrabajoLineas;
            $iva = $parte->ivaParte;
            $paginaActual = $indice;
            $totalPaginas = count($lineasVenta);
        @endphp
        <!-- Contenedor principal de cada capítulo -->
        <div class="container header" style="width: 100%; margin-bottom: 5px;">
            <table style="width: 100%; border-collapse: collapse; margin-top: -50px;">
                <tr>
                    <!-- Columna izquierda: Información del trabajo y materiales -->
                    <td style="width: 50%; vertical-align: top; padding-right: 2px;">
                        <div style="margin-bottom: 1px;">
                            {{-- primera columna de detalles y segunda columna con la foto del encabezado --}}
                            <table style="width: 100%;">
                                <tr>
                                    <td style="width: 50%; text-align: start; vertical-align: top;">
                                        <p style="font-weight: bold; font-size: 9px;">Num Trabajo: {{ $parte->idParteTrabajo }}</p>
                                        <p style="font-weight: bold; font-size: 9px;">Fecha: {{ formatDate($parte->FechaVisita) }}</p>
                                        <p style="font-weight: bold; font-size: 9px;">Estado: {{ ($parte->Estado == 3) ? 'Finalizado' : ($parte->Estado == 2 ? 'En proceso' : 'Pendiente') }}</p>
                                        <p style="font-weight: bold; font-size: 9px; word-wrap: break-word;">Cliente: 
                                            {{ $cliente->NombreCliente }} {{ $cliente->ApellidosCliente }}
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
                                            src="{{ public_path($logo) }}"
                                            alt="Logo"
                                            style="
                                                width: 100%; 
                                                max-height: 150px;
                                                object-fit: contain;
                                                margin-bottom: 2px;
                                            "
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
                                                Pagina pertenece a: {{ 'Factura '.$id.' '.$cliente->NombreCliente.' '.$fecha.'.pdf' }} <br>
                                                Página <strong>{{ $paginaActual }} de</strong> <strong>{{ $totalPaginas ?? 0 }}</strong>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
    
                    <!-- Columna derecha: Imágenes -->
                    <td style="width: 50%; vertical-align: top; padding-left: 10px; margin-top: -100px">
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
    
                                    <td style="width: 50%; padding: 10px; text-align: center; vertical-align: top;">
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
                        <p style="margin: 0;">
                            Pagina pertenece a: {{ 'Factura '.$id.' '.$cliente->NombreCliente.' '.$fecha.'.pdf' }} <br>
                            Página <span>{{ $paginaActual }} de</span>{{ $totalPaginas ?? 0 }}
                        </p>
                    </td>
                </tr>
            </table>
            
        </div>


        {{-- verificar si es la ultima iteración para no hacer un salto de linea --}}
        @if ($indice < count($lineasVenta))
            <div style="page-break-after: always;"></div>
        @endif
    @endforeach
    
</body>
</html>
