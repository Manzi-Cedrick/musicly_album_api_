<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlbumModel extends Model
{
    use HasFactory;

    protected $table = 'albums';

    protected $fillable = [
        'album_id',
        'title',
        'release_date',
        'description',
        'cover_image'
    ];

    public function getAlbums()
    {
        return $this->all();
    }

    public function getAlbum(string $albumId)
    {
        return $this->where('album_id', $albumId)->first();
    }

    public function createAlbum($album)
    {
        return $this->create($album);
    }

    public function updateAlbum(string $albumId, $album)
    {
        $album = $this->where('album_id', $albumId)->update($album);

        if($album) {
            return $this->getAlbum($albumId);
        }
    }

    public function deleteAlbum(string $albumId)
    {
        return $this->where('album_id', $albumId)->delete();
    }
}
