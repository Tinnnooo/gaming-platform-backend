<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditGameRequest;
use App\Models\Game;
use App\Traits\RespondHttp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\GamesResource;
use App\Http\Resources\GamesCollection;
use App\Http\Requests\GameUploadRequest;
use App\Http\Requests\UploadGameRequest;
use App\Services\GamesControllerService;
use App\Http\Resources\DetailGameResource;
use Illuminate\Support\Facades\Response;

class GamesController extends Controller
{
    use RespondHttp;

    public function __construct(protected GamesControllerService $gamesControllerService)
    {
    }

    // get games (paginate)
    public function paginatedGames(Request $request)
    {
        $games = $this->gamesControllerService->paginatedGames($request);

        return $this->respondSuccess(new GamesCollection($games));
    }

    // upload game
    public function uploadGame(UploadGameRequest $request)
    {
        $game = $this->gamesControllerService->post($request->validated());

        return $this->respondSuccess([
            'status' => 'success',
            'slug' => $game->slug,
        ]);
    }

    // get game by slug
    public function gameDetail($slug)
    {
        $game = $this->gamesControllerService->getGameBySlug($slug);

        return $this->respondSuccess(new DetailGameResource($game));
    }

    public function uploadGameFile(GameUploadRequest $request, $slug)
    {
        $this->gamesControllerService->uploadGame($request->validated(), $slug);

        return $this->respondOk();
    }

    // serve game
    public function serveGame($slug, $version){
        $gamePath = 'games/' . $slug . '/' . $version;

        $gameFile = $this->gamesControllerService->serveGame($gamePath);

       return Response::file($gameFile);
    }

    // edit game
    public function editGame(EditGameRequest $request, $slug)
    {
        $game = $this->gamesControllerService->getGameBySlugAndUser($slug, auth()->user()->id);
        $game->update($request->validated());

        return $this->respondOk();
    }

    // delete game
    public function deleteGame($slug)
    {
        $game = $this->gamesControllerService->getGameBySlugAndUser($slug, auth()->user()->id);
        $this->gamesControllerService->deleteGame($game);

        return response()->json(null, 204);
    }
}
