<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedbacks';
    
    protected $fillable = [
        'region_id',
        'gender',
        'membership',
        'visit_reason',
        'waiting_time',
        'satisfaction_time',
        'needs_met',
        'service_quality',
        'problem_handling',
        'staff_responsiveness',
        'overall_satisfaction',
        'suggestions',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
