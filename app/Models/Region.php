<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * A region has many users (managers).
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * A region has many feedbacks.
     */
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * A region has many AI insights.
     */
    public function aiInsights()
    {
        return $this->hasMany(AiInsight::class);
    }
}
