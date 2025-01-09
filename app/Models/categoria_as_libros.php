<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categoria_as_Libros extends Model
{
    use HasFactory;

    protected $table = 'categoria_as_libros';

    // Permitir asignación masiva para estos campos
    protected $fillable = [
        'fk_libros',
        'fk_categoria_libros',
    ];
}
