<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartesTrabajoLineas extends Model
{
    use HasFactory;
    
    protected $table = 'materialesempleados_sl';

    protected $primaryKey = 'idMaterial';

    protected $fillable = [
        'articulo_id',
        'cantidad',
        'precioSinIva',
        'descuento',
        'total',
        'Trazabilidad',
        'parteTrabajo_id',
        'user_create',
        'order'
    ];

    public $timestamps = false;

    public function parteTrabajo()
    {
        return $this->belongsTo(PartesTrabajo::class, 'parteTrabajo_id', 'idParteTrabajo');
    }

    public function articulo()
    {
        return $this->belongsTo(Articulos::class, 'articulo_id', 'idArticulo');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

}
