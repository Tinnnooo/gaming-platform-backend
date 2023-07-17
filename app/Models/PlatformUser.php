<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PlatformUser extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'registered_at',
        'last_login_at',
        'game_scores',
        'uploaded_games',
    ];

    public function blocked()
    {
        return $this->hasOne(BlockedUser::class, 'user_id', 'id');
    }

    public function gameScores()
    {
        return $this->hasOne(gameScores::class);
    }

    public function uploadedGames()
    {
        return $this->hasMany(Game::class, 'author_id');
    }
}
