<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class calificacion_libros extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'usuario_id',
        'calificacion',
    ];

    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
    
    
}
