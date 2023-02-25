<?php

namespace Database\Seeders;

use App\Models\AlbumModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SongTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('songs')->insert([
            [
                'song_id' => 'S00001',
                'title' => 'Song Title 1',
                'artist' => 'Artist Name 1',
                'length' => 3.50,
                'genre' => 'Pop',
                'album' => 'album_dasdfh84231',
            ],
            [
                'song_id' => 'S00002',
                'title' => 'Song Title 2',
                'artist' => 'Artist Name 2',
                'length' => 4.20,
                'genre' => 'Rock',
                'album' => 'album_dasdfh84231',
            ],
            [
                'song_id' => 'S00003',
                'title' => 'Song Title 3',
                'artist' => 'Artist Name 3',
                'length' => 2.45,
                'genre' => 'Hip Hop',
                'album' => 'album_dasdfh84231',
            ]
        ]);
    }
}
