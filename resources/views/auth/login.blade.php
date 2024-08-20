@extends('auth.authmain')

@section('title', 'Login')

@section('content')
<h2>Login</h2>
<form method="POST" action="{{ route('login.post') }}">
    @csrf
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="form-group">
        <label for="username">Username</label>
        <input type="email" class="form-control" id="username" name="email" placeholder="email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password"
            required>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Login</button>
</form>
<div class="signup-prompt mt-3">
    <p>Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
</div>
@endsection