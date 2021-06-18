<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
    protected $table = 'jobs';
    use HasFactory;

    protected $fillable = [
        'mic',
        'onlinetime',
        'playtime',
        'description',
        'experience',
        'organization_id'
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo('App\Models\Organization', 'organization_id');
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}
