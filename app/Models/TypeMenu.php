<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeMenu extends Model
{
    use HasFactory;

    protected $fillable = ['nama_type'];

    public function Menu()
    {
        return $this->hasMany(Menu::class, 'type_id', 'id');
    }    
}
