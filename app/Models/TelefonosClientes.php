<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelefonosClientes extends Model
{
    use HasFactory;

    protected $table = 'telefonosclientes';

    protected $primaryKey = 'idTelefonoCliente';

    protected $fillable = [
        'Clientes_idClientes',
        'telefono',
    ];

    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

}
