<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    // Tabla asociada
    protected $table = 'empresas';

    // Llave primaria
    protected $primaryKey = 'idEmpresa';

    // Campos que pueden ser rellenados masivamente
    protected $fillable = [
        'añoEmpresa',
        'EMP',
        'tipoEmpresa',
        'observacionesEmpresa',
    ];

    public $timestamps = false;

    // Relación con la tabla 'tiposEmpresa'
    public function tipo()
    {
        return $this->belongsTo(TipoEmpresa::class, 'tipoEmpresa', 'idtiposEmpresa');
    }

    public function archivos()
    {
        return $this->hasMany(Archivos::class, 'empresa_id');
    }

}
