<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameScoresCollection;
use App\Http\Resources\GameScoresResource;
use App\Services\GamesControllerService;
use App\Traits\RespondHttp;
use Illuminate\Http\Request;

class ScoresController extends Controller
{
    use RespondHttp;

    public function __construct(protected GamesControllerService $gamesControllerService)
    {

    }
    public function getScores($slug)
    {
        $game = $this->gamesControllerService->getGameBySlug($slug);

        return $this->respondSuccess(new GameScoresResource($game));
    }
}
