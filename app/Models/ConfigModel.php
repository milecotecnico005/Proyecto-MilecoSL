<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'telegram_config';

    protected $fillable = [
        'avisos',
        'compras',
        'partes',
        'created_at',
        'updated_at',
    ];

}
