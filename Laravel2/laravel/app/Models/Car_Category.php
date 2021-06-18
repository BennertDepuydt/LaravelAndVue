<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car_Category extends Model
{

    protected $table = 'car_categories';
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function cars()
    {
        return $this->hasMany(\App\Models\Car::class);
    }
}
