@extends('adminlte::page')

@section('title', 'Compras')


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
            border: 1px solid rgb(25, 135, 84);
            /* min-height: 100vh; */
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

        .container{
            background: var(--ligth) !important;
        }
        

    </style>

    <div id="tableCard" class="card p-4">
        <div class="card-body">

            <div class="container card">
                <!-- Formulario para subir el logo -->
                <div class="row mb-4" style="border-radius: 10px;">
                    <form id="form-upload-logo" method="POST" action="{{ route('admin.empresas.uploadLogo') }}" enctype="multipart/form-data" class="p-4 bg-light rounded shadow-sm">
                        @csrf
                        
                        <div class="row mb-3 card-body" style="border-radius: 10px;">
                            <!-- Selector de empresa -->
                            <div class="form-group col-md-6 d-flex flex-column">
                                <label for="empresa-select" class="form-label fw-bold">Selecciona la empresa</label>
                                <select
                                    class="form-select"
                                    name="empresa_id"
                                    id="empresa-select"
                                    aria-label="Seleccionar empresa"
                                    required
                                >
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->idEmpresa }}">{{ $empresa->EMP }}</option> 
                                    @endforeach
                                </select>
                            </div>
            
                            <!-- Input para subir el logo -->
                            <div class="form-group col-md-6">
                                <label for="logo" class="form-label fw-bold">Subir Logo</label>
                                <input type="file" name="logo" id="logo" accept="image/*" class="form-control" required>
                            </div>
                        </div>
                        
                        <!-- Botón para subir -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-warning fw-bold px-4">Subir Logo</button>
                        </div>
                    </form>
                </div>
            
                <!-- Vista previa del logo -->
                <div class="row mt-2 mb-4">
                    <div class="col-md-6 mx-auto text-center">
                        <h5 class="fw-bold mb-3">Logo actual:</h5>
                        <img 
                            id="logo-preview" 
                            src="" 
                            alt="Logo de la empresa" 
                            class="img-fluid border rounded shadow-sm" 
                            style="max-width: 200px; height: auto;"
                        >
                    </div>
                </div>
            </div>

            <hr>

            <div class="container card">
                <!-- Formulario para subir el logo -->
                <div class="row mb-4 card-body">
                    <form action="{{ route('admin.configApp.ImportComprasVentas') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="file">Importar datos</label>
                            <input type="file" name="file" required class="form-control">
                        </div>

                        <div class="form-group">
                            <button 
                                type="submit"
                                class="btn btn-outline-primary"
                            >
                                <div class="d-flex justify-content-center align-items-center">
                                    <ion-icon name="cloud-upload-outline"></ion-icon>
                                    <span class="ms-2">Importar Datos</span>
                                </div>
                            </button>
                        </div>

                        <div class="form-group">
                            <a 
                                type="submit"
                                class="btn btn-outline-success"
                                href="{{ route('admin.configApp.downloadFormat') }}"
                            >
                                <div class="d-flex justify-content-center align-items-center">
                                    <ion-icon name="download-outline"></ion-icon>
                                    <span class="ms-2">Descargar Formato</span>
                                </div>
                            </a>
                        </div>
                        
                    </form>
                </div>
            

            </div>
            
            <hr>

            <div class="row d-flex justify-content-start align-items-top align-content-top flex-wrap flex-row gap-4">
                {{-- Tarjeta para configurar canal de avisos entrantes con IONIC ICONS --}}
                @component('components.card-tracker-component', [
                    'id' => 'avisosEntrantes',
                    'title' => 'Avisos Entrantes',
                    'description' => 'Configura el canal de avisos entrantes',
                    'icon' => 'alert-circle-outline',
                    'subtitle' => 'Configuración de avisos',
                    'iconTitle' => 'code-outline',
                ])
                    
                @endcomponent

                @component('components.card-tracker-component-compras', [
                    'id' => 'compras',
                    'title' => 'Compras',
                    'description' => 'Configura el canal de avisos entrantes',
                    'icon' => 'cart-outline',
                    'subtitle' => 'Configuración de Compras',
                    'iconTitle' => 'code-outline',
                ])
                    
                @endcomponent

                @component('components.card-tracker-component-partes', [
                    'id' => 'partes',
                    'title' => 'Partes',
                    'description' => 'Configura el canal de avisos entrantes',
                    'icon' => 'document-text-outline',
                    'subtitle' => 'Configuración de Partes',
                    'iconTitle' => 'code-outline',
                ])
                    
                @endcomponent
            </div>
            
        </div>
    </div>

    {{-- Modal para configuraciones --}}
    @component('components.modal-component',[
        'modalId' => 'ModalConfig',
        'modalTitleId' => 'ModalConfigTitle',
        'modalTitle' => 'Configuración de ...',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'btnModalConfig',
    ])

        <div class="ConfigContainer">

        </div>
        
    @endcomponent


@stop

@section('js')

    <script>
        $(document).ready(function () {

            // eventos para abrir modales
            $('#avisosEntrantes').on('click', function () {
                
                $.ajax({
                    url: "{{ route('admin.configApp.getCongif') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        config: 'avisos'
                    },
                    beforeSed: function () {
                        openLoader();
                    },
                    success: function (response) {
                        
                        closeLoader();

                        $('#ModalConfig').modal('show');
                        $('#ModalConfigTitle').text('Configuración de Avisos Entrantes');

                        const canalId = response.data.avisos
                        const historial = response.historial

                        // crear formulario dinamico
                        $('#ModalConfig .ConfigContainer').empty().html(`
                            <div class="form-group">
                                <label for="exampleInputEmail1">Selecciona el canal de telegram</label>
                                <select class="form-select" name="telegram" aria-label="Default select example" id="CanalAsignacionesSelect">
                                    @foreach ($canales as $canal)
                                        <option data-tipo="avisos" value="{{ $canal->chat_id }}">{{ $canal->name }} {{ $canal->chat_id }}</option>
                                    @endforeach
                                </select>
                                <small id="emailHelp" class="form-text text-muted">Al canal que selecciones se enviarán las notificaciones</small>
                            </div>
                            <hr>
                            <div class="form-group" style="max-height: 350px; overflow-y:scroll">
                                <label for="exampleInputEmail1">Historial de asignaciones</label>
                                <ul class="list-group">
                                    ${historial.map(item => {
                                        const fechaFormateada = new Date(item.created_at).toLocaleString();
                                        return `<li class="list-group-item">${item.name} - ${fechaFormateada}</li>`
                                    })}
                                </ul>    
                            </div>
                        `);

                        // buscar el nombre de canal "chat_id" dentro del select
                        $('#CanalAsignacionesSelect').val(canalId);

                    },
                    error: function (error) {
                        closeLoader();
                        showToast('Error al cargar la configuración', 'error');
                    },
                });

            });

            // eventos para abrir modales
            $('#compras').on('click', function () {
                
                $.ajax({
                    url: "{{ route('admin.configApp.getCongif') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        config: 'compras'
                    },
                    beforeSed: function () {
                        openLoader();
                    },
                    success: function (response) {
                        
                        closeLoader();

                        $('#ModalConfig').modal('show');
                        $('#ModalConfigTitle').text('Configuración de Compras');

                        const canalId = response.data.compras
                        const historial = response.historial

                        // crear formulario dinamico
                        $('#ModalConfig .ConfigContainer').empty().html(`
                            <div class="form-group">
                                <label for="exampleInputEmail1">Selecciona el canal de telegram</label>
                                <select class="form-select" name="telegram" aria-label="Default select example" id="CanalAsignacionesSelect">
                                    @foreach ($canales as $canal)
                                        <option data-tipo="compras" value="{{ $canal->chat_id }}">{{ $canal->name }} {{ $canal->chat_id }}</option>
                                    @endforeach
                                </select>
                                <small id="emailHelp" class="form-text text-muted">Al canal que selecciones se enviarán las notificaciones</small>
                            </div>
                            <hr>
                            <div class="form-group" style="max-height: 350px; overflow-y:scroll">
                                <label for="exampleInputEmail1">Historial de asignaciones</label>
                                <ul class="list-group">
                                    ${historial.map(item => {
                                        const fechaFormateada = new Date(item.created_at).toLocaleString();
                                        return `<li class="list-group-item">${item.name} - ${fechaFormateada}</li>`
                                    })}
                                </ul>
                            </div>
                        `);

                        // buscar el nombre de canal "chat_id" dentro del select
                        $('#CanalAsignacionesSelect').val(canalId);

                    },
                    error: function (error) {
                        closeLoader();
                        showToast('Error al cargar la configuración', 'error');
                    },
                });

            });

            // eventos para abrir modales
            $('#partes').on('click', function () {
                
                $.ajax({
                    url: "{{ route('admin.configApp.getCongif') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        config: 'partes'
                    },
                    beforeSed: function () {
                        openLoader();
                    },
                    success: function (response) {
                        
                        closeLoader();

                        $('#ModalConfig').modal('show');
                        $('#ModalConfigTitle').text('Configuración de Partes');

                        const canalId = response.data.partes

                        // crear formulario dinamico
                        $('#ModalConfig .ConfigContainer').empty().html(`
                            <div class="form-group">
                                <label for="exampleInputEmail1">Selecciona el canal de telegram</label>
                                <select class="form-select" name="telegram" aria-label="Default select example" id="CanalAsignacionesSelect">
                                    @foreach ($canales as $canal)
                                        <option data-tipo="partes" value="{{ $canal->chat_id }}">{{ $canal->name }} {{ $canal->chat_id }}</option>
                                    @endforeach
                                </select>
                                <small id="emailHelp" class="form-text text-muted">Al canal que selecciones se enviarán las notificaciones</small>    
                            </div>
                            <hr>
                            <div class="form-group" style="max-height: 350px; overflow-y:scroll">
                                <label for="exampleInputEmail1">Historial de asignaciones</label>
                                <ul class="list-group">
                                    ${response.historial.map(item => {
                                        const fechaFormateada = new Date(item.created_at).toLocaleString();
                                        return `<li class="list-group-item">${item.name} - ${fechaFormateada}</li>`
                                    })}
                                </ul>
                            </div>
                        `);

                        // buscar el nombre de canal "chat_id" dentro del select
                        $('#CanalAsignacionesSelect').val(canalId);
                    },
                    error: function (error) {
                        closeLoader();
                        showToast('Error al cargar la configuración', 'error');
                    },
                });

            });

            // escuchar evento de cuando se abre el modal
            $('#ModalConfig').on('shown.bs.modal', function (e) {
                // inicializar select2
                $('select').select2({
                    width: '100%',
                    dropdownParent: $('#ModalConfig')  // Asocia el dropdown con el modal para evitar problemas de superposición
                });

                // evento change del select
                $('#ModalConfig #CanalAsignacionesSelect').off('change').on('change', function () {
                    const chatId = $(this).val();
                    const tipo = $(this).find(':selected').data('tipo');
                    const destino = $(this).find(':selected').text();

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: `El canal ${tipo} va a cambiar al canal ${destino} ¿Deseas guardar la configuración?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, guardar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('admin.configApp.saveConfig') }}",
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    chatId: chatId,
                                    tipo: tipo
                                },
                                beforeSend: function () {
                                    openLoader();
                                },
                                success: function (response) {
                                    closeLoader();
                                    showToast('Realizado Correctamente', 'success');

                                    // cambiar el valor del select
                                    $('#ModalConfig #CanalAsignacionesSelect').val(chatId);

                                    // cerrar el modal
                                    $('#ModalConfig').modal('hide');

                                },
                                error: function (error) {
                                    closeLoader();
                                    showToast('Error al actualizar el comentario', 'error');
                                },
                            });
                        }
                    });
                    
                });
                

            });
        
        });

    </script>

    <script>
        $(document).ready(function () {

            $('#empresa-select').select2({
                width: '100%',
            });

            $('#empresa-select').on('change', function () {
                const empresaId = $(this).val();
                
                if (empresaId) {
                    // Solicitar el logo al servidor
                    $.ajax({
                        url: `/admin/empresas/${empresaId}/logo`,
                        type: 'GET',
                        beforeSed: function () {
                            openLoader();
                        },
                        success: function (response) {
                            closeLoader();
                            if (response.status) {
                                $('#logo-preview').attr('src', response.logo);
                            }

                            // si no tiene logo, eliminar el src del logo
                            if (!response.status) {
                                $('#logo-preview').attr('src', '');
                            }

                        },
                        error: function () {
                            closeLoader();
                            Swal.fire({
                                icon: 'error',
                                title: '¡Error!',
                                text: 'No se pudo cargar el logo de la empresa',
                            });
                        }
                    });
                }
            });

            // Disparar el evento `change` al cargar para mostrar el logo inicial
            $('#empresa-select').trigger('change');
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire(
                '¡Éxito!',
                '{{ session('success') }}',
                'success'
            );
        </script>
    @endif
@stop

