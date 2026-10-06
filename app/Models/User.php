<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'phone', 'address'];
    protected $hidden   = ['password', 'remember_token'];
    protected $casts    = ['password' => 'hashed'];

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function reservasi()     { return $this->hasMany(Reservasi::class); }
    public function kesan()         { return $this->hasMany(KesanPengunjung::class); }
    public function tiketDigital()  { return $this->hasMany(TiketDigital::class); }
}
