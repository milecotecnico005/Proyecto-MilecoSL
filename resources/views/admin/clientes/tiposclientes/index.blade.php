
@extends('adminlte::page')

@section('title', 'Tipos de Clientes')

@section('content_header')
    <h1>Tipos de Clientes</h1>
@stop

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <a id="createNewTypeClient" class="btn btn-outline-primary">Nuevo Tipo de Cliente</a>
            </div>
    
            <div class="card-body">
                <table class="table table-bordered table-hover" id="tiposclientes-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Descuento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tiposclientes as $tipocliente)
                            <tr>
                                <td>{{ $tipocliente->idTiposClientes }}</td>
                                <td>{{ $tipocliente->nameTipoCliente }}</td>
                                <td>{{ $tipocliente->descuento }}%</td>
                                <td>
                                    <a
                                        data-nameTipoCliente="{{ $tipocliente->nameTipoCliente }}" 
                                        data-idTiposClientes="{{ $tipocliente->idTiposClientes }}"
                                        data-descuento="{{ $tipocliente->descuento }}"
                                        href="#" 
                                        class="btn btn-outline-warning btnEditType"
                                        >Editar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Crear nuevo tipo de cliente modal --}}
    @component('components.modal-component',[
        'modalId'       => 'createTypeClientModal',
        'modalSize'     => 'modal-lg',
        'modalTitle'    => 'Nuevo Tipo de Cliente',
        'btnSaveId'     => 'saveTypeClientBtn',
    ])
        <form id="createTypeClientForm" action="{{ route('admin.tiposclientes.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="nameTipoCliente">Nombre</label>
                    <input type="text" class="form-control" id="nameTipoCliente" name="nameTipoCliente" placeholder="Nombre del tipo de cliente">
                </div>
                <div class="form-group">
                    <label for="descuento">Descuento</label>
                    <input type="number" class="form-control" id="descuento" name="descuento" placeholder="Descuento del tipo de cliente">
                </div>
            </div>
        </form>
        
    @endcomponent

    {{-- Modal para editar al tipo de cliente --}}
    @component('components.modal-component',[
        'modalId'       => 'editTypeClientModal',
        'modalSize'     => 'modal-lg',
        'modalTitle'    => 'Editar Tipo de Cliente',
        'btnSaveId'     => 'saveEditTypeClientBtn',
    ])
        <form id="editTypeClientForm"  method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label for="nameTipoCliente">Nombre</label>
                    <input type="text" class="form-control" id="nameTipoClienteEdit" name="nameTipoCliente" placeholder="Nombre del tipo de cliente">
                </div>
                <div class="form-group">
                    <label for="descuento">Descuento</label>
                    <input type="number" class="form-control" id="descuentoEdit" name="descuento" placeholder="Descuento del tipo de cliente">
                </div>
            </div>
        </form>

    @endcomponent


@stop

@section('js')

@if (session('success'))
    <script>
        Swal.fire(
            '¡Guardado!',
            'El tipo de cliente ha sido guardado con éxito.',
            'success'
        );
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire(
            '¡Error!',
            'Ha ocurrido un error al guardar el tipo de cliente.',
            'error',
        );
    </script>
@endif

@if (session('successEdit'))
    <script>
        Swal.fire(
            '¡Guardado!',
            'El tipo de cliente ha sido actualizado con éxito.',
            'success'
        );
    </script>
@endif


<script>

    let table = $('#tiposclientes-table').DataTable({
        colReorder: {
            realtime: false
        },
        responsive: true,
        // autoFill: true,
        // fixedColumns: true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        }
    });

    $('#createNewTypeClient').click(function() {
        $('#createTypeClientModal').modal('show');
    });

    $('#saveTypeClientBtn').click(function() {

        if ( $('#nameTipoCliente').val() == '' || $('#descuento').val() == '' ) {
            Swal.fire(
                '¡Error!',
                'Los campos nombre y descuento son obligatorios.',
                'error'
            );
            return;
        }

        $('#createTypeClientForm').submit();
    });

    // Editar tipo de cliente
    $('.btnEditType').each(function() {
        $(this).click(function() {
            const objeto = $(this)[0];
            let nameTipoCliente = objeto.getAttribute('data-nameTipoCliente');
            let idTiposClientes = objeto.getAttribute('data-idTiposClientes');
            let descuento       = objeto.getAttribute('data-descuento');

            $('#nameTipoClienteEdit').val(nameTipoCliente);
            $('#descuentoEdit').val(descuento);
            $('#editTypeClientForm').attr('action', '/admin/tiposclientes/edit/' + idTiposClientes);
            $('#editTypeClientModal').modal('show');
        });
    });

    $('#saveEditTypeClientBtn').click(function() {

        if ($('#nameTipoClienteEdit').val() == '') {
            Swal.fire(
                '¡Error!',
                'El campo nombre es obligatorio.',
                'error'
            );
            return;
        }

        $('#editTypeClientForm').submit();
    });

    // validar campo descuento no puede ser mayor a 100
    $('#descuento').change(function() {
        console.log($(this).val())
        if (parseInt($(this).val()) > 100) {
            Swal.fire(
                '¡Error!',
                'El descuento no puede ser mayor a 100.',
                'error'
            );
            $(this).val('');
        }
    });
    $('#descuentoEdit').change(function() {
        console.log($(this).val())
        if (parseInt($(this).val()) > 100) {
            Swal.fire(
                '¡Error!',
                'El descuento no puede ser mayor a 100.',
                'error'
            );
            $(this).val('');
        }
    });

</script>

@stop