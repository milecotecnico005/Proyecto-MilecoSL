<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class telegramGropsUsers extends Model
{
    use HasFactory;

    protected $table = 'telegram_group_has_users';

    protected $fillable = [
        'group_id',
        'user_id',
    ];

    public function scopeByGroupId($query, $groupId)
    {
        return $query->where('group_id', $groupId);
    }

    public function scopeByUserId($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function group(){
        return $this->belongsTo(TelegramGroup::class, 'group_id', 'id');
    }

    public function user(){
        return $this->belongsTo(TelegramUser::class, 'user_id', 'id');
    }

}
