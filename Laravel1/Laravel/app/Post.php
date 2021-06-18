<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = ['id', 'title', 'description','published','category'];

    public function favorites()
    {
        return $this->has_many('App\Favorites'); // doesn't require you to specify an id at all
    }

    public function user()
    {
        return $this->belongsToMany('App\User');
    }
}
