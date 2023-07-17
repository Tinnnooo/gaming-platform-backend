<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GameVersion;
use App\Models\PlatformUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = PlatformUser::all();

        foreach($users as $user){
            $games = [
                [
                    'title' => 'Game 1',
                    'description' => 'This is game 1',
                    'thumbnail' => 'game1_thumbnail.jpg',
                    'slug' => 'game-1',
                    'author_id' => $user->id,
                ],
                [
                    'title' => 'Game 2',
                    'description' => 'This is game 2',
                    'thumbnail' => 'game2_thumbnail.jpg',
                    'slug' => 'game-2',
                    'author_id' => $user->id,
                ],
            ];

            foreach($games as $gameData){
                $game = Game::create($gameData);
                $user->uploaded_games++;
                $user->save();

                $gameVersion = [
                    [
                        'game_id' => $game->id,
                        'version_timestamp' => now(),
                        'path' => 'game1_version1.zip',
                    ],
                    [
                        'game_id' => $game->id,
                        'version_timestamp' => now(),
                        'path' => 'game1_version2.zip',
                    ],
                ];


                foreach($gameVersion as $version){
                    GameVersion::create($version);
                }
            }
        }
    }
}
