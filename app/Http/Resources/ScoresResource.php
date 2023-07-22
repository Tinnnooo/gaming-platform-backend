<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScoresResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $highestScore = $this->gameScores->max('score');
        $highestScoreEntry = $this->gameScores->firstWhere('score', $highestScore);
        return [
            'username' => $highestScoreEntry->user->username,
            'score' => $highestScore,
            'timestamp' => $highestScoreEntry->timestamp,
        ];
    }
}
