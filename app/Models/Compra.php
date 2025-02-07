<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'compras_sl';
    protected $primaryKey = 'idCompra';
    protected $fillable = [
        'fechaCompra', 'empresa_id', 'NFacturaCompra', 'proveedor_id', 'formaPago', 
        'Importe', 'Iva', 'totalIva', 'retencionesCompras', 'totalRetenciones',
        'totalFactura', 'suplidosCompras', 'NAsientoContable', 'ObservacionesCompras', 'Plazos',
        'totalExacto',
        'notas1', 'notas2', 'tipo_doc'
    ];

    // Relación con el modelo Empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'idEmpresa');
    }

    // Relación con el modelo Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id', 'idProveedor');
    }

    // Relación con el modelo Archivo
    public function archivos()
    {
        return $this->belongsToMany(Archivos::class, 'compras_sl_has_archivos', 'compra_id', 'archivo_id');
    }

    // Relación con el modelo PlazoCompra
    public function plazos()
    {
        return $this->hasMany(PlazoCompra::class, 'compra_id', 'idCompra');
    }

    // Relación con el modelo lineasCompras
    public function lineas()
    {
        return $this->hasMany(lineasCompras::class, 'compra_id', 'idCompra');
    }

    public function pagosCompras(){
        return $this->hasMany(PagosCompras::class, 'compra_id', 'idCompra');
    }

}
