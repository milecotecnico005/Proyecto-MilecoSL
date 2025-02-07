<form id="ficharArticuloPresu">
    <div class="row">
        <div class="col-md-6 mb-3 required-field">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre">
        </div>
        <div class="col-md-6 mb-3 required-field">
            <label for="ptsCosto" class="form-label">Costo</label>
            <input type="text" class="form-control" id="ptsCosto" name="ptsCosto">
        </div>
        <div class="col-md-4 mb-3 required-field">
            <label for="ptsVenta" class="form-label">Venta</label>
            <input type="text" class="form-control" id="ptsVenta" name="ptsVenta">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3 required-field">
            <label for="Beneficioporcentaje" class="form-label">Beneficio (%)</label>
            <input type="text" class="form-control" id="Beneficioporcentaje" name="Beneficioporcentaje">
        </div>
        <div class="col-md-4 mb-3 required-field">
            <label for="Beneficio" class="form-label">Beneficio</label>
            <input type="text" class="form-control" id="Beneficio" name="Beneficio" readonly>
        </div>
        <div class="col-md-4 mb-3 required-field">
            <label for="total" class="form-label">Total (€)</label>
            <input type="text" class="form-control" id="total" name="total" readonly>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        function calculateTotal() {
            // Formatea el total en euros con 2 decimales
            const venta = parseFloat($('#ficharArticuloPresu #ptsVenta').val()) || 0;
            $('#ficharArticuloPresu #total').val(venta.toFixed(2));
        }

        function calculateFromVenta() {
            // Calcula el beneficio y el porcentaje basado en venta y costo
            const costo = parseFloat($('#ficharArticuloPresu #ptsCosto').val()) || 0;
            const venta = parseFloat($('#ficharArticuloPresu #ptsVenta').val()) || 0;

            if (costo > 0) {
                const beneficio = (venta - costo).toFixed(2);
                const beneficioPorcentaje = ((beneficio / costo) * 100).toFixed(2);

                $('#ficharArticuloPresu #Beneficio').val(parseFloat(beneficio).toFixed(2));
                $('#ficharArticuloPresu #Beneficioporcentaje').val(beneficioPorcentaje);
                calculateTotal();
            }
        }

        function calculateFromBeneficioPorcentaje() {
            // Calcula el precio de venta y el beneficio en euros basado en el porcentaje y costo
            const costo = parseFloat($('#ficharArticuloPresu #ptsCosto').val()) || 0;
            const beneficioPorcentaje = parseFloat($('#ficharArticuloPresu #Beneficioporcentaje').val()) || 0;

            if (costo > 0) {
                const beneficio = ((beneficioPorcentaje / 100) * costo).toFixed(2);
                const venta = (costo + parseFloat(beneficio)).toFixed(2);

                $('#ficharArticuloPresu #Beneficio').val(parseFloat(beneficio).toFixed(2));
                $('#ficharArticuloPresu #ptsVenta').val(venta);
                calculateTotal();
            }
        }

        // Evento cuando cambia el costo
        $('#ficharArticuloPresu #ptsCosto').on('input', function() {
            calculateFromVenta();  // Recalcula desde la venta
        });

        // Evento cuando cambia el precio de venta
        $('#ficharArticuloPresu #ptsVenta').on('input', function() {
            calculateFromVenta();
        });

        // Evento cuando cambia el porcentaje de beneficio
        $('#ficharArticuloPresu #Beneficioporcentaje').on('input', function() {
            calculateFromBeneficioPorcentaje();
        });
    });
</script>
