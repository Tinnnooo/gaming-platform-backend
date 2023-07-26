<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Exceptions\ServerBusyException;
use App\Models\Game;
use App\Models\Score;
use Illuminate\Support\Facades\DB;

class ScoresControllerService
{
    public function getGameBySlugWithScore($slug)
    {
        $game = Game::with(['gameVersions.gameScores' => function ($query) {
            $query->orderBy('score', 'desc');
        }])
        ->where('slug', $slug)
        ->first();

        if(empty($game)){
            throw new NotFoundException;
        }

        return $game;
    }

    public function collectScores ($game){
        // Collect the highest scores for each player from all versions of the game
        $highScores = [];
        foreach ($game->gameVersions as $version) {
            foreach ($version->gameScores as $score) {
                $username = $score->user->username; // Fetch the username from the user relationship

                // If the user is not in the highScores array or the current score is higher, update the max score
                if (!isset($highScores[$username]) || $score->score > $highScores[$username]['score']) {
                    $highScores[$username] = [
                        'username' => $username,
                        'score' => $score->score,
                        'timestamp' => $score->timestamp,
                    ];
                }
            }
        }

        // Convert the associative array to a sequential array (optional)
        $highScores = array_values($highScores);

        return [
            'scores' => $highScores
        ];
    }

    public function storeScore($score, $game)
    {
        $version = $game->latestVersion;

        DB::beginTransaction();

        try{
            Score::create([
                'user_id' => auth()->user()->id,
                'game_version_id' => $version->id,
                'score' => $score['score'],
                'timestamp' => now(),
            ]);

            DB::commit();

            return;
        } catch (\Exception $e) {
            DB::rollBack();

            throw new ServerBusyException;
        }

    }
}
