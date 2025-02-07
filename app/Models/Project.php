<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'proyectos_sl';

    protected $primaryKey = 'idProyecto';

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'user_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function partes()
    {
        return $this->belongsToMany(PartesTrabajo::class, 'proyectos_partes_sl', 'proyecto_id', 'parteTrabajo_id');
    }

    public function ordenes()
    {
        return $this->belongsToMany(OrdenesTrabajo::class, 'proyectos_ordenes_sl', 'proyecto_id', 'orden_id');
    }

}
