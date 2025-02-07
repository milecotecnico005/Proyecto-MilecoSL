<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trabajos_archivos extends Model
{
    use HasFactory;

    protected $table = 'trabajos_archivos';

    protected $fillable = [
        'orden_id',
        'archivo_id',
        'comentarioArchivo'
    ];

    public $timestamps = false;

    public function archivos()
    {
        return $this->belongsTo(Archivos::class, 'archivo_id', 'idarchivos');
    }

    public function ordenes()
    {
        return $this->belongsTo(OrdenesTrabajo::class, 'orden_id', 'id');
    }

}
