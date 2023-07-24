<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScoreRequest;
use App\Http\Resources\GameScoresCollection;
use App\Http\Resources\GameScoresResource;
use App\Services\GamesControllerService;
use App\Services\ScoresControllerService;
use App\Traits\RespondHttp;
use Illuminate\Http\Request;

class ScoresController extends Controller
{
    use RespondHttp;

    public function __construct(protected GamesControllerService $gamesControllerService, protected ScoresControllerService $scoresControllerService)
    {

    }
    public function getScores($slug)
    {
        $game = $this->gamesControllerService->getGameBySlug($slug);

        return $this->respondSuccess(new GameScoresResource($game));
    }

    public function storeScore(StoreScoreRequest $request, $slug)
    {
        $game = $this->gamesControllerService->getGameBySlug($slug);

        $this->scoresControllerService->storeScore($request->validated(), $game);
        return $this->respondOk();
    }
}
