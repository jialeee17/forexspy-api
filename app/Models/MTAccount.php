<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MTAccount extends Model
{
    use HasFactory;

    protected $table = 'accounts';

    protected $connection = 'forexspy_data';

    protected $fillable = [
        'login_id',
        'forexspy_user_uuid',
        'trade_mode',
        'leverage',
        'limit_orders',
        'margin_so_mode',
        'is_trade_allowed',
        'is_trade_expert',
        'balance',
        'credit',
        'profit',
        'equity',
        'margin',
        'margin_free',
        'margin_level',
        'margin_so_call',
        'margin_so_so',
        'margin_initial',
        'margin_maintenance',
        'assets',
        'liabilities',
        'commission_blocked',
        'highest_drawdown_amount',
        'highest_drawdown_percentage',
        'active_pairs',
        'active_orders',
        'profit_today',
        'profit_all_time',
        'name',
        'server',
        'currency',
        'company'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];

    /* -------------------------------------------------------------------------- */
    /*                                Relationship                                */
    /* -------------------------------------------------------------------------- */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'forexspy_user_uuid', 'uuid');
    }
}
