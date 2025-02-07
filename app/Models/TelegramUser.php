<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelegramUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'telegram_id',          // ID de Telegram del usuario
        'telegram_group_id',    // ID del grupo de Telegram
        'first_name',           // Nombre del usuario
        'last_name',            // Apellido del usuario
        'username',             // Nombre de usuario de Telegram
    ];

    public function groups()
    {
        return $this->belongsToMany(TelegramGroup::class, 'group_user');
    }
}
