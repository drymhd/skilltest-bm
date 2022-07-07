<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = ['kd_transaksi', 'nama_pembeli', 'tgl_transaksi', 'alamat', 'status'];

    public function menu()
    {
        return $this->belongsToMany(Menu::class, 'transaksi_menus', 'transaksi_id', 'menu_id');
    }
}
