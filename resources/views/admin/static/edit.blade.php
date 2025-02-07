@extends('adminlte::page')

@section('content')
<div class="container my-4">
    <h1>Editar Archivo: {{ $file }}</h1>

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
    
    @php

        if ($folder == ''){
            $folder = '/';
        }
        
    @endphp

    <!-- Formulario para editar el archivo -->
    <form action="{{ route('admin.filemanager.save', ['folder' => urlencode($folder), 'file' => urlencode($file)]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="content">Contenido del archivo</label>
            <textarea id="editor" name="content" class="form-control" rows="50">{{ old('content', $content) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Guardar Cambios</button>
        <a href="{{ route('admin.filemanager.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>

<!-- Código CSS de CodeMirror -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.6/codemirror.min.css">

<!-- Estilos adicionales para los modos (por ejemplo, PHP, JS, CSS) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.6/theme/dracula.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.6/addon/hint/show-hint.min.css">

<!-- Scripts de CodeMirror -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.6/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.6/mode/php/php.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.6/mode/javascript/javascript.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.6/mode/css/css.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.6/addon/hint/show-hint.min.js"></script>

<script>

    let extension = '{{ pathinfo($file, PATHINFO_EXTENSION) }}';

    if (extension == 'php') {
        extension = 'blade';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
            lineNumbers: true,
            mode: extension, // Cambia el modo según el tipo de archivo (php, css, js, etc.)
            theme: "dracula",
            matchBrackets: true,
            autoCloseBrackets: true,
            indentUnit: 10,
            tabSize: 10
        });

        // Sincronizar el contenido del editor con el textarea
        document.querySelector('form').addEventListener('submit', function() {
            // Actualizar el valor del textarea con el contenido del editor
            document.getElementById('editor').value = editor.getValue();
        });

        $('.cm-s-dracula .CodeMirror-gutters, .cm-s-dracula.CodeMirror').css('min-height', '100vh');

    });
</script>

@endsection
