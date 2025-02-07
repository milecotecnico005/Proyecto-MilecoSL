<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salario extends Model
{
    use HasFactory;

    protected $table = 'salarios_sl';

    protected $primaryKey = 'salario_id';

    protected $fillable = [
        'user_id',
        'f_alta',
        'f_baja',
        'salario_men',
        'salario_sem',
        'salario_hora',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
