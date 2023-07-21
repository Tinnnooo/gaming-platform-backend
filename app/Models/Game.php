<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'slug',
        'author_id',
    ];

    protected $hidden = ['status'];

    public function author()
    {
        return $this->belongsTo(PlatformUser::class, 'author_id');
    }

    public function gameVersions()
    {
        return $this->hasMany(GameVersion::class);
    }

    public function latestVersion()
    {
        return $this->hasOne(GameVersion::class)->latest('version_timestamp');
    }

    protected static function booted()
    {
        static::creating(function ($game) {
            $game->slug = Str::slug($game->title);
        });
    }
}
