<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class banco_detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'plazo_id',
        'fecha_operacion',
        'concepto',
        'fecha_valor',
        'importe',
        'saldo',
        'banco_id',
        'empresa_id',
        'notas1',
        'notas2',
        'notas3',
        'notas4',
        'fecha_alta',
        'venta_id',
        'compra_id',
    ];

    protected $table = 'banco_details';

    protected $primaryKey = 'id_detail';

    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function plazo()
    {
        return $this->belongsTo(PlazoCompra::class, 'plazo_id');
    }

    public function venta()
    {
        return $this->belongsTo(Ventas::class, 'venta_id');
    }

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'compra_id');
    }

}
