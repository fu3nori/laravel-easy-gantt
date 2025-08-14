<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'projects_id',
        'task_name',
        'fix',
        'start_day',
        'end_day'
    ];

    protected $casts = [
        'start_day' => 'date',
        'end_day' => 'date',
        'fix' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'projects_id');
    }
}
