<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $table = 'events';
    use HasFactory;

    protected $fillable = [
        'description',
        'title'
    ];


    public function users(): BelongsTo
    {
        return $this->belongsTo('App\Model\Users', 'user_id');
    }
}
