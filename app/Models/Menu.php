<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'harga', 'status', 'type_id'];

    public function type()
    {
        return $this->belongsTo(TypeMenu::class, 'type_id', 'id');
    }

    public function Transaksi()
    {
        return $this->hasMany(Transaksi::class, 'menu_id', 'id');
    }
    
}
