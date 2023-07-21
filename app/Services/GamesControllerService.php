<?php

namespace App\Services;

use App\Models\Game;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class GamesControllerService
{
    public function post($validator)
    {
        DB::beginTransaction();

        try{
            $game = Game::create([
                'title' => $validator['title'],
                'description' => $validator['description'],
                'author_id' => auth()->user()->id
            ]);
            DB::commit();

            return $game;
        } catch (ValidationException $e)
        {
            DB::rollBack();
                return response()->json([
                    'status' => 'invalid',
                    'slug' => 'Game title already exist'
                ], 400);
        } catch (Exception $e)
        {
            DB::rollBack();
            throw new Exception('Something went wrong.');
        }
    }
}
