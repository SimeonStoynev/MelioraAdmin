<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        'password' => 'hashed',
    ];

    public const string ROLE_SUPER_ADMIN = 'Super Admin';

    public const string ROLE_ADMIN = 'Admin';

    public const string ROLE_EDITOR = 'Editor';

    public const string ROLE_VIEWER = 'Viewer';

    public static function getRolesWithPermissions(): array
    {
        return [
            self::ROLE_SUPER_ADMIN => ['manage_ads', 'manage_ad_templates', 'read_dashboard', 'system_configurations'],
            self::ROLE_ADMIN => ['manage_ads', 'manage_ad_templates', 'read_dashboard'],
            self::ROLE_EDITOR => ['manage_ads', 'manage_ad_templates'],
            self::ROLE_VIEWER => ['read_dashboard'],
        ];
    }
}
