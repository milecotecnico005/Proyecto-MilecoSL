@extends('adminlte::page')

@section('title', 'Salarios')

@section('content_header')
    <h1>Salarios</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <button 
                type="button" 
                class="btn btn-primary" 
                data-toggle="modal" 
                data-target="#createSalario"
                class="btn btn-primary"
                id="createSalarioBtn"
            >
            Crear Salario
            </button>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="salarios">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Empleado</th>
                        <th>F.Alta</th>
                        <th>F.Baja</th>
                        <th>Salario mensual</th>
                        <th>Salario semanal</th>
                        <th>Salario Hora</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($salarios as $salario)
                        <tr>
                            <td>{{ $salario->salario_id }}</td>
                            <td>{{ $salario->user->name }}</td>
                            <td
                                class="text-center font-weight-bold"
                            >{{ formatDate($salario->f_alta) }}</td>
                            <td
                                class="text-center font-weight-bold"
                            >{{ formatDate($salario->f_baja) }}</td>
                            <td
                                class="text-center font-weight-bold"
                            >{{ $salario->salario_men }}€</td>
                            <td
                                class="text-center font-weight-bold"
                            >{{ $salario->salario_sem }}€</td>
                            <td
                                class="text-center font-weight-bold"
                            >{{ $salario->salario_hora }}€</td>

                            <td
                                class="d-flex justify-content-around flex-wrap"

                            >
                                <button 
                                    class="btn btn-outline-primary editSalarioBtn"
                                    data-info="{{ json_encode($salario) }}"
                                >
                                    Editar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal create salario --}}

    @component('components.modal-component', [
        'modalId' => 'createSalarioModalId',
        'modalSize' => 'modal-xl',
        'modalTitle' => 'Crear Salario',
        'btnSaveId' => 'btnSaveCreateSalario',
    ])

        <form id="formCreateSalario" action="{{ route('admin.salarios.store') }}" method="POST">
            @csrf
            <div class="modal-body">

                <div class="form-group">
                    <label for="user_id">Usuario <span style="color: red">*</span> </label>
                    <select class="form-control" name="user_id" id="user_id">
                        <option value="">Selecciona un usuario</option>
                        @foreach ($usuarios as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="f_alta">Fecha de alta <span style="color: red">*</span></label>
                    <input type="date" name="f_alta" id="f_alta" class="form-control">
                </div>

                <hr>

                <span
                    id="spanError"
                    class="text-center mb-2 font-weight-bold font-italic"
                >Al menos debes llenar alguno de los siguientes campos</span>

                <div class="form-group">
                    <label for="salario_men">Salario mensual</label>
                    <input type="number" name="salario_men" id="salario_men" class="form-control">
                </div>

                <div class="form-group">
                    <label for="salario_sem">Salario semanal</label>
                    <input type="number" name="salario_sem" id="salario_sem" class="form-control">
                </div>

                <div class="form-group">
                    <label for="salario_hora">Salario por hora</label>
                    <input type="number" name="salario_hora" id="salario_hora" class="form-control">
                </div>

            </div>
        </form>

    @endcomponent

    @component('components.modal-component', [
        'modalId' => 'editSalario',
        'modalSize' => 'modal-xl',
        'modalTitle' => 'Editar Salario',
        'btnSaveId' => 'btnSaveEditSalario',
        'modalTitleId' => 'editSalarioTitle',
    ])

        <form id="formEditSalario" action="{{ route('admin.salarios.update', 0) }}" method="POST">
            @csrf
            @method('put')
            <div class="modal-body">

                <div class="form-group">
                    <label for="f_alta">Fecha de alta <span style="color: red">*</span></label>
                    <input type="date" name="f_alta" id="f_alta" class="form-control">
                </div>

                <hr>

                <span
                    id="spanError"
                    class="text-center mb-2 font-weight-bold font-italic"
                >Al menos debes llenar alguno de los siguientes campos</span>

                <div class="form-group">
                    <label for="salario_men">Salario mensual</label>
                    <input type="number" name="salario_men" id="salarario_men" class="form-control">
                </div>

                <div class="form-group">
                    <label for="salario_sem">Salario semanal</label>
                    <input type="number" name="salario_sem" id="salario_sem" class="form-control">
                </div>

                <div class="form-group">
                    <label for="salario_hora">Salario por hora</label>
                    <input type="number" name="salario_hora" id="salario_hora" class="form-control">
                </div>

            </div>
        </form>
        
    @endcomponent

@stop

@section('css')
    
@stop

@section('js')

    @if (session('create') == 'ok')
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Salario creado con éxito',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif

    @if (session('update') == 'ok')
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Salario actualizado con éxito',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif

    @if (session('delete') == 'ok')
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Salario eliminado con éxito',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif

    @if (session('error') == 'ok')
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Algo salió mal',
                footer: '{{ session('error') }}'
            })
        </script>
        
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
            })
        </script>
        
    @endif

    <script>

        let table = $('#salarios').DataTable({
            colReorder: {
                realtime: false
            },
            responsive: true,
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando la página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay información",
                "infoFiltered": "(Filtrado de _MAX_ registros totales)",
                "search": "Buscar:",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Siguiente"
                }
            }
        });

        $('#btnSaveCreateSalario').on('click', function(e) {
            openLoader();
            e.preventDefault();

            let user_id = $('#user_id').val();
            let f_alta = $('#f_alta').val();

            const salarioMEN = $('#createSalarioModalId #salario_men').val();
            const salarioSEM = $('#createSalarioModalId #salario_sem').val();
            const salarioHORA = $('#createSalarioModalId #salario_hora').val();

            // al menos uno de los campos debe estar lleno

            if (salarioMEN == '' && salarioSEM == '' && salarioHORA == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Al menos debes llenar alguno de los siguientes campos: Salario mensual, Salario semanal o Salario por hora',
                })
                return;
            }

            if (user_id == '' || f_alta == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debes llenar los campos obligatorios',
                })
                return 
            }

            $('#createSalarioModalId #formCreateSalario').submit();
        });

        table.on('click', '.editSalarioBtn', function(e) {
            let salario = $(this).data('info');

            $('#editSalario #f_alta').val(salario.f_alta);
            $('#editSalario #salario_men').val(salario.salario_men);
            $('#editSalario #salario_sem').val(salario.salario_sem);
            $('#editSalario #salario_hora').val(salario.salario_hora);

            // mostrar el modal
            $('#editSalario').modal('show');

            $('#editSalario #formEditSalario').attr('action', `/admin/salarios/update/${salario.salario_id}`);
            $('#editSalario #editSalarioTitle').text(`Editar salario de ${salario.user.name}`);

        });

        $('#createSalarioBtn').on('click', function(e) {
            e.preventDefault();
            $('#createSalarioModalId').modal('show');
        });

        $('#btnSaveEditSalario').on('click', function(e) {
            e.preventDefault();
            openLoader();
            let user_id = $('#editSalario #user_id').val();
            let f_alta = $('#editSalario #f_alta').val();

            const salarioMEN = $('#editSalario #salario_men').val();
            const salarioSEM = $('#editSalario #salario_sem').val();
            const salarioHORA = $('#editSalario #salario_hora').val();

            const salario = $('#editSalario #salario').val();

            // al menos uno de los campos debe estar lleno

            if (salarioMEN == '' && salarioSEM == '' && salarioHORA == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Al menos debes llenar alguno de los siguientes campos: Salario mensual, Salario semanal o Salario por hora',
                })
                closeLoader();
                return;
            }

            if (user_id == '' || f_alta == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debes llenar los campos obligatorios',
                })
                closeLoader();
                return 
            }

            $('#editSalario #formEditSalario').submit();
        });
    </script>
@stop