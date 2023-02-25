<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlbumTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('albums')->insert([
            [
                'album_id' => 'album_dasdfh84231',
                'title' => 'The Dark Side of the Moon',
                'release_date' => '1973-03-01',
                'description' => 'The eighth studio album by Pink Floyd',
                'cover_image' => 'https://picsum.photos/200/300',
            ],
            [
                'album_id' => 'asdfkjasdfj_asdkflajsd',
                'title' => 'Abbey Road',
                'release_date' => '1969-09-26',
                'description' => 'The eleventh studio album by The Beatles',
                'cover_image' => 'https://picsum.photos/200/300',
            ],
            [
                'album_id' => 'asdlaskdj_123123',
                'title' => 'Thriller',
                'release_date' => '1982-11-30',
                'description' => 'The sixth studio album by Michael Jackson',
                'cover_image' => 'https://picsum.photos/200/300',
            ],
        ]);
    }
}
