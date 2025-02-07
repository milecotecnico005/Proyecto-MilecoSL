<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trabajos_has_operarios extends Model
{
    use HasFactory;

    protected $table = 'trabajos_has_operarios';

    protected $fillable = [
        'trabajos_idTrabajo',
        'operarios_idOperario'
    ];

    public $timestamps = false;

    public function trabajos()
    {
        return $this->belongsTo(Trabajos::class);
    }

    public function operarios()
    {
        return $this->belongsTo(Operarios::class);
    }

}
