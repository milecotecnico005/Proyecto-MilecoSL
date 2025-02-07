<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class citas_archivos extends Model
{
    use HasFactory;

    protected $table = 'citas_archivos';

    protected $fillable = [
        'archivo_id',
        'cita_id',
        'comentarioArchivo',
    ];

    public $timestamps = false;

}
