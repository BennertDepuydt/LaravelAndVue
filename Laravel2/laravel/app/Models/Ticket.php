<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $table = 'tickets';
    use HasFactory;

    protected $fillable = [
        'title',
        'msg',
        'email',
        'status',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }



}
