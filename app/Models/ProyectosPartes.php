<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectosPartes extends Model
{
    use HasFactory;

    protected $table = 'proyectos_partes_sl';

    protected $fillable = [
        'proyecto_id',
        'parteTrabajo_id'
    ];

    public $timestamps = false;

    public function parteTrabajo()
    {
        return $this->belongsTo(PartesTrabajo::class, 'parteTrabajo_id', 'idParteTrabajo');
    }

    public function proyecto()
    {
        return $this->belongsTo(Project::class, 'proyecto_id', 'idProyecto');
    }


}
