<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trade extends Model
{
    use HasFactory;

    protected $table = 'trades';

    protected $connection = 'forexspy_data';

    protected $fillable = [
        'account_login_id',
        'ticket',
        'symbol',
        'order_type',
        'lots',
        'commission',
        'profit',
        'stop_loss',
        'swap',
        'take_profit',
        'magic_number',
        'comment',
        'status',
        'open_price',
        'open_at',
        'close_price',
        'close_at',
        'expired_at',
        'open_notif_sent',
        'closed_notif_sent',
    ];

    /* -------------------------------------------------------------------------- */
    /*                                   Scopes                                   */
    /* -------------------------------------------------------------------------- */
    public function scopeOpen(Builder $query): void
    {
        $query->where('status', 'open');
    }

    public function scopeClosed(Builder $query): void
    {
        $query->where('status', 'closed');
    }

    public function scopeOpenNotifNotSent(Builder $query): void
    {
        $query->where('open_notif_sent', false);
    }

    public function scopeClosedNotifNotSent(Builder $query): void
    {
        $query->where('closed_notif_sent', false);
    }

    /* -------------------------------------------------------------------------- */
    /*                                Relationships                               */
    /* -------------------------------------------------------------------------- */
    public function mtAccount(): BelongsTo
    {
        return $this->belongsTo(MTAccount::class, 'account_login_id', 'login_id');
    } 
}
