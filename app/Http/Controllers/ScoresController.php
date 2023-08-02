<?php

namespace App\Http\Controllers;

use App\Traits\RespondHttp;
use App\Http\Requests\StoreScoreRequest;
use App\Services\GamesService;
use App\Services\ScoresService;

class ScoresController extends Controller
{
    use RespondHttp;

    public function __construct(protected GamesService $gamesService, protected ScoresService $scoresService)
    {

    }

    public function getScores($slug)
    {
        // Find the game by slug with its versions and scores
        $game = $this->scoresService->getGameBySlugWithScore($slug);

        $highScores = $this->scoresService->collectScores($game);

        // Return the response
        return $this->respondSuccess($highScores);
    }

    public function storeScore(StoreScoreRequest $request, $slug)
    {
        $game = $this->gamesService->getGameBySlug($slug);

        $this->scoresService->storeScore($request->validated(), $game);
        return $this->respondOk();
    }
}
