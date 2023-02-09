<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'email_verified_at' => 'datetime',
    ];


    /**
     * The items that belongs to the user
     *
     * @return belongsToMany
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_user')
            ->withPivot('active', 'order');
    }

    /**
     * The Active items that belongs to the user
     *
     * @return belongsToMany
     */
    public function activeItems()
    {
        return $this->belongsToMany(Item::class, 'item_user')
            ->withPivot('active', 'order')
            ->wherePivot('active', 1)
            ->orderByPivot('order');
    }
}
