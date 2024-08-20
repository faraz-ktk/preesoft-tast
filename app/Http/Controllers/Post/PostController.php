<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Log;

class PostController extends Controller
{
    public function store(Request $request)
    {
        Log::info("Post Stor In");
        Log::info($request);
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return response()->json(['message' => 'Post created successfully!', 'post' => $post], 201);
    }
    public function updatePost(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:posts,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $post = Post::findOrFail($request->id);
        $this->authorize('update', $post);  // Authorization check

        $post->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return response()->json(['message' => 'Post updated successfully!', 'post' => $post], 200);
    }
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('delete', $post);  // Authorization check

        $post->delete();
        return response()->json(['message' => 'Post deleted successfully.']);
    }
    public function Commentstore(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required|string|max:255',
        ]);

        $userId = auth()->id();
        $user_name = auth()->user()->name; // Get the current user's name

        // Create the comment
        $comment = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => $userId,
            'comment' => $request->comment,
        ]);

        // Return the new comment with additional data
        return response()->json([
            'comment_id' => $comment->id,
            'comment' => $comment->comment,
            'likes_count' => $comment->likes_count,
            'user_name' => $user_name,
            'user_liked' => CommentLike::where('comment_id', $comment->id)
                ->where('user_id', $userId)
                ->exists()
        ]);
    }
    public function like(Request $request)
    {
        $userId = auth()->id();
        $commentId = $request->comment_id;

        // Add a like if it doesn't exist
        $like = CommentLike::firstOrCreate([
            'comment_id' => $commentId,
            'user_id' => $userId,
        ]);

        // Get the updated like count
        $likesCount = Comment::find($commentId)->likes()->count();

        return response()->json([
            'likes_count' => $likesCount
        ]);
    }

    public function unlike(Request $request)
    {
        $userId = auth()->id();
        $commentId = $request->comment_id;

        CommentLike::where('comment_id', $commentId)
            ->where('user_id', $userId)
            ->delete();

        $likesCount = Comment::find($commentId)->commentsLikes()->count();

        return response()->json([
            'likes_count' => max($likesCount, 0)
        ]);
    }


    public function getUsersWithCommentLikes()
    {
        $users = User::whereHas('posts.comments.likes')
            ->withCount([
                'posts as total_likes' => function ($query) {
                    $query->join('comments', 'comments.post_id', '=', 'posts.id')
                        ->join('comment_likes', 'comment_likes.comment_id', '=', 'comments.id')
                        ->selectRaw('count(comment_likes.id) as total_likes');
                }
            ])
            ->get();

        return view('pages.users-with-likes', ['users' => $users]);
    }

    public function updateComment(Request $request, Comment $comment)
    {
        // Ensure the user owns the comment or is authorized to update it
        $this->authorize('update', $comment);

        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $comment->update([
            'comment' => $request->input('comment'),
        ]);

        return response()->json(['message' => 'Comment updated successfully.']);
    }

    public function deleteComment(Comment $comment)
    {
        // Ensure the user owns the comment or is authorized to delete it
        $this->authorize('delete', $comment);

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully.']);
    }
    public function getPosts()
    {
        // Fetch all posts with their related data, if needed
        $posts = Post::with('user', 'comments')->get();
        return response()->json($posts);
    }
}
