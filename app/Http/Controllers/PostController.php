<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){

        // $test = Test::orderBy('id')->get();
        $test = Test::where('status', '=', 'active')
                    // ->where('id', '=', 1)
                    // ->count('status')
                    //->groupBy('status')
                    ->orderByDesc('id')
                    // ->limit(2)
                    // ->offset(2)
                    ->get();
        return $test;

    }

    public function add(){

       $post = [
            ['title' => 'Post 1','content' => 'Hello my friends','votes' => 20],
            ['title' => 'Post 2','content' => 'Hello my friends','votes' => 30],
            ['title' => 'Post 3','content' => 'Hello my friends','votes' => 40],
            ['title' => 'Post 4','content' => 'Hello my friends','votes' => 50],
       ];
       foreach($post as  $value){
            Post::create($value);

            echo '<pre>';
            print_r($value);
            echo '</pre>';
       }

    }

    public function read(){
    //    $img = Post::find(2)
    //    ->FeaturedImages;

        $user = Post::find(1)
        ->user;

        $posts = User::find(11)
        ->posts;


        return $user;

    }

    public function update($id){
        // $test = Test::where('id',$id)
        //         ->update(['status' => 'inactive']);
    }

    public function delete($id){
        // $test = Test::find($id);
        // $test->delete();
        // Test::where('id', $id)->delete();
        // Test::destroy([12, 11]);
    }
}
