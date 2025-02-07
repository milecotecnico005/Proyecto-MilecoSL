<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $primaryKey = 'idClientes';

    protected $fillable = [
        'CIF',
        'NombreCliente',
        'ApellidoCliente',
        'Direccion',
        'CodPostalCliente',
        'ciudad_id',
        'EmailCliente',
        'Agente',
        'TipoClienteId',
        'banco_id',
        'SctaContable',
        'Observaciones',
        'user_id',
        'notas1',
        'notas2',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_Id', 'idCiudades');
    }

    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id', 'idbanco');
    }

    public function tipoCliente()
    {
        return $this->belongsTo(TipoCliente::class, 'TipoClienteId', 'idTiposClientes');
    }

    public function telefonos()
    {
        return $this->hasMany(TelefonosClientes::class, 'Clientes_idClientes');
    }
    

}
