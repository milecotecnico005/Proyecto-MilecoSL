<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulos extends Model
{
    use HasFactory;

    protected $table = 'articulos_sl';

    protected $primaryKey = 'idArticulo';

    protected $fillable = [
        'categoria_id',
        'nombreArticulo',
        'ptsCosto',
        'ptsVenta',
        'Beneficio',
        'empresa_id',
        'proveedor_id',
        'SubctaInicio',
        'TrazabilidadArticulos',
        'compra_id',
        'Observaciones',
        'created_at',
        'updated_at',
    ];

    public function categoria()
    {
        return $this->belongsTo(ArticulosCategorias::class, 'categoria_id');
    }

    public function stock()
    {
        return $this->hasOne(ArticulosStock::class, 'articulo_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function compras()
    {
        return $this->belongsTo(Compra::class, 'compra_id');
    }

    public function imagenes()
    {
        // muchos a muchos
        return $this->belongsToMany(Archivos::class, 'articulosImagenes', 'articulo_id', 'archivo_id');
    }

}
