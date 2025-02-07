<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresupuestosArchivos extends Model
{
    use HasFactory;

    protected $table = 'presupuesto_sl_has_archivos';

    protected $fillable = [
        'parteTrabajo_id',
        'archivo_id',
    ];

    public $timestamps = false;

    public function parteTrabajo()
    {
        return $this->belongsTo(Presupuestos::class, 'parteTrabajo_id', 'idOrdenTrabajo');
    }

    public function archivo()
    {
        return $this->belongsTo(Archivos::class, 'archivo_id', 'idArchivos');
    }
}
