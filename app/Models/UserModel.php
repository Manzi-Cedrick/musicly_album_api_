<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUser($userId)
    {
        return $this->where('user_id', $userId)->first();
    }

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function createUser($user)
    {
        return $this->create($user);
    }

    public function updateUser($userId, $user)
    {
        $user = $this->where('user_id', $userId)->first()->udpate($user);

        if ($user) {
            return $this->getUser($userId);
        }
    }

    public function deleteUser($userId)
    {
        return $this->where('user_id', $userId)->delete();
    }
}
