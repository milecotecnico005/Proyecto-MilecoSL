<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticulosImagenes extends Model
{
    use HasFactory;

    protected $table = 'articulosImagenes';

    protected $primaryKey = 'id';

    protected $fillable = [
        'archivo_id',
        'articulo_id',
        'comentarioArchivo',
    ];

    public $timestamps = false;

    public function articulo()
    {
        return $this->belongsTo(Articulos::class, 'articulo_id');
    }

    public function archivo()
    {
        return $this->belongsTo(Archivos::class, 'archivo_id');
    }

}
