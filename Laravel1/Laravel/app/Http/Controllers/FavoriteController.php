<?php

namespace App\Http\Controllers;

use App\Favorites;
use Illuminate\Http\Request;
use App\Post;
use Auth;
use App\User;
use Session;

class FavoriteController extends Controller
{
    public static function addfavorites($id)
    {
        $count = User::findorfail(Auth::id())->post()->count();
        if(User::findorfail(Auth::id())->post()->where('post_id', $id)->exists()){
            \Session::flash('fail', 'Artikel staat al in favorites');
            return back();
        }
        else {
            $favo = new Favorites;
            $favo->post_id = $id;
            $favo->user_id = Auth::id();
            $favo->rank = $count+1;
            $favo->save();
            Session::flash('succes', 'Added to favorites');
            return back();
        }


    }
    public static function deletefavorites($id)
    {
        //User::findorfail(Auth::id())->post()->where('post_id', $id)->delete();
        Favorites::where('post_id', $id)->delete();
        \Session::flash('succes', 'Favorite verwijderd');
        return back();
    }
    public static function upfavorites($id)
    {
        $posts = User::findorfail(Auth::id())->post()->where('post_id', $id)->get();
        $favo = Favorites::where('post_id', $id)->where('user_id',Auth::id())->pluck('rank');
        $favo = $favo[0];
        var_dump($favo);
        foreach(Favorites::where('user_id',Auth::id())->get() as $item){
            if($item->rank == $favo){
                $post = Favorites::where('user_id',Auth::id())->where('post_id', $item->post_id)->first();
                $post->rank -=1;
                $post->save();
            }
            elseif($item->rank  == $favo-1){
                $post = Favorites::where('user_id',Auth::id())->where('post_id', $item->post_id)->first();
                $post->rank +=1;
                $post->save();
            }
        }
        return back();
    }
    public static function downfavorites($id)
    {
        $posts = User::findorfail(Auth::id())->post()->where('post_id', $id)->get();
        $favo = Favorites::where('post_id', $id)->where('user_id',Auth::id())->pluck('rank');
        $favo = $favo[0];
        var_dump($favo);
        foreach(Favorites::where('user_id',Auth::id())->get() as $item){
            if($item->rank == $favo){
                $post = Favorites::where('user_id',Auth::id())->where('post_id', $item->post_id)->first();
                $post->rank +=1;
                $post->save();
            }
            elseif($item->rank  == $favo+1){
                $post = Favorites::where('user_id',Auth::id())->where('post_id', $item->post_id)->first();
                $post->rank -=1;
                $post->save();
            }
        }
        return back();
    }
    public static function editfavorites(Request $req, $id)
    {
        $category = $req->get('category');
        /*$posts = User::findorfail(Auth::id())->post()->where('post_id', $id)->get();
        $favo = Favorites::where('post_id', $id)->where('user_id',Auth::id())->pluck('rank');
        $favo = $favo[0];
        var_dump($favo);
        foreach(Favorites::where('user_id',Auth::id())->get() as $item){
            if($item->rank == $favo){
                $post = Favorites::where('user_id',Auth::id())->where('post_id', $item->post_id)->first();
                $post->rank +=1;
                $post->save();
            }
            elseif($item->rank  == $favo+1){
                $post = Favorites::where('user_id',Auth::id())->where('post_id', $item->post_id)->first();
                $post->rank -=1;
                $post->save();
            }
        }*/
        return back();
    }


    public static function overviewfavorites(){
        $posts = User::findorfail(Auth::id())->post()->orderby('rank', 'ASC')->get();
        return view('favorites', [
            'posts' => $posts,
        ]);
    }
}
