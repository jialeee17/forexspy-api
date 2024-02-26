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

    /* -------------------------------------------------------------------------- */
    /*                                Relationships                               */
    /* -------------------------------------------------------------------------- */
    public function mtAccount(): BelongsTo
    {
        return $this->belongsTo(MTAccount::class, 'account_login_id', 'login_id');
    } 
}
