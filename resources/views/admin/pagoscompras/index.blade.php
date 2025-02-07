@extends('adminlte::page')

@section('title', 'Pagos/Cobros')


@section('content')

    <style>
        #tableCard {
            background: rgba( 255, 255, 255, 0.7 );
            box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
            backdrop-filter: blur( 8.5px );
            -webkit-backdrop-filter: blur( 8.5px );
            border-radius: 10px;
            border: 1px solid rgba( 255, 255, 255, 0.18 );
            margin-top: 10px;
        }

        .backgroundImage{
            position: fixed;
            top: -383px;
            right: 0;
            width: 300px;
            height: 100%;
            z-index: 0;
            opacity: 1;
            transform: rotate(-25deg);
        }

    </style>

    <div id="tableCard" class="card">
        <div class="card-header">
            <button id="createPagosComprasBtn" class="btn btn-outline-primary">Crear Pago</button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Pagos/Cobros</h2>
                </div>
            </div>
            <table id="pagoscompras" class="table table-striped table-bordered" style="width:100%">
                <thead class="">
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th>Cliente</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ventas as $venta)
                        <tr>
                            <td>{{ $venta->idVenta }}</td>
                            <td>{{ formatDate($venta->FechaVenta) }}</td>
                            <td>{{ $venta->TotalFacturaVenta }}€ </td>
                            <td>{{ $venta->cliente->NombreCliente }}</td>
                            <td>
                                @component('components.actions-button')
                                    <button class="btn btn-outline-primary" data-venta={{ $venta }}>Detalles</button>
                                    {{-- <form action="{{ route('admin.pagoscompras.destroy', $venta) }}" method="POST">
                                        <a href="{{ route('admin.pagoscompras.show', $venta) }}" class="btn btn-info">Ver</a>
                                        <a href="{{ route('admin.pagoscompras.edit', $venta) }}" class="btn btn-warning">Editar</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form> --}}
                                @endcomponent
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @component('components.modal-component',[
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'btnSaveCreate',
        'modalId' => 'createModal',
        'modalTitle' => 'Crear Pagos/Cobros',
    ])

        <form id="formCreatePagoCobros" action="{{ route('admin.pagoscompras.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="toggleCompraVenta">Venta</label>
                        <input type="checkbox" id="toggleCompraVenta">
                    </div>
                    <div class="form-group compra-selector">
                        <label for="compra_id">Compra</label>
                        <select name="compra_id" id="compra_idCreate" class="form-select" required>
                            <option value="">Seleccione una Compra</option>
                            @foreach ($compras as $compra)
                                <option 
                                    data-empresainfo="{{ $compra->empresa }}" 
                                    data-proveedor="{{ $compra->proveedor }}" 
                                    data-plazos="{{ $compra->plazos }}"
                                    data-compra="{{ $compra }}"
                                    value="{{ $compra->idCompra }}">{{ $compra->NFacturaCompra }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group venta-selector d-none">
                        <label for="venta_id">Venta</label>
                        <select class="form-select" name="venta_id" id="venta_id">
                            <option value="">Seleccione una Venta</option>
                            @foreach ($ventas as $venta)
                                <option data-ventalineas="{{ $venta->ventaLineas }}" value="{{ $venta->idVenta }}">{{ $venta->cliente->NombreCliente }} {{ $venta->cliente->ApellidoCliente }}| Importe: {{ $venta->PendienteVenta }}€ | Venta: {{ $venta->FechaVenta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="empresa_id">Empresa</label>
                        <select name="empresa_id" class="form-select" id="empresa_idCreate">
                            @foreach ($empresas as $empresa)
                                <option value="{{ $empresa->idEmpresa }}">{{ $empresa->EMP }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="proveedor_id">Proveedor</label>
                        <select name="proveedor_id" class="form-select" id="proveedor_idCreate">
                            @foreach ($proveedores as $proveedor)
                                <option value="{{ $proveedor->idProveedor }}">{{ $proveedor->nombreProveedor }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fechaCreate">Fecha</label>
                        <input type="date" id="fechaCreate" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="formapagoCreate">Forma de Pago</label>
                        <select name="formapago" id="formapagoCreate" class="form-select">
                            <option value="1">Banco</option>
                            <option value="2">Efectivo</option>
                        </select>
                    </div>
                    <div class="form-group d-none" id="bancoContainerCreate">
                        <label for="banco_id">Banco</label>
                        <select name="banco_id" id="banco_id" class="form-select">
                            @foreach ($bancos as $banco)
                                <option value="{{ $banco->idbanco }}">{{ $banco->nameBanco }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="importeCreate">Importe</label>
                        <input type="number" name="Importe" id="importeCreate" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Plazos">Plazos</label>
                        <select class="form-control" id="Plazos" name="Plazos" required>
                            <option value="0">Pagado</option>
                            @for ($i = 1; $i <= 24; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fechavenceCreate">Fecha de vencimiento</label>
                        <input type="date" id="fechavenceCreate" class="form-control" placeholder="Ingrese el monto" required>
                    </div>
                    
                    <div class="form-group plazo-fields plazo1 d-none">
                        <label for="proximoPago">Próxima Fecha de Pago</label>
                        <input type="date" class="form-control" id="proximoPago" name="proximoPago">
                    </div>
                    
                    <div class="form-group plazo-fields plazo2 d-none">
                        <label for="frecuenciaPagoCreate">Frecuencia de Pagos</label>
                        <select class="form-control" id="frecuenciaPagoCreate" name="frecuenciaPago">
                            <option value="mensual">Mensual</option>
                            <option value="semanal">Semanal</option>
                            <option value="quincenal">Quincenal</option>
                        </select>
                    </div>
                    <div class="form-group plazo-fields plazo2 d-none">
                        <label for="siguienteCobroCreate">Fecha del Siguiente Cobro</label>
                        <input type="date" class="form-control" id="siguienteCobroCreate" name="siguienteCobro">
                    </div>
                    <div class="form-group">
                        <label for="observacionesCreate">Observaciones</label>
                        <textarea name="" id="observacionesCreate" cols="30" rows="2" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="NAsientoContableCreate">N° Asiento Contable</label>
                        <input type="text" name="NAsientoContable" id="NAsientoContableCreate" class="form-control">
                    </div>
                </div>
            </div>

            <div id="partesTrabajoDetails" class="mt-4">
                <h5>Detalles de Partes de Trabajo</h5>
                <div id="partesTrabajoList"></div>
            </div>
        </form>

    @endcomponent

@stop

@section('css')
    
@stop


@section('js')
    <script>
        $(document).ready(function() {
            let table = $('#pagoscompras').DataTable({
                colReorder: {
                    realtime: false
                },
                // responsive: true,
                // autoFill: true,
                // fixedColumns: true,
                dom:    "<'row'<'col-12 col-md-6 col-sm-6 left-buttons'B><'col-12 col-md-6 col-sm-6 d-flex justify-content-end right-filter'f>>" +
                        "<'row'<'col-12 col-md-6'l><'d-flex justify-content-end col-12 col-md-6'p>>" + // l para el selector de cantidad de registros
                        "<'row'<'col-12'tr>>" +
                        "<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",
                pageLength: 50,  // Mostrar 50 registros por defecto
                lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ], // Opciones para seleccionar cantidad de registros
                buttons: [
                    // {
                    //     text: 'Crear Venta',
                    //     className: 'btn btn-outline-warning createVentaBtn mb-2',
                    //     id: 'createVentaBtn',
                    // }
                ],
                language: {
                    processing: "Procesando...",
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ ",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No se encontraron registros coincidentes",
                    emptyTable: "No hay datos disponibles en la tabla",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Último"
                    },
                    aria: {
                        sortAscending: ": activar para ordenar la columna en orden ascendente",
                        sortDescending: ": activar para ordenar la columna en orden descendente"
                    }
                }
            });

            $('#createPagosComprasBtn').on('click', () => {
                $('#formCreatePagoCobros').trigger('reset');
                $('#partesTrabajoList').empty(); // Limpiar los detalles de partes de trabajo al abrir el modal
                $('#createModal').modal('show');

                $('#compra_idCreate').on('change', () => {
                    const empresa   = $('#compra_idCreate option:selected').data('empresainfo');
                    const proveedor = $('#compra_idCreate option:selected').data('proveedor');
                    let plazos      = $('#compra_idCreate option:selected').data('plazos');
                    const compra    = $('#compra_idCreate option:selected').data('compra');

                    const frecuencia = compra.plazos[0].frecuenciaPago;

                    if (!frecuencia) {
                        $('#frecuenciaPagoCreate').val('');
                        $('#frecuenciaPagoCreate').addClass('d-none');
                    }

                    const plazosArray = JSON.parse(JSON.stringify(plazos), true);

                    if (plazosArray.length <= 1) {
                        plazos = plazos[0];

                        (!plazos.proximoPago)
                            ? $('#fechavenceCreate').val(plazos.fecha_pago)
                            : $('#fechavenceCreate').val(plazos.proximoPago);

                    } else {
                        $('.plazo-fields').removeClass('d-none');

                        $('#Plazos').val(plazosArray.length);

                        let fechaActual = new Date().toISOString().split('T')[0];

                        let proximoPago = plazosArray.find(plazo => {
                            return new Date(plazo.proximoPago) > new Date(fechaActual);
                        });

                        let proximoPagoIndex = plazosArray.findIndex(plazo => {
                            return plazo.proximoPago === proximoPago.proximoPago;
                        });

                        $('#fechavenceCreate').val(proximoPago.proximoPago);
                        $('#proximoPago').val(proximoPago.proximoPago);
                        $('#siguienteCobroCreate').val(plazosArray[proximoPagoIndex + 1].proximoPago);
                        $('#frecuenciaPagoCreate').removeClass('d-none');
                        $('#frecuenciaPagoCreate').val(frecuencia);
                    }

                    const fechaCompra = new Date(compra.fechaCompra).toISOString().split('T')[0];

                    $('#empresa_idCreate').val(empresa.idEmpresa);
                    $('#proveedor_idCreate').val(proveedor.idProveedor);

                    $('#importeCreate').val(compra.totalFactura);
                    $('#fechaCreate').val(fechaCompra);
                    $('#formapagoCreate').val(compra.formaPago);
                    $('#NAsientoContableCreate').val(compra.NAsientoContable);
                });

                $('#toggleCompraVenta').on('change', function() {
                    if ($(this).is(':checked')) {
                        $('.compra-selector').addClass('d-none');
                        $('.venta-selector').removeClass('d-none');
                    } else {
                        $('.compra-selector').removeClass('d-none');
                        $('.venta-selector').addClass('d-none');
                    }
                });

                $('#venta_id').on('change', function() {
                    const ventaLineas = $('#venta_id option:selected').data('ventalineas');
                    $('#partesTrabajoList').empty();

                    if (ventaLineas.length > 0) {
                        ventaLineas.forEach(linea => {
                            $('#partesTrabajoList').append(`
                                <div class="partes-trabajo-item">
                                    <p>ID Parte Trabajo: ${linea.parte_trabajo}</p>
                                    <p>Descripción: ${linea.Descripcion}</p>
                                    <p>Trazabilidad: ${linea.trazabilidad}</p>
                                </div>
                                <hr>
                            `);
                        });
                    } else {
                        $('#partesTrabajoList').append('<p>No hay partes de trabajo relacionados.</p>');
                    }
                });
            });

            $('#Plazos').on('change', () => {
                const plazos = $('#Plazos').val();

                if (plazos == 1) {
                    $('.plazo-fields').addClass('d-none');
                    $('#fechavenceCreate').val('');
                }
            });

            $('#btnSaveCreate').on('click', () => {
                const plazos = $('#Plazos').val();
                
                if (plazos > 1) {
                    const proximoPago = $('#proximoPago').val();
                    const frecuenciaPago = $('#frecuenciaPagoCreate').val();
                    const siguienteCobro = $('#siguienteCobroCreate').val();

                    if (!proximoPago || !frecuenciaPago || !siguienteCobro) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Por favor llene todos los campos',
                        })
                        return;
                    }
                }

                const compra_id = $('#compra_idCreate').val();
                const empresa_id = $('#empresa_idCreate').val();
                const proveedor_id = $('#proveedor_idCreate').val();
                const fecha = $('#fechaCreate').val();
                const formapago = $('#formapagoCreate').val();
                const banco_id = $('#banco_id').val();
                const importe = $('#importeCreate').val();
                const Plazos = $('#Plazos').val();
                const fechavence = $('#fechavenceCreate').val();
                const observaciones = $('#observacionesCreate').val();
                const NAsientoContable = $('#NAsientoContableCreate').val();

                if (!compra_id || !empresa_id || !proveedor_id || !fecha || !formapago || !importe || !Plazos || !fechavence || !observaciones || !NAsientoContable) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Por favor llene todos los campos',
                    })
                    return;
                }

                $('#formCreatePagoCobros').submit();
            });
        });
    </script>
@stop

