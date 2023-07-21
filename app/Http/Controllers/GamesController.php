<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadGameRequest;
use App\Http\Resources\PaginateGamesCollection;
use App\Models\Game;
use App\Services\GamesControllerService;
use App\Traits\RespondHttp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GamesController extends Controller
{
    use RespondHttp;

    public function __construct(protected GamesControllerService $gamesControllerService)
    {
    }

    public function paginatedGames(Request $request)
    {
        $page = $request->query('page', 0);
        $size = max($request->query('size', 10), 1);

        $sortBy = $request->query('sortBy', 'title');
        $sortDir = $request->query('sortDir', 'asc');

        $validSortFields = ['title', 'popular'];
        if(!in_array($sortBy, $validSortFields)){
            $sortBy = 'title';
        }

        $query = Game::query();

        if ($sortBy === 'popular') {
            $query->with(['gameVersions' => function ($query) {
                $query->withCount('gameScores as scoreCount');
            }]);
        } else {
            $query->orderBy($sortBy, $sortDir);
        }

        $games = $query->paginate($size,['*'] ,'page', $page);

        return $this->respondSuccess(new PaginateGamesCollection($games));
    }

    public function uploadGame(UploadGameRequest $request)
    {
        $game = $this->gamesControllerService->post($request->validated());

        return $this->respondSuccess([
            'status' => 'success',
            'slug' => $game->slug,
        ]);
    }
}
