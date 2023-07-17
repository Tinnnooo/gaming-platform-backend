<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'game_version_id',
        'timestamp',
        'score',
    ];

    public function user()
    {
        return $this->belongsTo(PlatformUser::class);
    }

    public function gameVersion()
    {
        return $this->belongsTo(GameVersion::class);
    }
}
