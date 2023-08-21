<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'username',
        'password',
        'email',
        'first_name',
        'last_name',
        'profile_picture',
        'phone_number',
        'date_of_birth',
        'gender',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    public static $gender = [
        self::GENDER_MALE,
        self::GENDER_FEMALE
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static $status = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE
    ];

    /* -------------------------------------------------------------------------- */
    /*                                Relationship                                */
    /* -------------------------------------------------------------------------- */
    public function telegramUsers(): HasMany
    {
        return $this->hasMany(TelegramUser::class, 'member_uuid', 'uuid');
    }

    /* -------------------------------------------------------------------------- */
    /*                                    Scope                                   */
    /* -------------------------------------------------------------------------- */
    public function scopeMale($query)
    {
        return $query->where('gender', self::GENDER_MALE);
    }

    public function scopeFemale($query)
    {
        return $query->where('gender', self::GENDER_FEMALE);
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }
}
