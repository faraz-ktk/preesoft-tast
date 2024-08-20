<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/styles.css" rel="stylesheet">
    <link rel="icon" href="https://preesoft.com/wp-content/uploads/2020/06/icon-50x50.png" type="image/x-icon">

</head>
<body>
    <div class="login-container">
      @yield('content')
    </div>
    <footer class="footer">
        <p>&copy; 2024 PreeSoft. All rights reserved.</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/custom.js"></script>
</body>

</html>
