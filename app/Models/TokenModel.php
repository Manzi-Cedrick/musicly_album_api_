<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenModel extends Model
{
    use HasFactory;

    protected $table = 'tokenblacklist';

    protected $fillable = [
        'token'
    ];

    public function getToken(String $token)
    {
        return $this->where('token', $token)->first();
    }

    public function addToken($token)
    {
        return $this->create($token);
    }
}
