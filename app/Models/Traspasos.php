<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traspasos extends Model
{
    use HasFactory;

    protected $table = 'traspasos_sl';

    protected $primaryKey = 'id_traspaso';

    protected $fillable = [
        'fecha_traspaso',
        'origen_id',
        'destino_id',
        'articulo_id',
        'articulo_traspasado',
        'cantidad',
    ];

    public $timestamps = false;

    public function origen()
    {
        return $this->belongsTo(Empresa::class, 'origen_id', 'idEmpresa');
    }

    public function destino()
    {
        return $this->belongsTo(Empresa::class, 'destino_id', 'idEmpresa');
    }

    public function articulo()
    {
        return $this->belongsTo(Articulos::class, 'articulo_id', 'idArticulo');
    }

    public function articuloTraspasado()
    {
        return $this->belongsTo(Articulos::class, 'articulo_traspasado', 'idArticulo');
    }

}
