<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use laravel\sanctum\HasApiTokens;

class VisitorModel extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $guarded = ['id'];
    protected $guard = 'visitor' ;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];

    }

}
