<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineasVentas extends Model
{
    use HasFactory;

    protected $table = 'ventas_lineas_sl';

    protected $primaryKey = 'idLineaVenta';

    protected $fillable = [
        'Descripcion',
        'Cantidad',
        'precioSinIva',
        'descuento',
        'total',
        'venta_id',
        'proyecto_id',
        'orden_trabajo',
        'parte_trabajo',
        'tipo_orden',
        'observaciones'
    ];

    public $timestamps = false;

    public function venta()
    {
        return $this->belongsTo(Ventas::class, 'venta_id', 'idVenta');
    }

    public function ordenTrabajo()
    {
        return $this->belongsTo(OrdenesTrabajo::class, 'orden_trabajo', 'idOrdenTrabajo');
    }

    public function proyecto()
    {
        return $this->belongsTo(Project::class, 'proyecto_id', 'idProyecto');
    }

    public function parteTrabajo()
    {
        return $this->belongsTo(PartesTrabajo::class, 'parte_trabajo', 'idParteTrabajo');
    }


}
