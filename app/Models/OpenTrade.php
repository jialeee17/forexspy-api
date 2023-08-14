<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpenTrade extends Model
{
    use HasFactory;

    protected $connection = 'forexspy_data';

    protected $table = 'open_trades';

    protected $casts = [
        'open_at' => 'datetime:Y-m-d H:i:s',
        'close_at' => 'datetime:Y-m-d H:i:s',
        'expired_at' => 'datetime:Y-m-d H:i:s'
    ];
}
