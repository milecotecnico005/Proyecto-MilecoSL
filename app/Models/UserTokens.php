<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTokens extends Model
{
    use HasFactory;

    protected $table = 'users_tokens';
    protected $primaryKey = 'id_user_api';

    protected $fillable = [
        'users_id',
        'loged_token',
        'firebase_token',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

}
