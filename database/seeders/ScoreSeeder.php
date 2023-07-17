<?php

namespace Database\Seeders;

use App\Models\PlatformUser;
use App\Models\Score;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = PlatformUser::all();

        foreach($users as $user){
            $scores = [
                [
                    'user_id' => $user->id,
                    'game_version_id' => 1,
                    'timestamp' => now(),
                    'score' => 100,
                ],
                [
                    'user_id' => $user->id,
                    'game_version_id' => 2,
                    'timestamp' => now(),
                    'score' => 200,
                ],
                [
                    'user_id' => $user->id,
                    'game_version_id' => 3,
                    'timestamp' => now(),
                    'score' => 500,
                ],
                [
                    'user_id' => $user->id,
                    'game_version_id' => 4,
                    'timestamp' => now(),
                    'score' => 500,
                ],
            ];

            $totalScore = 0;

            foreach($scores as $score)
            {
                Score::create($score);
                $totalScore += $score['score'];
            }

            $user->game_scores = $totalScore;
            $user->save();
        }
    }
}
