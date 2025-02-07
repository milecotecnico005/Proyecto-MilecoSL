<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project_orden extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'proyectos_ordenes_sl';

    protected $fillable = [
        'proyecto_id',
        'orden_id'
    ];

    public function proyecto()
    {
        return $this->belongsTo(Project::class, 'proyecto_id', 'idProyecto');
    }

    public function orden()
    {
        return $this->belongsTo(OrdenesTrabajo::class, 'orden_id', 'idOrden');
    }

}
