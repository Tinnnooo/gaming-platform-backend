<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administrator Portals</title>

    <link rel="stylesheet" href="./css/AdministratorPortal.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="min-vh-100">
    @include('AdministratorPortal.layouts.navbar')

    @yield('main')
</body>
</html>
