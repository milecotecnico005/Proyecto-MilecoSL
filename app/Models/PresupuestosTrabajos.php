<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresupuestosTrabajos extends Model
{
    use HasFactory;

    protected $table = 'presupestos_sl_trabajos';

    protected $primaryKey = 'idTrabajoPresu';

    public $timestamps = false;

    protected $fillable = [
        'presupuesto_id',
        'trabajo_id',
    ];

}
