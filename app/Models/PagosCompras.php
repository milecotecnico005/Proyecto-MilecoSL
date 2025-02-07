<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagosCompras extends Model
{
    use HasFactory;

    protected $table = 'pagoscompras_sl';

    protected $primaryKey = 'idPagosCompras';

    protected $fillable = [
        'compra_id',
        'empresa_id',
        'proveedor_id',
        'FechaPagosCompras',
        'FechaVencimientoPagosCompras',
        'FormaPago',
        'banco_id',
        'Importe',
        'plazos_id',
        'Observaciones',
        'NAsientoContable'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id', 'idProveedores');
    }

    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id', 'idBancos');
    }

    public function plazos()
    {
        return $this->belongsTo(PlazoCompra::class, 'plazos_id', 'idPlazos');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'idEmpresas');
    }


}
