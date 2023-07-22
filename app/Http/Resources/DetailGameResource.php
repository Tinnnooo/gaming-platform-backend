<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailGameResource extends JsonResource
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
            'thumbnail' => $this->thumbnail ?? null,
            'uploadTimestamp' => $this->latestVersion->version_timestamp ?? null,
            'author' => $this->author->username,
            'scoreCount' => $this->gameVersions->sum(function ($version) {
                return $version->gameScores->count();
            }),
            'gamePath' => $this->latestVersion->path ?? null,
        ];
    }
}
