@extends('AdministratorPortal.layouts.main')

@section('main')
    <main class="container mt-5 p-3">
        <h2 class="fw-semibold text-primary mt-2">Games Score</h2>

        @if (session()->has('resetSuccess'))
            <div class="d-flex justify-content-center">
                <p class="fs-14 fw-bold text-center bg-success text-white p-1 rounded">{{ session('resetSuccess') }}</p>
            </div>
        @elseif (session()->has('deleteSuccess'))
            <div class="d-flex justify-content-center">
                <p class="fs-14 fw-bold text-center bg-success text-white p-1 rounded">{{ session('deleteSuccess') }}</p>
            </div>
        @endif

        <div class="d-flex flex-column">
            @foreach ($games as $game)
                <div class="d-flex gap-5 align-items-center">
                    <h3 class="text-success fw-semibold mt-3">{{ $game->title }}</h3>
                    <form action="/manage-games/{{ $game->id }}/reset-scores" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Reset Scores</button>
                    </form>
                </div>

                <div class="d-flex flex-column mt-3">
                    @foreach ($game->gameVersions as $index => $version)
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="text-secondary">Game Version {{ $index + 1 }} - {{ $version->version_timestamp }}
                            </h4>

                            @if (count($version->gameScores) !== 0)
                                <form action="/manage-games/{{ $version->id }}/reset-highscores" method="post">
                                    @csrf

                                    <button type="submit" class="btn btn-danger">Reset Highscores</button>
                                </form>
                            @endif
                        </div>

                        <table class="table table-primary table-responsive mt-3 mb-4 align-middle text-center">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 5%;">No</th>
                                    <th scope="col" style="width: 50%;">Player Name</th>
                                    <th scope="col" style="width: 35%;">Score</th>
                                    <th scope="col" style="width: 10%;">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @if (count($version->gameScores) !== 0)
                                    @foreach ($version->gameScores as $index => $score)
                                        <tr>
                                            <td scope="row">{{ $index + 1 }}</td>
                                            <td>{{ $score->user->username }}</td>
                                            <td>{{ $score->score }}</td>
                                            <td>
                                                <form action="/manage-games/{{ $score->id }}/delete" method="post">
                                                    @csrf
                                                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-secondary fs-14 fw-bold">
                                            No Data.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    @endforeach
                </div>
            @endforeach
        </div>
    </main>
@endsection
