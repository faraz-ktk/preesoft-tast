<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CommentLike;
use App\Models\Post;
use Illuminate\Http\Request;
use Log;

class UserController extends Controller
{
    public function getUserPosts(Request $request)
    {
        $posts = Post::where('user_id', auth()->id())->get();
        return view('pages.yourposts', ['posts' => $posts]);
    }
    public function AllPosts(Request $request)
    {
        $userId = auth()->id(); 
        $posts = Post::with(['user', 'comments' => function ($query) use ($userId) {
            $query->select('id', 'post_id', 'comment', 'user_id')
                  ->with('user')
                  ->withCount('likes');
        }])
        ->get();
        foreach ($posts as $post) {
            foreach ($post->comments as $comment) {
                $comment->user_liked = CommentLike::where('comment_id', $comment->id)
                                                  ->where('user_id', $userId)
                                                  ->exists();
            }
        }
        Log::info("All Post");
        Log::info($posts);
        return view('pages.allposts', ['posts' => $posts]);
    }
}
