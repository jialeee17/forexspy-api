<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\TelegraphChat;
use Illuminate\Database\Eloquent\Relations\HasMany;
use DefStudio\Telegraph\Models\TelegraphBot as BaseModel;

class TelegraphBot extends BaseModel
{
    // use HasFactory;

    protected $fillable = [
        'token',
        'name'
    ];

    public function chats(): HasMany
    {
        return $this->hasMany(TelegraphChat::class);
    }
}
