@extends('layouts.app')

@section('title', 'Your Posts')

@section('content')
<div class="tab-pane fade show active" id="pills-company" role="tabpanel" aria-labelledby="pills-company-tab">
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="header-row">
            <h2 class="font-weight-bold">Your Posts</h2>
            <button class="btn btn-custom" data-toggle="modal" data-target="#addPostModal">Add Post</button>
        </div>
        <table id="postsTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Body</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $key => $post)
                <tr id="postRow-{{$post->id}}" data-id="{{ $post->id }}">
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->body }}</td>
                        <td>
                        <button class="btn btn-info btn-sm" onclick="openEditModal({{ $post->id }}, '{{ $post->title }}', '{{ $post->body }}')">Edit</button>
                        <button class="btn btn-danger btn-sm deletePostBtn" data-id="{{ $post->id }}">Delete</button>
                        </td>
                    </tr>
                    <tr id="noPostsRow" style="display: none;">
                        <td colspan="4" class="text-center">No posts available</td>
                    </tr>   
                @empty
                    <tr id="noPostsRow" style="display: bock;">
                        <td colspan="4" class="text-center">No posts available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection