<?php

namespace App\Http\Controllers;

use App\Favorites;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Console\Command;
use App\Console\Commands;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;
use App\Post;
use Auth;
use App\User;
use Session;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function overview()
    {
        $posts = Post::orderBy('category', 'ASC')->get();
        return view('home', [
            'posts' => $posts
        ]);


    }
}
