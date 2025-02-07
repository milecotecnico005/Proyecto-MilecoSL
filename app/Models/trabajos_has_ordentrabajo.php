<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trabajos_has_ordentrabajo extends Model
{
    use HasFactory;

    protected $table = 'trabajos_has_ordentrabajo';

    protected $fillable = [
        'trabajo_id',
        'orden_id'
    ];

    public $timestamps = false;

    public function trabajos()
    {
        return $this->belongsTo(Trabajos::class, 'trabajo_id');
    }

    public function ordenes()
    {
        return $this->belongsTo(OrdenesTrabajo::class, 'orden_id');
    }

}
