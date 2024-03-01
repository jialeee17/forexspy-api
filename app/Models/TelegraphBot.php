<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\TelegraphChat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use DefStudio\Telegraph\Models\TelegraphBot as BaseModel;

class TelegraphBot extends BaseModel
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    protected $fillable = [
        'token',
        'name',
        'link',
        'status',
    ];

    public function chats(): HasMany
    {
        return $this->hasMany(TelegraphChat::class);
    }

    /* -------------------------------------------------------------------------- */
    /*                                   Scopes                                   */
    /* -------------------------------------------------------------------------- */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeInactive(Builder $query): void
    {
        $query->where('status', self::STATUS_INACTIVE);
    }
}
