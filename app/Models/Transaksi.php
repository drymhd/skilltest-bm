<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = ['kd_transaksi', 'nama_pembeli', 'tgl_transaksi', 'alamat', 'status', 'phone', 'token', 'type_transaksi' ,'c_pelanggan', 'meja_id'];

    public function menu()
    {
        return $this->belongsToMany(Menu::class, 'transaksi_menus', 'transaksi_id', 'menu_id');
    }

    public function meja()
    {
        return $this->belongsTo(Meja::class, 'meja_id', 'id');
    }
}
