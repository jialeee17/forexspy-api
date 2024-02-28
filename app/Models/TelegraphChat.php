<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\TelegraphBot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use DefStudio\Telegraph\Models\TelegraphChat as BaseModel;

class TelegraphChat extends BaseModel
{
    protected $fillable = [
        'chat_id',
        'name',
        'telegraph_bot_id',
        'user_uuid',
        'pending_commands',
    ];

    protected $casts = [
        'pending_commands' => 'array',
    ];

    /* -------------------------------------------------------------------------- */
    /*                                Relationships                               */
    /* -------------------------------------------------------------------------- */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    public function bot(): BelongsTo
    {
        return $this->belongsTo(TelegraphBot::class, 'telegraph_bot_id');
    }
}
