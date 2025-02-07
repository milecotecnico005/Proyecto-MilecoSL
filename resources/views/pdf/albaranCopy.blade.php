<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Albarán: {{ $venta->idVenta }}</title>
    <style>
        body { font-family: sans-serif; }
        .header, .footer {
            text-align: center;
            position: fixed;
            width: 100%;
        }
        .header { top: 0; }
        .footer { bottom: 0; }
        .detailsParts { margin-top: 120px; margin-bottom: 120px; } /* Para evitar solaparse con el header y footer */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        img { max-width: 150px; max-height: 150px; object-fit: contain; }
        .image-cell { text-align: center; padding: 5px; width: 25%; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%">
            <tr>
                <td class="tableInfo" style="width: 50%;">
                    <div class="firstHeader">
                        <h6>Fecha: {{ $venta->FechaVenta }}</h6>
                        <h6>Cliente: {{ $cliente->NombreCliente }}</h6>
                        <p>{{ $cliente->Direccion }}</p>
                        <p>{{ $cliente->CodPostalCliente }} - {{ $cliente->ciudad->nameCiudad }}</p>
                        <p>CIF: {{ $cliente->CIF }}</p>
                    </div>
                </td>
                <td class="tableInfo" style="width: 50%;">
                    <div class="header">
                        <table style="width: 100%">
                            <tr>
                                <td style="width: 30%">
                                    <img src="https://sebcompanyes.com/vendor/adminlte/dist/img/mileco.jpeg" alt="Logo" style="width: 80px; border-radius: 50%">
                                </td>
                                <td style="width: 70%">
                                    <h1 style="text-align: left">Albarán: {{ $venta->idVenta }}</h1>
                                </td>
                            </tr>
                        </table>
                        <div class="contact-info">
                            <p>MILECO S.L.</p>
                            <p>C/ LIBERTADOR SUCRE LOCAL 9, CP:14013-CORDOBA</p>
                            <p>TEL: 957 826 851 | 699 517 143 | Email: milecosl@gmail.com</p>
                            <p>CIF: B1 4450522</p>
                            <h5 style="text-align: center">
                                Construcciones,mantenimentos,fontaneria, electricidad-antena, pintura, reformas
                            </h5>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="detailsParts">
        @foreach ($lineasVenta as $linea)
        <div>
            <div style="width: 50%; float: left;">
                <table>
                    <!-- Tabla de artículos -->
                </table>
            </div>
            <div style="width: 50%; float: right;">
                <table class="image-table">
                    <!-- Imágenes -->
                </table>
            </div>
        </div>
        <div class="page-break"></div>
        @endforeach
    </div>

    <div class="footer">
        <!-- Contenido del pie de página -->
    </div>
</body>
</html>
