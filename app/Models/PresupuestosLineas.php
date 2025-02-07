<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresupuestosLineas extends Model
{
    use HasFactory;
    
    protected $table = 'materialesempleadospresupuesto_sl';

    protected $primaryKey = 'idMaterial';

    protected $fillable = [
        'articulo_id',
        'cantidad',
        'precioSinIva',
        'descuento',
        'total',
        'Trazabilidad',
        'parteTrabajo_id',
    ];

    public $timestamps = false;

    public function parteTrabajo()
    {
        return $this->belongsTo(Presupuestos::class, 'parteTrabajo_id', 'idParteTrabajo');
    }

    public function articulo()
    {
        return $this->belongsTo(Articulos::class, 'idArticulos', 'articulo_id');
    }

    public function articuloPDF()
    {
        return $this->belongsTo(Articulos::class, 'articulo_id', 'idArticulo' );
    }
}
