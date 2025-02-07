<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    // Tabla asociada
    protected $table = 'proveedores';

    protected $primaryKey = 'idProveedor';

    // Campos que pueden ser rellenados masivamente
    protected $fillable = [
        'cifProveedor',
        'nombreProveedor',
        'direccionProveedor',
        'codigoPostalProveedor',
        'ciudad_id',
        'emailProveedor',
        'agenteProveedor',
        'tipoProveedor',
        'banco_id',
        'Scta_ConInicio',
        'Scta_Contable',
        'observacionesProveedor',
    ];

    public $timestamps = false;

    // Relación con Banco si aplica
    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id');
    }

    // Relación con Ciudad
    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    // Relación con Telefonos de Proveedor
    public function telefonos()
    {
        return $this->hasMany(ProveedorTelefonos::class, 'proveedor_id');
    }

}
