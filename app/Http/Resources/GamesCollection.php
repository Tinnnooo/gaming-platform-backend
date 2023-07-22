<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GamesCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'page' =>(int) $this->currentPage(),
            'size' => (int)$this->perPage(),
            'totalElements' => (int)$this->total(),
            'content' => $this->collection,
        ];
    }
}
