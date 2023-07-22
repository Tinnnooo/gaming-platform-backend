<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameVersion extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'game_id',
        'version_timestamp',
        'path',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id', 'id');
    }

    public function gameScores()
    {
        return $this->hasMany(Score::class, 'game_version_id');
    }
}
