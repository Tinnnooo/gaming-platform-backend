<?php

namespace App\Services;

use Exception;
use App\Models\Game;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Exceptions\NotFoundException;
use App\Exceptions\SlugTakenException;
use App\Exceptions\BadRequestException;
use App\Exceptions\ServerBusyException;
use Illuminate\Database\QueryException;
use App\Exceptions\ForbiddenAccessException;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GamesControllerService
{
    public function getGameBySlug($slug)
    {
        $game = Game::where('slug', $slug)->first();
        if(empty($game))
        {
            throw new NotFoundException('Game not found');
        }
        return $game;
    }

    public function validationSortField($sortField)
    {
        $validSortFields = ['title', 'popular', 'uploaddate'];
        if (!in_array($sortField, $validSortFields)) {
            return 'title';
        }

        return $sortField;
    }

    public function sortedGames($query, $sortBy, $sortDir)
    {
        if($sortBy === 'popular'){
            $query->withCount(['gameVersions as score_count' => function ($query) {
                $query->leftJoin('scores', 'game_versions.id', '=', 'scores.game_version_id')
                    ->groupBy('game_id');
            }]);

            $query->whereHas('gameVersions', function ($query) {
                $query->leftJoin('scores', 'game_versions.id', '=', 'scores.game_version_id')
                    ->groupBy('game_id')
                    ->havingRaw('count(*) > 0');
            });

            return $query->orderBy('score_count', $sortDir);
        } else if($sortBy === 'uploaddate'){
            return $query->orderBy(
                DB::raw('(SELECT MAX(version_timestamp) FROM game_versions WHERE game_versions.game_id = games.id)'),
                $sortDir
            );
        } else {
            return $query->orderBy($sortBy, $sortDir);
        }
    }

    public function paginatedGames($request)
    {
        // get parameters
        $page = $request->query('page', 0);
        $size = max($request->query('size', 10), 1);
        $sortDir = $request->query('sortDir', 'asc');
        $sortBy = $this->validationSortField($request->query('sortBy', 'title'));

        // get game
        $query = Game::has('gameVersions');

        $sortResult = $this->sortedGames($query, $sortBy, $sortDir);

        return $sortResult->paginate($size, ['*'], 'page', $page);
    }

    public function post($validator)
    {
        DB::beginTransaction();

        try {
            $game = Game::create([
                'title' => $validator['title'],
                'description' => $validator['description'],
                'author_id' => auth()->user()->id
            ]);

            $user = auth()->user();
            $user->uploaded_games += 1;
            $user->save();

            DB::commit();

            return $game;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new SlugTakenException;
        } catch (Exception $e) {
            DB::rollBack();
            throw new  ServerBusyException;
        }
    }

    public function getGameBySlugAndUser($slug, $user_id)
    {
        $game = Game::where('slug', $slug)->where('author_id', $user_id)->first();
        if(empty($game))
        {
            throw new ForbiddenAccessException('You are not the game author');
        }

        return $game;
    }

    public function uploadGame($data, $slug)
    {
        $game = $this->getGameBySlugAndUser($slug, auth()->user()->id);

        DB::beginTransaction();

        try{
            $gamePath = 'games/' . $slug;
            $version = $game->gameVersions()->count() + 1;
            $versionPath = $gamePath . '/v' . $version;
            $thumbnailPath = null;

            // extract zip

            $zip = new \ZipArchive;
            $zip->open($data['zipfile']->getPathname());

            // check if the zip file contains an index.html
            $indexHtmlExists = false;

            if($zip->getFromName('index.html')){
                $indexHtmlExists = true;
            }

            if(!$indexHtmlExists){
                throw new BadRequestException('Upload failed. The ZIP file must contain an index.html file');
            }

            // Extract the ZIP file
            $zip->extractTo(public_path($versionPath));
            $zip->close();

            $imageExtensions = ['jpg', 'jpeg', 'png'];

            $thumbnailPath = null;

            foreach($imageExtensions as $extension){
                $imageFile = $versionPath. '/thumbnail.' . $extension;

                if(File::exists(public_path($imageFile))){
                    $thumbnailPath = $imageFile;
                    break;
                }
            }

            if($thumbnailPath){
                $game->thumbnail = $thumbnailPath;
                $game->save();
            }


            $game->gameVersions()->create([
                'game_id' => $game->id,
                'version_timestamp' => now(),
                'path' => $versionPath,
            ]);

            DB::commit();
        } catch (BadRequestException $e){
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();

            throw new ServerBusyException;
        }
    }

    public function serveGame($gamePath)
    {
        if(File::exists(public_path($gamePath))){
            $indexHtmlPath = public_path($gamePath);
            if(File::exists($indexHtmlPath)){
                return new BinaryFileResponse($indexHtmlPath);
            }
        }

        throw new NotFoundException('Game files not found.');
    }

    public function deleteGame($game)
    {
        $game->gameVersions()->delete();

        $this->deleteGameFolder($game);

        $game->delete();
    }

    public function deleteGameFolder($game)
    {
        $gamePath = 'games/' . $game->slug;

        if(File::exists(public_path($gamePath))){
            File::deleteDirectory(public_path($gamePath));
        }
    }
}
