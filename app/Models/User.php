<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = "id";
    protected $fillable = [
        'nip', 'nama_user', 'email','no_hp','password','serial_device','alamat','jabatan_id','foto_user'
    ];
    protected $hidden = [
        'password','',
    ];
}