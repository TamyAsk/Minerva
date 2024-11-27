<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria_libros extends Model
{
    use HasFactory;

    protected $table = 'categoria_libros'; // Nombre de la tabla
    protected $primaryKey = 'pk_categoria_libros'; // Clave primaria

    protected $fillable = ['nom_categoria', 'color'];

    public function libros()
    {
        return $this->belongsToMany(Libro::class, 'categoria_as_libros', 'fk_categoria_libros', 'fk_libros');
    }
}
