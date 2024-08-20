@extends('layouts.app')

@section('title', 'All Post')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="mb-4 font-weight-bold">All Posts</h2>
    
    @if ($posts->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            No Posts Found
        </div>
    @else
        <div id="posts">
            @foreach ($posts as $post)
                <article class="post mb-4 p-3 border rounded">
                    <header class="mb-3">
                        <h3>{{ $post->title }}</h3>
                        <div class="text-muted">Posted by: {{ $post->user->name }}</div>
                    </header>
                    <p>{{ $post->body }}</p>
                    <button class="btn btn-info btn-sm toggle-comments-btn" data-post-id="{{ $post->id }}">
                        Show Comments
                    </button>
                    <div class="comments d-none mt-3" id="post{{ $post->id }}">
                        @foreach ($post->comments as $comment)
                            <div class="comment mb-3 p-2 border rounded">
                                <div class="comment-header mb-1">
                                    <strong>{{ $comment->user->name ?? 'Anonymous' }}</strong>
                                </div>
                                <p>{{ $comment->comment }}</p>
                                <button class="btn btn-link like-btn" onclick="toggleLike({{ $comment->id }}, this)">
                                    @if ($comment->user_liked)
                                        <span class="text-danger">Unlike</span>
                                    @else
                                        <span class="text-success">Like</span>
                                    @endif
                                    <span class="like-count">({{ $comment->likes_count }})</span>
                                </button>
                                
                            </div>
                        @endforeach
                        <div class="comment-input mt-3">
                            <input type="text" class="form-control" placeholder="Add a comment..." id="comment-input-{{ $post->id }}">
                            <button class="btn btn-primary mt-2" onclick="submitComment('{{ $post->id }}')">Send</button>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endsection
