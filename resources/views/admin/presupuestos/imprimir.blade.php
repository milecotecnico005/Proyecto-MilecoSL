<form id="imprimirForm" action="{{ route('admin.presupuestos.generarPDF') }}">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <select class="form-control" name="presupuestos[]" id="presupuestosSelect" multiple="multiple">
                    <option value="">Seleccione uno o más presupuesto/s</option>
                    @foreach($presupuestos as $presupuesto)
                        <option value="{{ $presupuesto->idParteTrabajo }}">{{ $presupuesto->Asunto }} | {{ $presupuesto->FechaAlta }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-outline-primary sendToImprimirPresupuestosBtn">Imprimir</button>
            </div>
        </div>
    </div>
</form>