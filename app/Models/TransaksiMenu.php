<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiMenu extends Model
{
    use HasFactory;

    protected $fillable = ['menu_id', 'transaksi_id', 'total_menu', 'harga_menu'];
}
