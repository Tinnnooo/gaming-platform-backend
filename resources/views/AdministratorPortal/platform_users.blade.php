@extends('AdministratorPortal.layouts.main')

@section('main')
    <main class="container mt-5 pt-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-primary fw-bold mt-3">Platform Users</h2>
            @if (session()->has('blockInfo'))
                <h6 class="bg-success text-white p-2 w-25 rounded-3">{{ session('blockInfo') }}</h6>
            @endif
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Username</th>
                    <th scope="col">Game Scores</th>
                    <th scope="col">Uploaded Games</th>
                    <th scope="col">Registered at</th>
                    <th scope="col">Last Login at</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($platform_users) === 0)
                    <tr>
                        <td colspan="7" class="text-center fw-bold">No Data</td>
                    </tr>
                @else
                    @foreach ($platform_users as $index => $user)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->game_scores }}</td>
                            <td>{{ $user->uploaded_games }}</td>
                            <td>{{ $user->registered_at }}</td>
                            <td>{{ $user->last_login_at ?? '-' }}</td>
                            <td>
                                <div class="d-flex gap-3">
                                    <a href="/manage-platform-users/{{ $user->username }}"
                                        class="btn btn-primary btn-sm">Detail</a>
                                    @if ($user->blocked)
                                        <form action="/manage-platform-users/{{ $user->username }}/block" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Unblock</button>
                                        </form>
                                    @else
                                        <form action="/manage-platform-users/{{ $user->username }}/block" method="POST">
                                            @csrf
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#blockModal">Block</button>

                                            <div class="modal fade" id="blockModal" tabindex="-1"
                                                aria-labelledby="blockModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="blockModalLabel">Block Reason
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form>
                                                                <div class="mb-3">
                                                                    <label for="reason" class="col-form-label">Block
                                                                        Reason:</label>
                                                                    <input class="form-control" id="reason"
                                                                        type="text" placeholder="Block reason"
                                                                        name="reason" required></input>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-danger">Block</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </main>
@endsection
