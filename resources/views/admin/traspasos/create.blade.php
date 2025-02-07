<form method="POST" action="{{ route('admin.traspasos.store') }}">

    @csrf
    <div class="form-group required-field">
        <label class="form-label" for="fecha">Fecha</label>
        <input type="date" class="form-control" id="fecha" name="fecha" required>
    </div>

    <div class="form-group required-field">
        <label class="form-label" for="producto">Producto</label>
        <select class="form-select" id="producto" name="producto" required>
            <option value="">Selecciona un producto</option>
            @foreach ($productos as $producto)
                <option 
                data-articulodesc="{{ $producto }}" 
                data-stock="{{ $producto->stock }}"
                data-emp="{{ $producto->compras->empresa->idEmpresa }}"
                value="{{ $producto->idArticulo }}">{{ $producto->nombreArticulo }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group required-field">
        <label class="form-label" for="origen">Origen</label>
        <select class="form-select" id="origen" name="origen" required readonly>
            <option value="">Selecciona un origen</option>
            @foreach ($almacenes as $almacen)
                <option value="{{ $almacen->idEmpresa }}">{{ $almacen->EMP }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group required-field">
        <label class="form-label" for="destino">Destino</label>
        <select class="form-select" id="destino" name="destino" required>
            <option value="">Selecciona un destino</option>
            @foreach ($almacenes as $almacen)
                <option value="{{ $almacen->idEmpresa }}">{{ $almacen->EMP }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group required-field">
        <label class="form-label" for="cantidad">Cantidad</label>
        <input type="number" class="form-control" id="cantidad" name="cantidad" required readonly>
    </div>


</form>