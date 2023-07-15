@extends('AdministratorPortal.layouts.main')

@section('main')
    <main class="container mt-5 pt-4">
        <h2 class="fw-bold text-primary">Admin User Lists</h2>
        <table class="table mt-3">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Username</th>
                <th scope="col">Created at</th>
                <th scope="col">Last Login</th>
              </tr>
            </thead>
            <tbody>
                @foreach($admin_users as $index => $user)
              <tr>
                <th scope="row">{{ $index + 1}}</th>
                <td>{{ $user->username }}</td>
                <td>{{ $user->registered_at }}</td>
                <td>{{ $user->last_login_at ?? '-'}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
    </main>


@endsection
