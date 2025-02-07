<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelegramGroup extends Model
{
    use HasFactory;

    protected $table = 'telegram_groups';

    protected $primaryKey = 'id';

    protected $fillable = [
        'chat_id', // Asegúrate de incluir esto
        'name',
    ];

    public function scopeByChatId($query, $chatId)
    {
        return $query->where('chat_id', $chatId);
    }

    public function scopeByChatName($query, $chatName)
    {
        return $query->where('name', $chatName);
    }

    public function scopeByChatIdOrName($query, $chatIdOrName)
    {
        return $query->where('chat_id', $chatIdOrName)
            ->orWhere('name', $chatIdOrName);
    }

    public function scopeByChatIdOrNameOrFail($query, $chatIdOrName)
    {
        return $query->where('chat_id', $chatIdOrName)
            ->orWhere('name', $chatIdOrName)
            ->firstOrFail();
    }

    public function users()
    {
        return $this->hasMany(TelegramUser::class, 'telegram_group_id', 'id');
    }

}
