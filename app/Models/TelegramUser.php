<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TelegramUser extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'member_uuid',
        'telegraph_chat_id',
        'first_name',
        'last_name',
        'language_code'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];

    /* -------------------------------------------------------------------------- */
    /*                                Relationship                                */
    /* -------------------------------------------------------------------------- */
    public function accounts(): HasMany
    {
        return $this->hasMany(MTAccount::class, 'telegram_user_uuid', 'uuid');
    }

    public function chat(): BelongsTo
    {
        return $this->belongsTo(TelegraphChat::class, 'telegraph_chat_id');
    }

    public function memebr(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_uuid', 'uuid');
    }
}