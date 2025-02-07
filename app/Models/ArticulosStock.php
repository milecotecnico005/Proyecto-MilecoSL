<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticulosStock extends Model
{
    use HasFactory;

    protected $table = 'articulos_stock_sl';

    protected $primaryKey = 'idStok';

    protected $fillable = [
        'articulo_id',
        'ultimaCompraDate',
        'existenciasMin',
        'cantidad',
        'existenciasMax',
        'created_at',
        'updated_at',
    ];

    public function articulo()
    {
        return $this->belongsTo(Articulos::class, 'articulo_id');
    }

}
