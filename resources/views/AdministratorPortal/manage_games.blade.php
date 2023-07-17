@extends('AdministratorPortal.layouts.main')

@section('main')
    <main class="container mt-5 p-3">
        <div class="d-flex align-items-center justify-content-between gap-5">
            <h2 class="mt-2 fw-semibold text-primary">Games</h2>

            <div class="d-flex gap-5 align-items-center">

                <div>
                    <a href="/manage-games/game-scores" class="btn btn-primary btn-sm">Game Scores</a>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <label for="search">Search: </label>
                    <input type="text" name="search" class="form-control" placeholder="Search by title.."
                        id="search-input">
                </div>
            </div>

        </div>

        <div class="d-flex justify-content-center">
            <table class="table">
                <thead>
                    <tr>
                        <th class="col">No</th>
                        <th class="col">Title</th>
                        <th class="col">Description</th>
                        <th class="col">Thumbnail</th>
                        <th class="col">Author</th>
                        <th class="col">Version Timestamps</th>
                        <th class="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($games as $index => $game)
                        <tr>
                            <td scope="row">{{ $index + 1 }}</td>
                            <td>{{ $game->title }}</td>
                            <td>{{ $game->description }}</td>
                            <td>{{ $game->thumbnail }}</td>
                            <td>{{ $game->author->username }}</td>
                            <td>
                                @foreach ($game->gameVersions as $gameVersion)
                                    {{ $gameVersion->version_timestamp }}<br>
                                @endforeach
                            </td>
                            <td>
                                <div class="d-flex gap-2 align-items-center">
                                    <a href="/game/{{ $game->slug }}" class="btn btn-warning btn-sm">View</a>
                                    @if ($game->status === 'deleted')
                                        <span class="text-danger text-decoration-underline">Deleted</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    <script>
        const searchInput = document.getElementById('search-input');
        const tableBody = document.querySelector('table tbody');

        searchInput.addEventListener('input', (e) => {
            const searchValue = e.target.value.toLowerCase();
            const games = document.querySelectorAll('table tbody tr');


            games.forEach((game) => {
                const title = game.querySelector('td:nth-child(2)').innerText.toLowerCase();
                console.log(title);

                if (title.includes(searchValue)) {
                    game.style.display = '';
                } else {
                    game.style.display = 'none';
                }
            })
        })
    </script>
@endsection
