<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Traits\RespondHttp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Requests\EditGameRequest;
use App\Http\Resources\GamesCollection;
use App\Http\Requests\GameUploadRequest;
use App\Http\Requests\UploadGameRequest;
use App\Services\GamesService;
use Illuminate\Support\Facades\Response;
use App\Http\Resources\DetailGameResource;

class GamesController extends Controller
{
    use RespondHttp;

    public function __construct(protected GamesService $gamesService)
    {
    }

    // get games (paginate)
    public function paginatedGames(Request $request)
    {
        $games = $this->gamesService->paginatedGames($request);

        return $this->respondSuccess(new GamesCollection($games));
    }

    // upload game
    public function uploadGame(UploadGameRequest $request)
    {
        $game = $this->gamesService->post($request->validated());

        return $this->respondSuccess([
            'status' => 'success',
            'slug' => $game->slug,
        ]);
    }

    // get game by slug
    public function gameDetail($slug)
    {
        $game = $this->gamesService->getGameBySlug($slug);

        return $this->respondSuccess(new DetailGameResource($game));
    }

    public function uploadGameFile(GameUploadRequest $request, $slug)
    {
        $this->gamesService->uploadGame($request->validated(), $slug);

        return $this->respondOk();
    }

    // serve game
    public function serveGame($slug, $version){
        $gamePath = 'games/' . $slug . '/' . $version . '/index.html';
        $filePath = public_path($gamePath);

        if (File::exists($filePath)) {
            $content = File::get($filePath);
            return response($content)->header('Content-Type', 'text/html');
        }

        throw new NotFoundException('Game files not found.');

        // $gameFile = $this->gamesService->serveGame($gamePath);


    //    return Response::file($gameFile);
    }

    // edit game
    public function editGame(EditGameRequest $request, $slug)
    {
        $game = $this->gamesService->getGameBySlugAndUser($slug, auth()->user()->id);
        $game->update($request->validated());

        return $this->respondOk();
    }

    // delete game
    public function deleteGame($slug)
    {
        $game = $this->gamesService->getGameBySlugAndUser($slug, auth()->user()->id);
        $this->gamesService->deleteGame($game);

        return response()->json(null, 204);
    }
}
