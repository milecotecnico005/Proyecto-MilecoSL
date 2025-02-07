<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lineasCompras extends Model
{
    use HasFactory;

    protected $table = 'lineascompras_sl';

    protected $primaryKey = 'idLinea';

    protected $fillable = [
        'idCompra',
        'proveedor_id',
        'descripcion',
        'cantidad',
        'precioSinIva',
        'descuento',
        'total',
        'trazabilidad',
        'compra_id',
        'RAE',
        'articulo_id',
        'cod_proveedor',
        'user_create',
    ];

    public $timestamps = false;

    // Relación con el modelo Compra
    public function compra()
    {
        return $this->belongsTo(Compra::class, 'compra_id', 'idCompra');
    }

    // Relación con el modelo Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id', 'idProveedor');
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
