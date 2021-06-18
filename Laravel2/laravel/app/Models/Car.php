<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    protected $table = 'cars';
    use HasFactory;

    public function category(): BelongsTo
    {
        return $this->belongsTo('App\Models\Car_Category', 'car_categories_id');
    }

    protected $fillable = [
        'name',
        'year',
        'price',
        'modelname',
        'car_categories_id',
        'imgUrl'
    ];


}
