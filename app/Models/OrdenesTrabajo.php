<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenesTrabajo extends Model
{
    use HasFactory;

    protected $table = 'ordentrabajo';

    protected $primaryKey = 'idOrdenTrabajo';

    protected $fillable = [
        'Asunto',
        'FechaAlta',
        'FechaVisita',
        'Estado',
        'cliente_id',
        'Departamento',
        'Observaciones',
        'trabajo_id',
        'cita_id',
        'presupuesto_id',
        'hora_inicio',
        'hora_fin',
        'notas1',
        'notas2',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function trabajo()
    {
        return $this->belongsToMany(Trabajos::class, 'trabajos_has_ordentrabajo', 'orden_id', 'trabajo_id');
    }

    public function operarios()
    {
        return $this->belongsToMany(Operarios::class, 'ordentrabajo_operarios', 'orden_id', 'operario_id');
    }

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'cita_id');
    }

    public function archivos()
    {
        return $this->belongsToMany(Archivos::class, 'trabajos_archivos', 'orden_id', 'archivo_id');
    }

    public function presupuesto()
    {
        return $this->belongsTo(Presupuestos::class, 'presupuesto_id');
    }

    public function telefonosClientes()
    {
        return $this->hasMany(TelefonosClientes::class, 'Clientes_idClientes', 'cliente_id');
    }

    public function partesTrabajo()
    {
        return $this->hasMany(PartesTrabajo::class, 'orden_id', 'idOrdenTrabajo');
    }

    public function proyecto(){
        return $this->belongsToMany(Project::class, 'proyectos_ordenes_sl', 'orden_id', 'proyecto_id');
    }

    public $timestamps = false;

}
