<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donatie extends Model
{
    use HasFactory;
    protected $table = 'donaties';

    protected $fillable = [
        'type',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
