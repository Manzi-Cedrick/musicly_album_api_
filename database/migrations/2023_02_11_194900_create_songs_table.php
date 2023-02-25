<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('songs', function (Blueprint $table) {            
            $table->id();
            $table->string('song_id')->unique();
            $table->string('title', 100);
            $table->string('artist', 50);
            $table->integer('length')->default(0);
            $table->string('genre')->default('other');
            $table->foreign('album')->references('album_id')->on('albums')->onDelete('cascade');
            $table->string('album');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('songs');
    }
};
