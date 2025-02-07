<table>
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Trimestre</th>
            <th>Total (€)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ventas as $venta)
        <tr>
            <td>{{ $venta->cliente->NombreCliente }}</td>
            <td>{{ $venta->trimestre }}</td>
            <td>{{ $venta->total }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
