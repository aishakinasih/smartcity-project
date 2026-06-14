<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $guarded = []; // Bawaan asli kamu

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}