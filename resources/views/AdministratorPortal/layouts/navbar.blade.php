<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administrator Portals</title>

    <link rel="stylesheet" href="./css/AdministratorPortal.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-logo">
            <p>Administrator Portal</p>
        </div>

        <div class="navbar-menu">
            <div class="user_username">
                {{ auth('admin_users')->user()->username }}
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout_button">Logout</button>
            </form>
        </div>
    </nav>

    <main class="dashboard-container">
        @yield('content')
    </main>
</body>
</html>
