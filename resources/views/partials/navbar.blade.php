<div class="nav-wrapper d-flex align-items-center justify-content-between">
    <!-- Mobile Toggle Button -->
    <button class="navbar-toggler d-md-none" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Nav Items for Larger Screens -->
    <ul class="nav nav-pills d-none d-md-flex" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if(request()->is('/')) active @endif" href="{{ route('getUserPosts') }}" role="tab">Your Posts</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(request()->is('all-posts')) active @endif" href="{{ route('all.posts') }}" role="tab">All Posts</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(request()->is('user-with-likes')) active @endif" href="{{ route('user.likes') }}" role="tab">Users with Likes</a>
        </li>
    </ul>

    <!-- Collapsible Nav Items for Mobile -->
    <div class="collapse navbar-collapse d-md-none" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link @if(request()->is('/')) active @endif" href="{{ route('getUserPosts') }}">Your Posts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(request()->is('all-posts')) active @endif" href="{{ route('all.posts') }}">All Posts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(request()->is('user-with-likes')) active @endif" href="{{ route('user.likes') }}">Users with Likes</a>
            </li>
        </ul>
    </div>

    <!-- User Dropdown Menu -->
    <div class="dropdown">
        <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user user-icon"></i> {{ Auth::user()->name }}
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item">Sign Out</button>
            </form>
        </div>
    </div>
</div>
