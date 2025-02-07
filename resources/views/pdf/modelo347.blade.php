<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ 'Modelo347_'.$year."CIF".$cliente->CIF."_".$cliente->NombreCliente."_".$cliente->ApellidoCliente.".PDF" }}</title>
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

    </style>
</head>
<body>

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
                                    <p style="font-weight: bold; font-size: 9px;">MODELO 347</p>
                                    <p style="font-weight: bold; font-size: 9px;">AÑO: {{ $year }}</p>
                                </td>
                                <td style="width: 50%; vertical-align: top;">
                                    @php
                                        $logo = $empresa->archivos()->latest()->first()->pathFile;
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
                    <hr>
                    <div style="margin-top: -50px;">
                        <div class="content" style="text-align: left; margin-bottom: 20px; margin-top: -8px">
                            <p style="font-weight: bold; font-size: 9px; word-wrap: break-word;">Nombre y CIF:
                               {{ $cliente->CIF }} {{ $cliente->NombreCliente }} {{ $cliente->ApellidosCliente }}
                            </p>
                        </div>

                        <table style="width: 100%; border-collapse: collapse; margin-top: -10px">
                            <thead>
                                
                            </thead>
                            <tbody>          
                                @php
                                    $ventasPorTrimestre = [
                                        1 => 0, // 1er Trimestre
                                        2 => 0, // 2º Trimestre
                                        3 => 0, // 3er Trimestre
                                        4 => 0  // 4º Trimestre
                                    ];

                                    $totalAnual = 0;
                                @endphp

                                @foreach ($ventas as $venta)
                                    @php
                                        $ventasPorTrimestre[$venta->trimestre] += $venta->total;
                                        $totalAnual += $venta->total;
                                    @endphp
                                @endforeach

                                @foreach ($ventasPorTrimestre as $trimestre => $totalTrimestre)
                                    <tr>
                                        <td style="font-size: 7px;">Declarado {{ $trimestre }}º Trimestre {{ $year }} {{ number_format($totalTrimestre, 2, ',', '.') }} €</td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <td style="padding-top: 10px; border-top: 1px solid #000; font-size: 7px;">Total Anual: {{ $year }}: {{ number_format($totalAnual, 2, ',', '.') }} €</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <div class="footerPartes sinborder" style="margin-top: 10px; font-size: 9px;">
                            <table class="sinborder" style="width: 100%">
                                <strong style="font-weight: bold; font-size: 13px; word-wrap: break-word;">
                                    @php
                                        // buscar en el array de $ventas el ultimo elemento que su propiedad notasmodelo347 no sea null
                                        $notas = '';
                                        foreach ($ventas as $venta) {
                                            if ($venta->notasmodelo347 != null) {
                                                $notas = $venta->notasmodelo347;
                                            }
                                        }
                                    @endphp
                                    {{ $notas }}
                                </strong>
                            </table>
                        </div>
                    </div>
                </td>

                <!-- Columna derecha: Imágenes -->
                <td style="width: 50%; vertical-align: top; padding-left: 10px; margin-top: -100px">
                    <table style="width: 100%; text-align: center; border-collapse: collapse;">
                        
                    </table>
                    
                </td>
            </tr>
        </table>
        
    </div>

</body>
</html>
