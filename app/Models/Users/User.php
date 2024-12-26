<?php

namespace App\Models\Users;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

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
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the roles relationship.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Assign the user a role.
     */
    public function assignRole(string $role)
    {
        $role = Role::where('name', $role)->firstOrFail();
        $this->roles()->sync($role->id);
    }

    /**
     * Check if the user has a role.
     */
    public function hasRole(string $role): bool
    {
        return $this->roles->contains('name', $role);
    }

    /**
     * Check if the user has any role.
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->roles->whereIn('name', $roles)->isNotEmpty();
    }

    /**
     * Check if the user has all roles.
     */
    public function hasAllRoles(array $roles): bool
    {
        return $this->roles->whereIn('name', $roles)->count() === count($roles);
    }

    /**
     * Get the permissions relationship.
     */
    public function permissions()
    {
        return $this->roles->map->permissions->flatten()->pluck('name')->unique();
    }

    /**
     * Check if the user has a permission.
     */
    public function hasPermissionTo(string $permission): bool
    {
        return $this->permissions()->contains($permission);
    }
}
