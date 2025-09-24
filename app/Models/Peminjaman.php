<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'data_peminjam'; // sesuaikan tabel
    protected $fillable = [
        'user_id', 'laptop_id', 'tanggal_mulai', 'tanggal_selesai'
    ];

    public function laptop()
    {
        return $this->belongsTo(LaptopData::class, 'laptop_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'username'); 
        // username di users digunakan karena user_id di data_peminjam string
    }
}
