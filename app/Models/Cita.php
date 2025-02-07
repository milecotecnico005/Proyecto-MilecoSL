<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';

    protected $primaryKey = 'idCitas';

    protected $fillable = [
        'fechaDeAlta',
        'asunto',
        'tipoCita',
        'user_id',
        'estado',
        'enlaceDoc',
        'cliente_id'
    ];

    public $timestamps = false;

    public function archivos()
    {
        return $this->belongsToMany(Archivos::class, 'citas_archivos', 'cita_id', 'archivo_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function ordenes()
    {
        return $this->hasMany(OrdenesTrabajo::class, 'cita_id');
    }

}
