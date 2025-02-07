<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresupuestosAnexos extends Model
{
    use HasFactory;

    protected $table = 'presupestos_sl_anexos';

    protected $primaryKey = 'idanexo';

    protected $fillable = [
        'presupuesto_id',
        'num_anexo',
        'value_anexo',
    ];

    public $timestamps = false;

    public function presupuesto()
    {
        return $this->belongsTo(Presupuestos::class, 'presupuesto_id', 'idParteTrabajo');
    }
}
