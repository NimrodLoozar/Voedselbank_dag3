<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
     * Get the gebruiker associated with the user.
     */
    public function gebruiker()
    {
        return $this->hasOne(Gebruiker::class, 'gebruikersnaam', 'email');
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $roleName): bool
    {
        if (!$this->gebruiker) {
            return false;
        }

        return $this->gebruiker->rollen()->where('naam', $roleName)->exists();
    }

    /**
     * Get all roles for this user
     */
    public function getRoles()
    {
        if (!$this->gebruiker) {
            return collect();
        }

        return $this->gebruiker->rollen()->pluck('naam');
    }
}
