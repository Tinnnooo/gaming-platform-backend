<?php

namespace App\Services;

use App\Exceptions\SlugTakenException;
use App\Models\Game;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;


class GamesControllerService
{
    public function post($validator)
    {
        DB::beginTransaction();

        try {
            $game = Game::create([
                'title' => $validator['title'],
                'description' => $validator['description'],
                'author_id' => auth()->user()->id
            ]);
            DB::commit();

            return $game;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new SlugTakenException;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Something went wrong.');
        }
    }
}
