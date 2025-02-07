<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionOrder extends Model
{
    use HasFactory;

    protected $table = 'orden_position_sl';

    protected $primaryKey = 'id_position';

    protected $fillable = [
        'orden_id',
        'position',
        'parte_id',
        'position_parte',
    ];

    public $timestamps = false;

    public function orden()
    {
        return $this->belongsTo(OrdenesTrabajo::class, 'orden_id');
    }

}
