<?php

namespace App\Http\Controllers;

use App\Models\SongModel;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function getSongs()
    {
        try {
            $Song = new SongModel();

            $songs = $Song->getAllSongs();

            if($songs->count() <= 0) {
                return response()->json([
                    'message' => 'No songs found'
                ]);
            }

            return response()->json([
                'message' => 'Songs retrieved successfully',
                'songs' => $songs
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error retrieving songs',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function getSong(string $songId)
    {
        try {
            $Song = new SongModel();

            $song = $Song->getSong($songId);

            if(!$song) {
                return response()->json([
                    'message' => 'Song with id '. $songId .' not found'
                ]);
            }

            return response()->json([
                'message' => 'Song retrieved successfully',
                'song' => $song
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error retrieving song',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function createSong(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:100',
                'artist' => 'required|string|max:50',
                'length' => 'required|integer',
                'genre' => 'required|string|max:100',
                'album' => 'required|string|max:100|exists:albums,album_id'
            ]);

            $Song = new SongModel();

            $songData = [
                'song_id' => uniqid('song_'),
                'title' => $request->title,
                'artist' => $request->artist,
                'length' => $request->length,
                'genre' => strtolower($request->genre),
                'album' => $request->album
            ];
            
            $song = $Song->createSong($songData);

            return response()->json([
                'message' => 'Song created successfully',
                'song' => $song
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error creating song',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function updateSong(Request $request, string $songId)
    {
        try {
            $Song = new SongModel();

            $request->validate([
                'title' => 'string|max:100',
                'artist' => 'string|max:50',
                'length' => 'integer',
                'genre' => 'string|max:100',
                'album' => 'string|max:100|exists:albums,album_id'
            ]);

            $isAvailable = $Song->getSong($songId);
            
            if (!$isAvailable) {
                return response()->json([
                    'message' => 'Song with id '. $songId .' not found'
                ]);
            }
            
            $albumData = [
                'song_id' => $isAvailable['song_id'],
                'title' => $request->title ? $request->title : $isAvailable['title'],
                'artist' => $request->artist ? $request->artist : $isAvailable['artist'],
                'length' => $request->length ? $request->length : $isAvailable['length'],
                'genre' => $request->genre ? strtolower($request->genre) : $isAvailable['genre'],
                'album' => $request->album ? $request->album : $isAvailable['album']
            ];
            
            $song = $Song->updateSong($songId, $albumData);

            return response()->json([
                'message' => 'Song updated successfully',
                'song' => $song
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error updating song',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function deleteSong(string $songId)
    {
        try {
            $Song = new SongModel();

            $isAvailable = $Song->getSong($songId);

            if (!$isAvailable) {
                return response()->json([
                    'message' => 'Song with id '. $songId .' not found'
                ]);
            }

            $Song->deleteSong($songId);

            return response()->json([
                'message' => 'Song deleted successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error deleting song',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function getGenres()
    {
        try {
            $Song = new SongModel();

            $genres = $Song->getGenres();

            if($genres->count() <= 0) {
                return response()->json([
                    'message' => 'No genres found'
                ]);
            }

            return response()->json([
                'message' => 'Genres retrieved successfully',
                'genres' => $genres
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error retrieving genres',
                'error' => $th->getMessage() . 'retrieving genres'
            ]);
        }
    }

    public function getSongsByGenre(string $genre)
    {
        try {
            $Song = new SongModel();

            $isGenreAvailable = $Song->getGenres()->contains('genre', strtolower($genre));

            if(!$isGenreAvailable) {
                return response()->json([
                    'message' => 'Genre '. $genre .' not found'
                ]);
            }

            $songs = $Song->getSongsByGenre($genre);

            if($songs->count() <= 0) {
                return response()->json([
                    'message' => 'No songs found'
                ]);
            }

            return response()->json([
                'message' => 'Songs retrieved successfully',
                'songs' => $songs
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error retrieving songs',
                'error' => $th->getMessage()
            ]);
        }
    }
}
