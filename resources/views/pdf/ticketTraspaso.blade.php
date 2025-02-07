
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TICKET DE Traspaso Nº: {{ $traspaso->id_traspaso }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header, .footer { text-align: center; margin-bottom: 5px; }
        .header h1 { margin: 0; }
        .contact-info { font-size: 12px; margin-top: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        img { width: 100px; height: 100px; margin: 5px; } /* Ajuste del tamaño de las imágenes */
        .image-table {
            width: 100%;
            table-layout: fixed; /* Ayuda a manejar el tamaño de columna consistentemente */
            border: none; /* Elimina los bordes de la tabla */
        }
        .image-cell {
            text-align: center; /* Centra las imágenes en la celda */
            padding: 5px; /* Espaciado alrededor de las imágenes */
            width: 25%; /* Asigna un ancho fijo a cada celda si hay hasta 4 imágenes */
            border: none; /* Elimina los bordes de las celdas */
        }
    </style>
</head>
<body>

    <div class="presupuesto-container">

        <table style="width: 100%;" style="border: none">
            <tr style="border: none">
                <td class="tableInfo" style="width: 50%; border: none">
                    <div class="header">
                        <h4>Traspaso Nº: {{ $traspaso->id_traspaso }}</h4>
                        <div class="contact-info">
                            <p>MILECO S.L.</p>
                            <p>C/ LIBERTADOR SUCRE LOCAL 9, CP:14013-CORDOBA</p>
                            <p>TEL: 957 826 851 | 699 517 143 | Email: milecosl@gmail.com</p>
                            <p>CIF: B1 4450522</p>
                            <strong>Fecha:  {{ $traspaso->fecha_traspaso }}</strong>
                            <strong>Origen: {{ $origen->EMP }} | Destino: {{ $destino->EMP }}</strong>
                            <p>Asunto: Traspaso de {{ $producto->nombreArticulo }}</p>
                        </div>
                    </div>
                </td>
                <td class="tableInfo" style="width: 50%; border: none;">
                    <div style="text-align: center">
                        <h6>Fecha de Traspaso: {{ $fechaHoy }}</h6>
                    </div>
                </td>
            </tr>
        </table>
    
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Fecha</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $traspaso->id_traspaso }}</td>
                    <td>{{ $traspaso->fecha_traspaso }}</td>
                    <td>{{ $traspaso->origen->EMP }}</td>
                    <td>{{ $traspaso->destino->EMP }}</td>
                    <td>{{ $traspaso->articulo->nombreArticulo }}</td>
                    <td>{{ $traspaso->cantidad }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <table>
                <tr>
                    <td style="width: 50%; border: none">
                        <p>Total: {{ number_format($producto->ptsCosto * $traspaso->cantidad, 2) }} €</p>
                    </td>
                    <td style="width: 50%; border: none">
                        <p>TICKET DE TRASPASO</p>
                    </td>
                </tr>
            </table>
        </div>

    </div>
    
</body>
</html>