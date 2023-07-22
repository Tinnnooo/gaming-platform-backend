<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $highestScores = $this->calculateHighestScores();

        return [
            'username' => $this->username,
            'registeredTimestamp' => $this->registered_at,
            'authoredGames' => new UserGamesCollection($this->uploadedGames),
            'highscores' => $highestScores,
        ];
    }

    protected function calculateHighestScores() : array
    {
        $highestScores = [];

        $groupedScores = $this->scores->groupBy('game_version_id');

        foreach($groupedScores as $gameVersionId => $scores){
            $highestScore = $scores->max('score');
            $gameVersion = $scores->first()->gameVersion;

            $highestScores[] = [
                'game' => new UserGamesResource($gameVersion->game),
                'score' => $highestScore,
                'timestamp' => $scores->max('timestamp'),
            ];
        }

        return $highestScores;
    }
}
