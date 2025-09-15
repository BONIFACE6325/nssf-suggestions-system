<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'region_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * A user belongs to a region.
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * A user can have many AI insights (chat history).
     */
    public function aiInsights()
    {
        return $this->hasMany(AiInsight::class);
    }
}
