<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiInsight extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'region_id',
        'question',
        'answer',
    ];

    /**
     * An AI insight belongs to a user (manager).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * An AI insight belongs to a region.
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
