<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlazoCompra extends Model
{
    use HasFactory;

    protected $table = 'plazos_compras_sl';
    protected $primaryKey = 'plazo_id';
    protected $fillable = [
        'frecuenciaPago',
        'fecha_pago',
        'estadoPago',
        'proximoPago',
        'venta_id',
        'compra_id',
        'userAction',
        'banco_id',
        'notas1',
        'notas2',
    ];

    // Relación con el modelo Compra
    public function compra()
    {
        return $this->belongsTo(Compra::class, 'compra_id', 'idCompra');
    }

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'userAction', 'id');
    }

    // Relación con el modelo Banco
    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id', 'idbanco');
    }

}