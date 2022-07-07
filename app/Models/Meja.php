<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use HasFactory;

    protected $fillable = ['no_meja', 'status', 'hal_meja_id', 'type_meja_id'];

    public function halaman()
    {
        return $this->belongsTo(TypeHalamanMeja::class, 'hal_meja_id', 'id');
    }
    
    public function type()
    {
        return $this->belongsTo(TypeMeja::class, 'type_meja_id', 'id');
    }
}
