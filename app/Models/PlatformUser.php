<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class PlatformUser extends Authenticatable
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

    public function scores()
    {
        return $this->hasMany(Score::class, 'user_id', 'id');
    }

    public function uploadedGames()
    {
        return $this->hasMany(Game::class, 'author_id');
    }
}
