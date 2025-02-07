<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCliente extends Model
{
    use HasFactory;

    protected $table = 'tiposclientes';

    protected $primaryKey = 'idTiposClientes';

    protected $fillable = [
        'idTiposClientes',
        'nameTipoCliente',
        'descuento'
    ];

    public $timestamps = false;

    public function cliente()
    {
        return $this->hasMany(Cliente::class);
    }

}
