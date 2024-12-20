<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['nim', 'name', 'ukt_paid'];

    // Tambahkan casting untuk enkripsi
    protected $casts = [
        'nim'=> 'encrypted',
        'name' => 'encrypted', // Nama akan dienkripsi secara otomatis
        'ukt_paid' => 'boolean', // Tetap gunakan cast boolean untuk kolom ini
    ];
}
