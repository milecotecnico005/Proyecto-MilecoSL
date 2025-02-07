<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    use HasFactory;

    protected $table = 'bancos';

    protected $primaryKey = 'idbanco';

    protected $fillable = [
        'idBancos',
        'nameBanco',
        'observaciones'
    ];

    public $timestamps = false;

    public function cliente()
    {
        return $this->hasMany(Cliente::class);
    }

    public function banco_detail()
    {
        return $this->hasMany(banco_detail::class, 'banco_id');
    }

}
