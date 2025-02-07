<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticulosCategorias extends Model
{
    use HasFactory;

    protected $table = 'articulos_categorias_sl';

    protected $primaryKey = 'idArticuloCategoria';

    protected $fillable = [
        'nameCategoria',
    ];

    public $timestamps = false;

}
