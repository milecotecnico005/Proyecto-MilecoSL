@extends('adminlte::page')

@section('title', 'Backups')

@section('content')

    <div id="" class="card mt-2">
        <div class="card-header">
            <h3 class="card-title">Backups</h3>
        </div>

        <div class="card-body">
            <h4>Cantidad de tablas: {{ $tables }}</h4>

            {{-- descargar backup .sql --}}
            <a href="{{ route('admin.backups.generate') }}" target="_blank" class="btn btn-outline-primary">Descargar SQL</a>

            <hr>

            {{-- Importar la base de datos --}}
            <form action="{{ route('admin.backups.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="sql_file">Selecciona un archivo .sql:</label>
                <input class="form-control" type="file" name="sql_file" id="sql_file" accept=".sql">
                <button type="submit" class="btn btn-outline-primary mt-2">Importar</button>
            </form>

        </div>


    </div>

   

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')


    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif

@endsection