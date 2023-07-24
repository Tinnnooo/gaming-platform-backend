<?php

namespace App\Services;

use App\Exceptions\ServerBusyException;
use App\Models\Score;
use Illuminate\Support\Facades\DB;

class ScoresControllerService
{
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
