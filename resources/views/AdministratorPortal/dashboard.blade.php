@extends('AdministratorPortal.layouts.navbar')

@section('content')

        <div class="menu-wrapper">
            <div class="menu-management">
                <a href="/admin-users">Admin Users</a>
            </div>
            <div class="menu-management">
                <a href="#">Platform Users</a>
            </div>
        </div>

        <div class="main-content">
            @yield('main')
        </div>

@endsection
