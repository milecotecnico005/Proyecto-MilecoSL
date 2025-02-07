<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartesTrabajo extends Model
{
    use HasFactory;

    protected $table = 'partestrabajo_sl';
    protected $primaryKey = 'idParteTrabajo';

    // la primary key no es autoincremental
    public $incrementing = false;

    protected $fillable = [
        'idParteTrabajo',
        'Asunto',
        'FechaAlta',
        'FechaVisita',
        'Estado',
        'cliente_id',
        'Departamento',
        'Observaciones',
        'NFactura',
        'descuentoParte',
        'suma',
        'orden_id',
        'trabajo_id',
        'estadoVenta',
        'solucion',
        'hora_inicio',
        'hora_fin',
        'horas_trabajadas',
        'precio_hora',
        'desplazamiento',
        'nombre_firmante',
        'notas1',
        'notas2',
        'tituloParte',
        'totalParte',
        'ivaParte'
    ];

    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'idClientes');
    }

    public function partesTrabajoLineas()
    {
        return $this->hasMany(PartesTrabajoLineas::class, 'parteTrabajo_id', 'idParteTrabajo')
                    ->orderBy('order');
    }

    public function archivos()
    {
        return $this->hasMany(partesTrabajoArchivos::class, 'parteTrabajo_id', 'idParteTrabajo');
    }

    public function archivosMany()
    {
        return $this->belongsToMany(Archivos::class, 'partestrabajo_sl_has_archivos', 'parteTrabajo_id', 'archivo_id');
    }

    public function trabajo()
    {
        return $this->belongsTo(Trabajos::class, 'trabajo_id', 'idTrabajo');
    }

    public function proyectoNMN()
    {
        return $this->hasMany(ProyectosPartes::class, 'parteTrabajo_id', 'idParteTrabajo');
    }

    public function orden()
    {
        return $this->belongsTo(OrdenesTrabajo::class, 'orden_id', 'idOrdenTrabajo');
    }


}
