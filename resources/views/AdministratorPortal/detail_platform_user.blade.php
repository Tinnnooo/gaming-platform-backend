@extends('AdministratorPortal.layouts.main')

@section('main')
    <main class="container mt-5 pt-3">
        <h2 class="mt-2 text-primary fw-semibold text-center">Detail User</h2>

        <div class="d-flex justify-content-center">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <a href="/manage-platform-users" class="btn btn-danger badge">&laquo; Back</a>
                    <h5 class="card-title mt-2 fw-semibold">{{ $platform_user->username }}</h5>
                    <h6 class="card-subtitle mt-2">Game scores: {{ $platform_user->game_scores }}</h6>
                    <p class="card-text mt-2">Uploaded games: {{ $platform_user->uploaded_games }}</p>
                </div>
            </div>
        </div>
    </main>
@endsection
