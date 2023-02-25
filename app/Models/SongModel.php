<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SongModel extends Model
{
    use HasFactory;

    protected $table = 'songs';

    protected $fillable = [
        'song_id',
        'title',
        'artist',
        'length',
        'genre',
        'album'
    ];

    public function getSong($songId)
    {
        return $this->where('song_id', $songId)->first();
    }

    public function getAllSongs()
    {
        return $this->all();
    }

    public function createSong($song)
    {
        return $this->create($song);
    }

    public function updateSong($songId, $song)
    {
        $song = $this->where('song_id', $songId)->update($song);

        if($song) {
            return $this->getSong($songId);
        }
    }

    public function deleteSong($songId)
    {
        return $this->where('song_id', $songId)->delete();
    }

    public function getSongsByGenre($genre)
    {
        $genres = $this->getGenres();

        if(!in_array($genre, $genres)) {
            return null;
        }

        return $this->where('genre', $genre)->get();
    }

    public function getGenres()
    {
        return $this->select('genre')->distinct()->get();
    }
}
