<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory; // Bawaan asli kamu[cite: 1]
use Illuminate\Database\Eloquent\Factories\HasFactory; // Bawaan asli kamu[cite: 1]
use Illuminate\Foundation\Auth\User as Authenticatable; // Bawaan asli kamu[cite: 1]
use Illuminate\Notifications\Notifiable; // Bawaan asli kamu[cite: 1]

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable; // Bawaan asli kamu[cite: 1]

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ]; // Bawaan asli kamu[cite: 1]

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ]; // Bawaan asli kamu[cite: 1]

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ]; // Bawaan asli kamu[cite: 1]
    }

    /**
     * Relasi ke model Laporan
     * Satu user bisa memiliki banyak laporan (One to Many)
     */
    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }
}