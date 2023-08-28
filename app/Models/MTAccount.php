<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MTAccount extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'mt_accounts';

    protected $fillable = [
        'login_id',
        'telegram_user_uuid',
        'name',
        'currency',
        'balance',
        'equity',
        'margin_level',
        'highest_drawdown_amount',
        'highest_drawdown_percentage',
        'floating',
        'active_pairs',
        'active_orders',
        'profit_today',
        'profit_all_time',
        'initial_summary_notified',
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
        return $this->belongsTo(TelegramUser::class, 'telegram_user_uuid', 'uuid');
    }
}
