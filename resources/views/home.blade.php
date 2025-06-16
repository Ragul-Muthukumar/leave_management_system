<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title', 'MyApp')</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

  <nav class="navbar">
    <div class="brand">Leave Management System</div>
    <div class="toggle" id="toggle-menu">☰</div>
    <ul class="nav-links" id="navLinks">
      <li><a onclick="openModal()" class="login-btn">Login</a></li>
    </ul>
  </nav>

    <div class="main-content">
        @yield('content')
    </div>
    <div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="login-close-button">&times;</span>
        <h2>Login</h2>
        <input type="text" placeholder="Email or Username">
        <input type="password" placeholder="Password">
        <button type="submit">Sign In</button>
    </div>
    </div>

  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
