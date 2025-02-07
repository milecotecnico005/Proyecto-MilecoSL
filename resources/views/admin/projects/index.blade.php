<!-- resources/views/admin/projects/index.blade.php -->
@extends('adminlte::page')

@section('title', 'Proyectos')

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
        <div class="card-body">

            <div id="ProjectsGrid" class="ag-theme-quartz" style="height: 90vh; z-index: 0"></div>

            {{-- <table id="ProjectsTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>F.Creación</th>
                        <th>F.Fin</th>
                        <th>Estado</th>
                        <th>F.Creado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        <tr>
                            <td>{{ $project->idProyecto }}</td>
                            <td
                                class="text-truncate"
                                data-fulltext="{{ $project->name }}"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="{{ $project->name }}"
                            >
                                {{ Str::limit($project->name, 5) }}
                            </td>
                            <td
                                class="text-truncate"
                                data-fulltext="{{ $project->description }}"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="{{ $project->description }}"
                            >
                                {{ Str::limit($project->description, 5) }}
                            </td>
                            <td>{{ formatDate($project->start_date) }}</td>
                            <td>{{ ($project->end_date) ? formatDate($project->end_date) : '' }}</td>
                            <td>
                                @if ($project->status == 1)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>{{ formatDate($project->created_at) }}</td>
                            <td>
                                @component('components.actions-button')
                                    <button 
                                        class="btn btn-primary editProject"
                                        data-detalle="{{ $project }}" 
                                        data-project-id="{{ $project->idProyecto }}"
                                        data-bs-placement="top"
                                        data-bs-toggle="tooltip"
                                        title="Editar Proyecto"
                                    >
                                        <ion-icon name="create-outline"></ion-icon>
                                    </button>
                                    <button
                                        class="btn btn-warning addOrders"
                                        data-projectid="{{ $project->idProyecto }}"
                                        data-bs-placement="top"
                                        data-bs-toggle="tooltip"
                                        title="Agregar Ordenes"
                                    >
                                        <ion-icon name="add-circle-outline"></ion-icon>
                                    </button>
                                @endcomponent
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}
        </div>
    </div>

    @component('components.modal-component', [
        'modalId' => 'createProjectModal',
        'modalTitleId' => 'createProjectModalLabel',
        'modalTitle' => 'Crear Proyecto',
        'btnSaveId' => 'btnSaveProject',
        'modalSize' => 'modal-lg',
    ])

        <form id="createProjectForm" action="{{ route('admin.projects.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group required-field">
                    <label class="form-label" for="projectName">Nombre del proyecto</label>
                    <input type="text" class="form-control" id="projectName" name="projectName" required>
                </div>
                <div class="form-group required-field">
                    <label class="form-label" for="projectDescription">Descripción del proyecto</label>
                    <textarea class="form-control" id="projectDescription" name="projectDescription" rows="3"></textarea>
                </div>
                <div class="form-group required-field">
                    <label class="form-label" for="projectStartDate">Fecha de inicio</label>
                    <input type="date" class="form-control" id="projectStartDate" name="projectStartDate" required>
                </div>
                <div class="form-group required-field">
                    <label class="form-label" for="projectEndDate">Fecha de fin</label>
                    <input type="date" class="form-control" id="projectEndDate" name="projectEndDate" required>
                </div>
                <div class="form-group required-field">
                    <label class="form-label" for="projectStatus">Estado</label>
                    <select class="form-control" id="projectStatus" name="projectStatus" required>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
            </div>
        </form>  
        
    @endcomponent

    @component('components.modal-component', [
        'modalId' => 'editProjectModal',
        'modalTitleId' => 'editProjectModalLabel',
        'modalTitle' => 'Editar Proyecto',
        'btnSaveId' => 'btnSaveEditProject',
        'modalSize' => 'modal-lg',
    ])

        <form id="editProjectForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group required-field">
                    <label class="form-label" for="editProjectName">Nombre del proyecto</label>
                    <input type="text" class="form-control" id="editProjectName" name="projectName" required>
                </div>
                <div class="form-group required-field">
                    <label class="form-label" for="editProjectDescription">Descripción del proyecto</label>
                    <textarea class="form-control" id="editProjectDescription" name="projectDescription" rows="3"></textarea>
                </div>
                <div class="form-group required-field">
                    <label class="form-label" for="editProjectStartDate">Fecha de inicio</label>
                    <input type="date" class="form-control" id="editProjectStartDate" name="projectStartDate" required>
                </div>
                <div class="form-group required-field">
                    <label class="form-label" for="editProjectEndDate">Fecha de fin</label>
                    <input type="date" class="form-control" id="editProjectEndDate" name="projectEndDate" required>
                </div>
                <div class="form-group required-field">
                    <label class="form-label" for="editProjectStatus">Estado</label>
                    <select class="form-control" id="editProjectStatus" name="projectStatus" required>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
            </div>
        </form>
        
    @endcomponent

    @component('components.modal-component', [
        'modalId' => 'editParteTrabajoModal',
        'modalTitle' => 'Editar Parte de trabajo',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'saveEditParteTrabajoBtn',
        'modalTitleId' => 'editParteTrabajoTitle',
        'otherButtonsContainer' => 'editParteTrabajoFooter'
    ])
        @include('admin.partes_trabajo.form')
    @endcomponent

    {{-- Modal para mostrar el historial de usos del articulo --}}
    @component('components.modal-component',[
        'modalId' => 'showDetailsModal',
        'modalTitleId' => 'showDetailsModalLabel',
        'modalTitle' => 'Historial de usos',
        'modalSize' => 'modal-xl',
        'hideButton' => true,
    ])

        <div class="row col-sm-12" id="showAccordeons">

        </div>
        
    @endcomponent

     {{-- Modal para detalles del proyecto --}}
     @component('components.modal-component',[
        'modalId'       => 'showProjectDetailsModal',
        'modalTitleId'  => 'showProjectDetailsTitle',
        'modalTitle'    => 'Historial de proyecto',
        'modalSize'     => 'modal-xl',
        'hideButton'    => true,
        'otherButtonsContainer' => 'showProjectDetailsFooter'
    ])
        <div class="row col-sm-12" id="showAccordeonsProject">

        </div>  
    @endcomponent

@stop

@section('css')
    
@stop

@section('js')

@if (session('successEdit'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Proyecto Editado correctamente',
            showConfirmButton: false,
            timer: 1500
        })
    </script>
@endif

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Proyecto creado correctamente',
            showConfirmButton: false,
            timer: 1500
        })
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Algo salió mal',
        })
    </script>

@endif

<script>

    $(document).ready(function() {

        // let table = $('#ProjectsTable').DataTable({
        //     colReorder: {
        //         realtime: false
        //     },
        //     order: [[0, 'desc']],
        //     // responsive: true,
        //     // autoFill: true,
        //     // fixedColumns: true,
        //     dom:    "<'row'<'col-12 col-md-6 col-sm-6 left-buttons'B><'col-12 col-md-6 col-sm-6 d-flex justify-content-end right-filter'f>>" +
        //                 "<'row'<'col-12 col-md-6'l><'d-flex justify-content-end col-12 col-md-6'p>>" + // l para el selector de cantidad de registros
        //                 "<'row'<'col-12'tr>>" +
        //                 "<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",
        //     buttons: [
        //         {
        //             text: 'Crear Proyecto',
        //             className: 'btn btn-outline-warning createProjectBtn mb-2',
        //             action: function ( e, dt, node, config ) {
        //                 $('#createProjectModal').modal('show');
        //             }
        //         }
        //     ],
        //     pageLength: 50,  // Mostrar 50 registros por defecto
        //     lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ], // Opciones para seleccionar cantidad de registros
        //     language: {
        //         processing: "Procesando...",
        //         search: "Buscar:",
        //         lengthMenu: "Mostrar _MENU_ registros por página",
        //         info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
        //         infoEmpty: "Mostrando 0 a 0 de 0 registros",
        //         infoFiltered: "(filtrado de _MAX_ registros totales)",
        //         loadingRecords: "Cargando...",
        //         zeroRecords: "No se encontraron registros coincidentes",
        //         emptyTable: "No hay datos disponibles en la tabla",
        //         paginate: {
        //             first: "Primero",
        //             previous: "Anterior",
        //             next: "Siguiente",
        //             last: "Último"
        //         },
        //         aria: {
        //             sortAscending: ": activar para ordenar la columna en orden ascendente",
        //             sortDescending: ": activar para ordenar la columna en orden descendente"
        //         }
        //     }
        // });

        // function toggleExpandAsunto(element) {
        //     // Obtener el texto completo y truncado del atributo data-fulltext
        //     let fullText = element.getAttribute('data-fulltext');
        //     let truncatedText = fullText.length > 10 ? fullText.substring(0, 10) + '...' : fullText;

        //     // Reemplazar saltos de línea con <br> para renderizar correctamente
        //     fullText = fullText.replace(/\n/g, '<br>');
        //     truncatedText = truncatedText.replace(/\n/g, '<br>');

        //     // Comparar el texto actual con el fulltext para decidir la acción
        //     if (element.innerHTML === fullText) {
        //         element.innerHTML = truncatedText;  // Mostrar truncado
        //     } else {
        //         element.innerHTML = fullText;  // Mostrar completo
        //     }
        // }

        // table.on('click', '.text-truncate', function(e){
        //     toggleExpandAsunto(e.target);
        // });

        // Inicializar la tabla de citas
        const agTablediv = document.querySelector('#ProjectsGrid');

        let rowData = {};
        let data = [];

        const projects = @json($projects);

        const cabeceras = [ // className: 'id-column-class' PARA darle una clase a la celda
            { 
                name: 'ID',
                fieldName: 'project_id',
                addAttributes: true, 
                addcustomDatasets: true,
                dataAttributes: { 
                    'data-id': 'editProjectFast'
                },
                attrclassName: 'editParteTrabajoTable',
                styles: {
                    'cursor': 'pointer',
                    'text-decoration': 'underline'
                },
                principal: true
            },
            { 
                name: 'Nombre',
                fieldName: 'name',
                editable: true,
                addAttributes: true,
                fieldType: 'textarea',
                dataAttributes: { 
                    'data-fulltext': ''
                },
                addcustomDatasets: true,
                customDatasets: {
                    'data-fieldName': "name",
                    'data-type': "text"
                }
            }, 
            { 
                name: 'Descripcion',
                fieldName: 'description',
                editable: true,
                addAttributes: true,
                fieldType: 'textarea',
                dataAttributes: { 
                    'data-fulltext': ''
                },
                addcustomDatasets: true,
                customDatasets: {
                    'data-fieldName': "description",
                    'data-type': "text"
                }
            }, 
            
            { 
                name: 'FInicio', 
                className: 'fecha-alta-column',
                fieldName: 'start_date',
                fieldType: 'date',
                editable: true,

            },
            { 
                name: 'FFin', 
                className: 'fecha-alta-column',
                fieldName: 'end_date',
                fieldType: 'date',
                editable: true,

            },
            { name: 'Estado'  },
            { name: 'Creado'  },
            { name: "Editado" },
            { name: 'Usuario' },
            { 
                name: 'Acciones',
                className: 'acciones-column'
            }
        ];

        function prepareRowData(projects) {
            projects.forEach(project => {
                // console.log(project);
                // if (project.proyecto_n_m_n && project.proyecto_n_m_n.length > 0) {
                //     console.log({proyecto: project.proyecto_n_m_n[0].proyecto.name});
                // }
                rowData[project.idProyecto] = {
                    ID: project.idProyecto,
                    Nombre: project.name,
                    Descripcion: project.description,
                    FInicio: project.start_date,
                    FFin: (project.end_date) ? project.end_date : '',
                    Estado: project.status == 1 ? 'Activo' : 'Inactivo',
                    Creado: project.created_at,
                    Editado: project.updated_at,
                    Usuario: project.usuario.name,
                    Acciones: 
                    `
                        @component('components.actions-button')
                            <button 
                                class="btn btn-outline-primary editProject"
                                data-detalle='${JSON.stringify(project)}'
                                data-project-id="${project.idProyecto}"
                                data-bs-placement="top"
                                data-bs-toggle="tooltip"
                                title="Editar Proyecto"
                            >
                                <div class="d-flex align-items-center justify-content-center flex-column g-1">
                                    <ion-icon name="create-outline"></ion-icon>
                                    <span class="ms-2">Editar</span>
                                </div>
                            </button>
                            <button
                                class="btn btn-warning addOrders"
                                data-projectid="${project.idProyecto}"
                                data-bs-placement="top"
                                data-bs-toggle="tooltip"
                                title="Añadir partes de trabajo"
                            >
                                <div class="d-flex align-items-center justify-content-center flex-column g-1">
                                    <ion-icon name="add-circle-outline"></ion-icon>
                                    <span class="ms-2">Añadir Pts.</span>
                                </div>
                            </button>
                        @endcomponent
                    `
                }
            });

            data = Object.values(rowData);
        }

        prepareRowData(projects);

        const resultCabeceras = armarCabecerasDinamicamente(cabeceras).then(result => {
            const customButtons = `
                <button 
                    class="btn btn-warning"
                    data-bs-placement="top"
                    id="creaProject"
                    data-bs-toggle="tooltip"
                    title="Crear Proyecto"
                >
                    <div class="d-flex align-items-center">
                        <ion-icon name="add-circle-outline"></ion-icon>
                        <span class="ms-2">Crear Proyecto</span>
                    </div>
                </button>
            `;

            // Inicializar la tabla de citas
            inicializarAGtable( agTablediv, data, result, 'Proyectos', customButtons, 'Project');
        });

        let table = $('#ProjectsGrid');

        $('.createProjectBtn').removeClass('dt-button');

        table.on('click','#creaProject', function() {
            $('#createProjectModal').modal('show');
        }); 

        $('#btnSaveProject').click(function() {

            // Validar todos los campos

            const projectName = $('#projectName').val();
            const projectDescription = $('#projectDescription').val();
            const projectStartDate = $('#projectStartDate').val();
            const projectEndDate = $('#projectEndDate').val();
            const projectStatus = $('#projectStatus').val();

            if (projectName === '' || projectDescription === '' || projectStartDate === '' || projectEndDate === '' || projectStatus === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Todos los campos son obligatorios',
                })
                return;
            }

            $('#createProjectForm').submit();
        });

        table.on('click', '.editProject', function() {
            const project = $(this).data('detalle');
            $('#editProjectModal').modal('show');
            $('#editProjectName').val(project.name);
            $('#editProjectDescription').val(project.description);
            $('#editProjectStartDate').val(project.start_date);
            $('#editProjectEndDate').val(project.end_date);
            $('#editProjectStatus').val(project.status);
            $('#editProjectForm').attr('action', '/admin/proyectos/update/' + project.idProyecto);
        });

        $('#btnSaveEditProject').click(function() {
            // Validar todos los campos

            const projectName = $('#editProjectName').val();
            const projectDescription = $('#editProjectDescription').val();
            const projectStartDate = $('#editProjectStartDate').val();
            const projectEndDate = $('#editProjectEndDate').val();
            const projectStatus = $('#editProjectStatus').val();

            if (projectName === '' || projectDescription === '' || projectStartDate === '' || projectEndDate === '' || projectStatus === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Todos los campos son obligatorios',
                })
                return;
            }

            $('#editProjectForm').submit();
        });

        const calculateTotalSum = (parteTrabajoId = null) => {
            let totalSum = 0;
            $('#elementsToShow tr').each(function() {
                const total = parseFloat($(this).find('.material-total').text());
                if (!isNaN(total)) {
                    totalSum += total;
                }
            });
            $('#suma').val(totalSum.toFixed(2));

            if (parteTrabajoId) {
                $.ajax({
                    url: "{{ route('admin.partes.updatesum') }}",
                    method: 'POST',
                    data: {
                        parteTrabajoId: parteTrabajoId,
                        suma: totalSum,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log('Suma actualizada correctamente');
                        } else {
                            console.error('Error al actualizar la suma');
                        }
                    },
                    error: function(err) {
                        console.error(err);
                    }
                });
            }
        };

        const calculatePriceHoraXcantidad = (cantidad_form, precio_form, descuento) => {
            const cantidad = parseFloat(cantidad_form);
            const precio = parseFloat(precio_form);
            const descuentoCliente = parseFloat(descuento);

            if ( !isNaN(cantidad) && !isNaN(precio) ) {
                const total = cantidad * precio;
                if( descuentoCliente == 0 ){
                    // $('#editParteTrabajoModal #precio_hora').val(total.toFixed(2));
                    $('#editParteTrabajoModal #precio_hora').val(0);
                }else{
                    const totalDescuento = total - (total * (descuentoCliente / 100));
                    // $('#editParteTrabajoModal #precio_hora').val(totalDescuento.toFixed(2));
                    $('#editParteTrabajoModal #precio_hora').val(0);
                    $('#editParteTrabajoModal #precioHoraHelp').fadeIn().text(`Precio con descuento del ${descuentoCliente}%`);
                }
            }
        };

        const calculateDifHours = (hora_inicio, hora_fin, itemRender, precio_hora, descuento) => {
            // Obtener los valores de los campos input (hora_inicio y hora_fin)
            let horaInicio = $(hora_inicio).val();
            let horaFin = $(hora_fin).val();

            // Validar si ambos valores existen y no están vacíos
            if (horaInicio && horaFin) {
                // Asegurarse de que las horas estén en el formato correcto (HH:mm)
                const horaInicioFormatted = moment(horaInicio, 'HH:mm');
                const horaFinFormatted = moment(horaFin, 'HH:mm');

                // Verificar si las horas son válidas
                if (horaInicioFormatted.isValid() && horaFinFormatted.isValid()) {
                    // Validar que la hora de fin no sea anterior a la hora de inicio
                    if (horaFinFormatted.isBefore(horaInicioFormatted)) {
                        $(itemRender).val(''); // Limpia el campo de horas trabajadas
                        $(hora_fin).val(''); // Limpia el campo de hora de fin
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'La hora de fin no puede ser anterior a la hora de inicio',
                        });
                        return;
                    }

                    // Calcular la diferencia en milisegundos
                    const duration = moment.duration(horaFinFormatted.diff(horaInicioFormatted));
                    
                    // Convertir la diferencia a horas con decimales
                    const hoursWorked = duration.asHours(); // Ejemplo: 2.5 horas

                    // Asignar la diferencia calculada al elemento de destino como un número
                    $(itemRender).val(hoursWorked.toFixed(2)); // Redondear a 2 decimales

                    calculatePriceHoraXcantidad(hoursWorked, precio_hora, descuento);

                } else {
                    console.error('Las horas proporcionadas no son válidas');
                }
            } else {
                console.error('Debes proporcionar ambas horas: hora de inicio y hora de fin');
            }
        };

        let signaturePad = null;

        // Agregar Ordenes
        table.on('click', '.addOrders', function() {
            const projectId = $(this).data('projectid');
            HandleProjectsPartesAddDelete(projectId);

        });

        // abrir detalles
        table.on('dblclick','.editParteTrabajoTable', function(event){
            const projectid = $(this).data('parteid');
            getDetailsProject(projectid, true);
        });

        // evento cuando el modal se abre
        $('#addOrdersModal').on('show.bs.modal', function() {

            $('#addOrdersModal select.form-select').select2({
                placeholder: 'Seleccione una orden',
                allowClear: true,
                width: '100%',
                dropdownParent: $('#addOrdersModal')

            })

        });

        $('#editParteTrabajoModal').on('show.bs.modal', function() {

            $('#editParteTrabajoModal select.form-select').select2({
                placeholder: 'Seleccione una orden',
                allowClear: true,
                width: '100%',
                dropdownParent: $('#editParteTrabajoModal'),
            })

        });

    });

    
</script>
@stop
