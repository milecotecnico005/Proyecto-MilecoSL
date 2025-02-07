@extends('adminlte::page')

@section('title', 'Stock')

@section('content_header')
    <h1>Stock</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: flex-start; flex-direction: column">
        <p>Lista de articulos</p>
    </div>
    <div class="card-body p-4">
        <table class="table table-striped" id="articlesTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Trazabilidad</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articulos as $articulo)
                    <tr>
                        <td>{{ $articulo->idArticulo }}</td>
                        <td>{{ $articulo->nombreArticulo }}</td>
                        <td>{{ $articulo->TrazabilidadArticulos }}</td>
                        <td>{{ ($articulo->stock) ? $articulo->stock->cantidad : '' }}</td>
                        <td>
                            <button 
                                data-id="{{ $articulo->idArticulo }}"
                                data-name="{{ $articulo->nombreArticulo }}"
                                data-trazabilidad="{{ $articulo->TrazabilidadArticulos }}"
                                data-stockinfo="{{ $articulo->stock }}"
                                data-empresainfo="{{ $articulo->empresa }}"
                                data-categoriainfo="{{ $articulo->categoria }}"
                                data-proveedorinfo="{{ $articulo->proveedor }}"
                                data-ptscosto="{{ $articulo->ptsCosto }}"
                                data-ptsventa="{{ $articulo->ptsVenta }}"
                                data-beneficio="{{ $articulo->Beneficio }}"
                                data-subctainicio="{{ $articulo->SubctaInicio }}"
                                data-observaciones="{{ $articulo->observaciones }}"
                                class="btn btn-outline-secondary editArticle">
                                Editar
                            </button>
                            <button 
                                data-id="{{ $articulo->idArticulo }}"
                                data-name="{{ $articulo->nombreArticulo }}"
                                data-trazabilidad="{{ $articulo->TrazabilidadArticulos }}"
                                data-stockinfo="{{ $articulo->stock }}"
                                data-empresainfo="{{ $articulo->empresa }}"
                                data-categoriainfo="{{ $articulo->categoria }}"
                                data-proveedorinfo="{{ $articulo->proveedor }}"
                                data-ptscosto="{{ $articulo->ptsCosto }}"
                                data-ptsventa="{{ $articulo->ptsVenta }}"
                                data-beneficio="{{ $articulo->Beneficio }}"
                                data-subctainicio="{{ $articulo->SubctaInicio }}"
                                data-observaciones="{{ $articulo->observaciones }}"
                                class="btn btn-outline-primary detallesArticle">
                                Detalles
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">

@stop

@section('js')
    <script>
        let table = $('#articlesTable').DataTable({
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

    </script>
@stop