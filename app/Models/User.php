<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const TYPE_SYSTEM_USER = 'System User';
    public const TYPE_EMPLOYEE = 'Employee';
    public const AVATAR_STORAGE_PATH = 'avatars';
    public const ORGANISATION_OWNER_YES = 1;
    public const ORGANISATION_OWNER_NO = 0;
    public const USER_ACTIVE = 1;
    public const USER_INACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tenant_id',
        'name',
        'phone',
        'type',
        'avatar',
        'active',
        'email',
        'password',
        'is_owner'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getAvatarPathAttribute(): string
    {
        return Storage::disk('public')->url(self::AVATAR_STORAGE_PATH.'/'.$this->avatar);
    }
}
