<?php

namespace App\Models;

use App\Models\TelegraphChat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TelegramUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_uuid',
        'telegraph_chat_id',
        'first_name',
        'last_name',
        'language_code'
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(TelegraphChat::class, 'telegraph_chat_id');
    }
}