<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresupuestosPartes extends Model
{
    use HasFactory;

    protected $table = 'presupuestos_partes';
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
        'presupuesto_id',
        'trabajo_id',
        'estadoVenta',
        'solucion',
        'hora_inicio',
        'hora_fin',
        'horas_trabajadas',
        'precio_hora',
        'desplazamiento',
        'nombre_firmante'
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

    public function archivosMany()
    {
        return $this->belongsToMany(Archivos::class, 'partestrabajo_sl_has_archivos', 'parteTrabajo_id', 'archivo_id');
    }

    public function presupuesto()
    {
        return $this->belongsTo(Presupuestos::class, 'presupuesto_id', 'idPresupuesto');
    }

    public function trabajo()
    {
        return $this->belongsTo(Trabajos::class, 'trabajo_id', 'idTrabajo');
    }
    
}
