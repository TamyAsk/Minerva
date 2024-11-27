<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usuario_coment_libros extends Model
{
    use HasFactory;

    protected $fillable = [
        'comentarios',
        'fk_libros',
        'usuario_id',
    ];

    public function libro()
    {
        return $this->belongsTo(Libro::class, 'fk_libros');
    }

        public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    
}
