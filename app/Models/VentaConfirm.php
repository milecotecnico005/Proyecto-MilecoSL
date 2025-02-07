<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaConfirm extends Model
{
    use HasFactory;

    protected $fillable = [
        'venta_id',
        'estado',
        'user_id',
    ];

    protected $primaryKey = 'idVentaConfirm';

    protected $table = 'ventas_confirmadas';

    public function venta()
    {
        return $this->belongsTo(Ventas::class, 'venta_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
