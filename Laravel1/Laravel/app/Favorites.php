<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    protected $table = 'post_user';

    public function post()
    {
        return $this->belongs_to('App\Post');
    }
    public function user()
    {
        return $this->belongs_to('App\User');
    }
}
