<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginateGamesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->title,
            'thumbnail' => $this->thumbnail,
            'uploadTimestamp' => $this->latestVersion->version_timestamp,
            'author' => $this->author->username,
            'scoreCount' => $this->gameVersions->sum(function ($version) {
                return $version->gameScores->count();
            })
        ];
    }
}
