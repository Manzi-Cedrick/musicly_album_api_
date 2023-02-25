<?php

namespace App\Http\Controllers;

use App\Models\AlbumModel;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function getAlbums()
    {
        try {
            $Album = new AlbumModel();

            $albums = $Album->getAlbums();

            if($albums->count() <= 0) {
                return response()->json([
                    'message' => 'No albums found'
                ]);
            }

            return response()->json([
                'message' => 'Albums retrieved successfully',
                'albums' => $albums
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error retrieving albums',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function getAlbum(string $albumId)
    {
        try {
            $Album = new AlbumModel();

            $album = $Album->getAlbum($albumId);

            if(!$album) {
                return response()->json([
                    'message' => 'Album with id '. $albumId .' not found'
                ]);
            }

            return response()->json([
                'message' => 'Album retrieved successfully',
                'album' => $album
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error retrieving album',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function createAlbum(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:100',
                'release_date' => 'required|string',
                'description' => 'required|string|max:500',
                'cover_image' => 'required|string|max:100'
            ]);

            $albumData = [
                'album_id' => uniqid('album_'),
                'title' => $request->title,
                'release_date' => date('H/M/Y'),
                'description' => $request->description,
                'cover_image' => $request->cover_image
            ];
            
            $Album = new AlbumModel();

            $album = $Album->createAlbum($albumData);

            return response()->json([
                'message' => 'Album created successfully',
                'album' => $album
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error creating album',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function updateAlbum(Request $request, string $albumId)
    {
        try {
            $Album = new AlbumModel();

            $request->validate([
                'title' => 'string|max:100',
                'release_date' => 'string',
                'description' => 'string|max:500',
                'cover_image' => 'string|max:100'
            ]);

            $isAvailable = $Album->getAlbum($albumId);
            
            if (!$isAvailable) {
                return response()->json([
                    'message' => 'Album with id '. $albumId .' not found'
                ]);
            }

            $album = $Album->updateAlbum($albumId, [
                'album_id' => $albumId,
                'title' => $request['title'] ? $request['title'] : $isAvailable['title'],
                'release_date' => $request['release_date'] ? $request['release_date'] : $isAvailable['release_date'],
                'description' => $request['description'] ? $request['description'] : $isAvailable['description'],
                'cover_image' => $request['cover_image'] ? $request['cover_image'] : $isAvailable['cover_image']
            ]);

            return response()->json([
                'message' => 'Album updated successfully',
                'album' => $album
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error updating album',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function deleteAlbum(string $albumId)
    {
        try {
            $Album = new AlbumModel();

            $isAvailable = $Album->getAlbum($albumId);

            if (!$isAvailable) {
                return response()->json([
                    'message' => 'Album with id ' . $albumId . ' not found'
                ]);
            }

            $Album->deleteAlbum($albumId);

            return response()->json([
                'message' => 'Album deleted successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error deleting album',
                'error' => $th->getMessage()
            ]);
        }
    }
}
