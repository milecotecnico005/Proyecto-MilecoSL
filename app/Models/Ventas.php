<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    use HasFactory;

    protected $table = 'ventas_sl';

    protected $primaryKey = 'idVenta';

    protected $fillable = [
        'FechaVenta',
        'empresa_id',
        'archivoId',
        'AgenteVenta',
        'EnviadoVenta',
        'cliente_id',
        'FormaPago',
        'ImporteVenta',
        'IvaVenta',
        'TotalIvaVenta',
        'RetencionesVenta',
        'TotalRetencionesVenta',
        'TotalFacturaVenta',
        'SuplidosVenta',
        'Plazos',
        'Cobrado',
        'PendienteVenta',
        'NAsientoContable',
        'Observaciones',
        'created_at',
        'updated_at',
        'notas1',
        'notas2',
        'notasmodelo347',
        'tipo_movimiento',
        'correo',
        'agente',
        'tipo_doc',
        'num_fac'
    ];

    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'idClientes');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'idEmpresa');
    }

    public function empresaAlbaran()
    {
        return $this->belongsTo(Empresa::class, 'idEmpresa', 'empresa_id');
    }

    public function plazo()
    {
        return $this->belongsTo(PlazoCompra::class, 'idVenta', 'venta_id');
    }

    public function archivo()
    {
        return $this->belongsTo(Archivos::class, 'archivoId', 'idArchivo');
    }

    public function ventaLineas()
    {
        return $this->hasMany(LineasVentas::class, 'venta_id', 'idVenta');
    }

    public function ventaConfirm()
    {
        return $this->hasOne(VentaConfirm::class, 'venta_id');
    }

}
