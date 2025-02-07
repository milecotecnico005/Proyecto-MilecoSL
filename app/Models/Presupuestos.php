<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuestos extends Model
{
    use HasFactory;

    protected $table = 'presupuestos_sl';

    protected $primaryKey = 'idParteTrabajo';

    protected $fillable = [
        'Asunto',
        'FechaAlta',
        'FechaVisita',
        'Estado',
        'cliente_id',
        'Departamento',
        'Observaciones',
        'NFactura',
        'suma',
        'orden_id',
        'trabajo_id',
        'estadoVenta',
        'condiciones_generales'
    ];

    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'idClientes');
    }

    public function partesTrabajoLineas()
    {
        return $this->hasMany(PresupuestosLineas::class, 'parteTrabajo_id', 'idParteTrabajo');
    }

    public function archivos()
    {
        return $this->hasMany(PresupuestosArchivos::class, 'parteTrabajo_id', 'idParteTrabajo');
    }

    public function trabajo()
    {
        return $this->belongsTo(PresupuestosTrabajos::class, 'trabajo_id', 'idTrabajo');
    }

    public function anexos()
    {
        return $this->hasMany(PresupuestosAnexos::class, 'presupuesto_id', 'idParteTrabajo');
    }

    public function partesPresu()
    {
        return $this->hasMany(PresupuestosPartes::class, 'presupuesto_id', 'idParteTrabajo');
    }


}
