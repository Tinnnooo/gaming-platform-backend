@extends('AdministratorPortal.dashboard')

@section('main')
    <table class="admin_users_table">
            <tr>
                <th>Username</th>
                <th>Created at</th>
                <th>Last Login</th>
            </tr>
            @foreach ($admin_users as $user)
            <tr>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->registered_at }}</td>
                    <td>{{ $user->last_login_at }}</td>
                </tr>
                @endforeach
    </table>
@endsection
