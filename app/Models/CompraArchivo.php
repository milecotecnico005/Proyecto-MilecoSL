<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprasArchivo extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'compras_sl_has_archivos';

    // No tiene clave primaria auto-incremental, especificamos la clave primaria compuesta
    protected $primaryKey = ['compra_id', 'archivo_id'];
    public $incrementing = false;
    public $timestamps = false;

    // Definir los campos que pueden ser asignados masivamente
    protected $fillable = ['compra_id', 'archivo_id'];

    // Relación con el modelo Compra
    public function compra()
    {
        return $this->belongsTo(Compra::class, 'compra_id', 'idCompra');
    }

    // Relación con el modelo Archivo
    public function archivo()
    {
        return $this->belongsTo(Archivos::class, 'archivo_id', 'idarchivos');
    }
}