<form action="{{ route('admin.articulos.store') }}" method="POST">
    @csrf
    <div class="container">
        <!-- Primera fila: Campos de información básica -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre">
            </div>
            <div class="col-md-4 mb-3">
                <label for="ptsCosto" class="form-label">Costo</label>
                <input type="text" class="form-control" id="ptsCosto" name="ptsCosto">
            </div>
            <div class="col-md-4 mb-3">
                <label for="ptsVenta" class="form-label">Venta</label>
                <input type="text" class="form-control" id="ptsVenta" name="ptsVenta">
            </div>
        </div>

        <!-- Segunda fila: Beneficio y selecciones de empresa, categoría y proveedor -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="Beneficio" class="form-label">Beneficio</label>
                <input type="text" class="form-control" id="Beneficio" name="Beneficio" readonly>
            </div>
            <div class="col-md-4 mb-3">
                <label for="empresa_id" class="form-label">Empresa</label>
                <select class="form-select" id="empresa_id" name="empresa_id">
                    @foreach ($empresas as $empresa)
                        <option value="{{ $empresa->idEmpresa }}">{{ $empresa->EMP }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="categoria_id" class="form-label">Categoría</label>
                <select class="form-select" id="categoria_id" name="categoria_id">
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->idArticuloCategoria }}">{{ $categoria->nameCategoria }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Tercera fila: Selección de proveedor y trazabilidad -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="proveedor_id" class="form-label">Proveedor</label>
                <select class="form-select" id="proveedor_id" name="proveedor_id">
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->idProveedor }}">{{ $proveedor->nombreProveedor }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="TrazabilidadArticulos" class="form-label">Trazabilidad</label>
                <select class="form-select" id="TrazabilidadArticulos" name="TrazabilidadArticulos">
                    @foreach ($trazabilidades as $trazabilidad)
                        <option value="{{ $trazabilidad->compra_id }}">{{ $trazabilidad->trazabilidad }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Cuarta fila: Información adicional (subcta inicio, última compra, existencias) -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="SubctaInicio" class="form-label">Subcta Inicio</label>
                <input type="text" class="form-control" id="SubctaInicio" name="SubctaInicio">
            </div>
            <div class="col-md-4 mb-3">
                <label for="ultimaCompraDate" class="form-label">Última Compra</label>
                <input type="date" class="form-control" id="ultimaCompraDate" name="ultimaCompraDate">
            </div>
            <div class="col-md-4 mb-3">
                <label for="existenciasMin" class="form-label">Existencias Mínimas</label>
                <input type="number" class="form-control" id="existenciasMin" name="existenciasMin">
            </div>
        </div>

        <!-- Quinta fila: Existencias máximas y cantidad -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="existenciasMax" class="form-label">Existencias Máximas</label>
                <input type="number" class="form-control" id="existenciasMax" name="existenciasMax">
            </div>
            <div class="col-md-4 mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad">
            </div>
        </div>

        <!-- Última fila: Observaciones -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea placeholder="Observaciones" class="form-control" name="observaciones" id="observaciones" cols="40" rows="3"></textarea>
            </div>
        </div>
    </div>
</form>
