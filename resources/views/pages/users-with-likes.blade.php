@extends('layouts.app')

@section('title', 'Users With Likes')

@section('content')
<div class="tab-pane fade show active" role="tabpanel" aria-labelledby="pills-news-tab">
    <div class="container-fluid">
    <h2 class="mb-3 font-weight-bold">Users Who Have Received At Least One Like on Their Post Comments (Including Their Own Likes)</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Total Likes</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->total_likes }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No users with likes found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
