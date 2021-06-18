<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Session;

class SearchController extends Controller
{
    public function search(Request $req){
        $search = $req->input('searchterm');
        $posts = Post::where('title', 'like', '%' . $search . '%')->get();
        if(count($posts) == 0){
            \Session::flash('fail', 'Geen resultaten gevonden');
        }
            return view('home', [
                'posts' => $posts
            ]);
    }

    public function category(Request $req){
        $category = $req->get('category');
        $posts = Post::where('category', $category)->get();
        if(count($posts) == 0){
            \Session::flash('fail', 'Geen resultaten gevonden');
        }
        return view('home', [
            'posts' => $posts
        ]);
    }

    public function datesearch(Request $req){
        $date = $req->get('dateterm');
        $posts = Post::orderBy('category', 'ASC')->whereDate('published',$date)->get();
        if(count($posts) == 0){
            Session::flash('fail', 'Geen resultaten gevonden');
        }
        return view('home', [
            'posts' => $posts
        ]);
    }
}
