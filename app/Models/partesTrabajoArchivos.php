<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partesTrabajoArchivos extends Model
{
    use HasFactory;

    protected $table = 'partestrabajo_sl_has_archivos';

    protected $fillable = [
        'parteTrabajo_id',
        'archivo_id',
        'comentarioArchivo'
    ]; 

    public $timestamps = false;

    public function parteTrabajo()
    {
        return $this->belongsTo(PartesTrabajo::class, 'parteTrabajo_id', 'idOrdenTrabajo');
    }

    public function archivo()
    {
        return $this->belongsTo(Archivos::class, 'archivo_id', 'idArchivos');
    }

}
