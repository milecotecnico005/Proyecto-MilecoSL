<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    use HasFactory;

    protected $table = 'ciudades';
    protected $primaryKey = 'idCiudades';
    protected $fillable = ['idCiudades', 'nameCiudad'];
    public $timestamps = false;

    // Definimos la relación inversa con el modelo Cliente
    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'ciudad_id', 'idCiudades');
    }
}
