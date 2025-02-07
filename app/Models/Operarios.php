<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operarios extends Model
{
    use HasFactory;

    protected $table = 'operarios';

    protected $primaryKey = 'idOperario';

    protected $fillable = [
        'user_id',
        'nameOperario',
        'emailOperario',
        'telefonoOperario'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trabajos()
    {
        return $this->belongsToMany(Trabajos::class, 'trabajos_has_operarios', 'operarios_idOperario', 'trabajos_idTrabajo');
    }

    public function salario()
    {
        return $this->hasOne(Salario::class, 'user_id', 'user_id');
    }

}
