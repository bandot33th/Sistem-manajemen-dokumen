<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity as BaseActivity;

class Activity extends BaseActivity
{
    use HasFactory;
    protected $table = 'activity_log';

    public function user()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }

    public function scopeSearch($query, $value)
    {
        return $query->where('subject_type', 'like', "%{$value}%")
                ->orWhere('description', 'like', "%{$value}%");
    }
}
