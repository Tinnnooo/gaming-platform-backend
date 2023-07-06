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
    </nav>

    <main class="container">
        <form method="POST" action="{{ route('admin.login.submit') }}" class="container-form">
            @csrf

            <div class="form-title">
                <h3>Admin Login</h3>
            </div>

            @if (session()->has('loginError'))
                <div class="error">
                    {{ session('loginError') }}
                </div>
            @endif


            <div class="form-input">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" value="{{ old('username') }}" />
                @if ($errors->has('username'))
                    <p class="error-field">{{ $errors->first('username') }}</p>
                @endif
            </div>

            <div class="form-input">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password"/>
                @if ($errors->has('password'))
                    <p class="error-field">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div class="form-button">
                <button type="submit">Log in</button>
            </div>
        </form>
    </main>
</body>
</html>
