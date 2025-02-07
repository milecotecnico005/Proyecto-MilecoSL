@extends('adminlte::page')

@section('content')
<div class="card mt-2">

    <style>
        .breadcrumb-item a:hover {
            text-decoration: underline !important;
        }
        .breadcrumb-item ion-icon {
            font-size: 1.2rem;
            vertical-align: middle !important;
        }
    </style>
    
    <div class="card-header">
        <h1>Gestor de Archivos</h1>

        <nav class="mt-2" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.filemanager.index') }}">Inicio</a>
                </li>
                @foreach($breadcrumbs as $breadcrumb)
                    <li class="breadcrumb-item">
                        <a href="{{ $breadcrumb['path'] }}">
                            <ion-icon name="{{ $breadcrumb['icon'] }}"></ion-icon> {{ $breadcrumb['name'] }}
                        </a>
                    </li>
                @endforeach
            </ol>
        </nav>
    </div>

    <div class="card-body">
        
        <!-- Alertas de éxito/error -->
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Formulario para subir archivos -->
        <div class="row">
            <div class="col-md-6">
                <h3>Subir archivo</h3>
                <form action="{{ route('admin.filemanager.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">Seleccionar archivo</label>
                        <input type="file" class="form-control" id="file" name="file" required>
                    </div>
                    <div class="form-group mt-2">
                        <button type="submit" class="btn btn-primary">Subir</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lista de Carpetas y Archivos -->
        <div class="row">
            <!-- Lista de Carpetas -->
            <div class="col-md-4">
                <h3>Carpetas</h3>
                <ul class="list-group">
                    @foreach ($directories as $directory)
                        @php
                            $directoryPath = $folder ? $folder . '/' . basename($directory) : basename($directory);
                        @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.filemanager.index', ['folder' => $directoryPath]) }}" class="text-decoration-none">
                                <ion-icon name="folder"></ion-icon> {{ Str::limit(basename($directory), 10) }} 
                            </a>
                            <!-- Opcional: Botón de eliminar carpeta -->
                            <form action="{{ route('admin.filemanager.deleteFolder', $directoryPath) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <ion-icon name="trash"></ion-icon>
                                    Eliminar
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Lista de Archivos -->
            <div class="col-md-8">
                <h3>Archivos</h3>
                <ul class="list-group">
                    @foreach ($files as $file)
                        @php
                            $fileName = basename($file);
                            $folder = $folder ? $folder : '';
                            $folderEncoded = urlencode($folder);
                            $fileEncoded = urlencode($fileName);
                        @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a style="word-wrap: break-word;" href="{{ route("admin.filemanager.download") }}?folder={{ $folderEncoded }}&file={{ $fileEncoded }}" class="text-decoration-none" target="_blank">
                                <ion-icon name="document"></ion-icon> {{ $fileName }}
                            </a>
                            
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <!-- Botón de Editar -->
                                @if(in_array(pathinfo($fileName, PATHINFO_EXTENSION), ['php', 'css', 'js', 'html', 'txt', '.env', '.gitignore', 'json', 'md', 'xml', 'yml', 'yaml', '.htaccess']))
                                    <a href="{{ route("admin.filemanager.edit") }}?folder={{ $folder }}&file={{ $fileName }}" class="btn btn-outline-warning btn-sm">
                                        <ion-icon name="create"></ion-icon>
                                        Editar
                                    </a>
                                @endif

                                <!-- Opcional: Botón de eliminar archivo -->
                                <form action="{{ route('admin.filemanager.delete', ['file' => $fileName, 'folder' => $folder]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <ion-icon name="trash"></ion-icon>
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Lista de archivos de laravel --}}
            <div class="row">
                <div class="col-md-4 mt-3">
                    <h3>Archivos de Aplicación</h3>
                    <ul class="list-group">
                        @foreach ($laravelDirectories as $directory)
                            @php
                                $directoryPath = $folder ? $folder . '/' . basename($directory) : basename($directory);
                            @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{ route('admin.filemanager.index', ['folder' => $directoryPath, 'laravelPath' => 'laravelApp']) }}" class="text-decoration-none">
                                    <ion-icon name="folder"></ion-icon> {{ Str::limit(basename($directory), 10) }} 
                                </a>
                                <!-- Opcional: Botón de eliminar carpeta -->
                                <form action="{{ route('admin.filemanager.deleteFolder', $directoryPath) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <ion-icon name="trash"></ion-icon>
                                        Eliminar
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Lista de Archivos -->
                <div class="col-md-8 mt-3">
                    <h3>Archivos</h3>
                    <ul class="list-group">
                        @foreach ($laravelFiles as $file)
                            @php
                                $fileName = basename($file);
                                $folder = $folder ? $folder : '/';
                                $folderEncoded = urlencode($folder);
                                $fileEncoded = urlencode($fileName);
                            @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a style="word-wrap: break-word;" href="{{ route("admin.filemanager.download") }}?folder={{ $folderEncoded }}&file={{ $fileEncoded }}" class="text-decoration-none" target="_blank">
                                    <ion-icon name="document"></ion-icon> {{ $fileName }}
                                </a>
                                
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <!-- Botón de Editar -->
                                    @if(in_array(pathinfo($fileName, PATHINFO_EXTENSION), ['php', 'css', 'js', 'html', 'txt', '.env', '.gitignore', 'json', 'md', 'xml', 'yml', 'yaml', '.htaccess']))
                                        <a href="{{ route("admin.filemanager.edit") }}?folder={{ $folder }}&file={{ $fileName }}&laravelApp=laravelApp" class="btn btn-outline-warning btn-sm">
                                            <ion-icon name="create"></ion-icon>
                                            Editar
                                        </a>
                                    @endif

                                    <!-- Opcional: Botón de eliminar archivo -->
                                    <form action="{{ route('admin.filemanager.delete', ['file' => $fileName, 'folder' => $folder]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <ion-icon name="trash"></ion-icon>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>


        </div>
    </div>

</div>
@endsection
