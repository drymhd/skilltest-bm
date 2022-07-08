<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'harga', 'status', 'type_id'];

    protected $appends = [
        'foto_dir'
    ];

    function getFotoDirAttribute(){
        return asset('images/menu/'.$this->foto);
    }


    public function type()
    {
        return $this->belongsTo(TypeMenu::class, 'type_id', 'id');
    }

    public function Transaksi()
    {
        return $this->belongsToMany(Transaksi::class, 'transaksi_menus', 'menu_id', 'transaksi_id');
    }

    
    
}
