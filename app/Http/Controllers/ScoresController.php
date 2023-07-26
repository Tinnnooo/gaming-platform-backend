<?php

namespace App\Http\Controllers;

use App\Traits\RespondHttp;
use App\Http\Requests\StoreScoreRequest;
use App\Services\GamesControllerService;
use App\Services\ScoresControllerService;

class ScoresController extends Controller
{
    use RespondHttp;

    public function __construct(protected GamesControllerService $gamesControllerService, protected ScoresControllerService $scoresControllerService)
    {

    }

    public function getScores($slug)
    {
        // Find the game by slug with its versions and scores
        $game = $this->scoresControllerService->getGameBySlugWithScore($slug);

        $highScores = $this->scoresControllerService->collectScores($game);

        // Return the response
        return $this->respondSuccess($highScores);
    }

    public function storeScore(StoreScoreRequest $request, $slug)
    {
        $game = $this->gamesControllerService->getGameBySlug($slug);

        $this->scoresControllerService->storeScore($request->validated(), $game);
        return $this->respondOk();
    }
}
