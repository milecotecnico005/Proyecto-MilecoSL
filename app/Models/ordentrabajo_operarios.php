<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ordentrabajo_operarios extends Model
{
    use HasFactory;

    protected $table = 'ordentrabajo_operarios';

    protected $fillable = [
        'orden_id',
        'operario_id'
    ];

    public $timestamps = false;

    public function operarios()
    {
        return $this->belongsTo(Operarios::class, 'operario_id');
    }

    public function ordenes()
    {
        return $this->belongsTo(OrdenesTrabajo::class, 'orden_id');
    }

}
