<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'jenis_kelamin',
        'username',
        'slug',
        'email',
        'nis',
        'is_active',
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
     * Get all of the badalan for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function badalan(): HasMany
    {
        return $this->hasMany(Badalan::class);
    }

    /**
     * Get all of the guruMapel for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function guruMapel(): HasMany
    {
        return $this->hasMany(GuruMapel::class);
    }

    /**
     * Get all of the jamKosong for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jamKosong(): HasMany
    {
        return $this->hasMany(JamKosong::class);
    }

    /**
     * Get the penggajian associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function penggajian(): HasOne
    {
        return $this->hasOne(Penggajian::class)->withDefault();
    }
}
