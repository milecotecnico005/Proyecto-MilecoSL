<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEmpresa extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'tiposempresa'; // Asegúrate de que este nombre coincida con el nombre real de tu tabla en la base de datos

    // Llave primaria
    protected $primaryKey = 'idtiposEmpresa';

    // Campos que pueden ser rellenados masivamente
    protected $fillable = [
        'nameTipo',
    ];

    // Relación con la tabla 'empresas'
    public function empresas()
    {
        return $this->hasMany(Empresa::class, 'tipoEmpresa', 'idtiposEmpresa');
    }
}