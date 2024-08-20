<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link href="{{ asset('assets/styles.css') }}" rel="stylesheet">
    <link rel="icon" href="https://preesoft.com/wp-content/uploads/2020/06/icon-50x50.png" type="image/x-icon">
</head>
<body>
    <div class="container mt-4">
        <div class="tabs-to-dropdown">
            @include('partials.navbar')
            <div class="tab-content" id="pills-tabContent">
                @yield('content')
            </div>
        </div>
    </div>
    @include('partials.modals') 
    @include('partials.footer') 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/custom.js') }}"></script>
    @include('partials.scripts') 
</body>
</html>
