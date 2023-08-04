<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\TelegramUser;
use App\Models\TelegraphBot;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use DefStudio\Telegraph\Models\TelegraphChat as BaseModel;

class TelegraphChat extends BaseModel
{
    // use HasFactory;

    protected $fillable = [
        'chat_id',
        'name',
        'telegraph_bot_id'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(TelegramUser::class);
    }

    public function bot(): BelongsTo
    {
        return $this->belongsTo(TelegraphBot::class, 'telegraph_bot_id');
    }
}
