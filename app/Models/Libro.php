<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'usuario_id',
        'introduccion',
        'portada',
        'contenido',
        'estatus',
        'publico_edad'
    ];

    protected $table = 'libros'; // Nombre de la tabla
    protected $primaryKey = 'pk_libros'; // Clave primaria

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function categorias()
    {
        return $this->belongsToMany(categoria_libros::class, 'categoria_as_libros', 'fk_libros', 'fk_categoria_libros');
    }

    public function usuariosQueDieronLike() { 
        return $this->belongsToMany(Usuario::class, 'usuario_libro_like', 'fk_libros', 'usuario_id');
    }

    public function comentarios()
    {
        return $this->hasMany(usuario_coment_libros::class, 'fk_libros');
    }

    public function calificaciones()
    {
        return $this->hasMany(calificacion_libros::class, 'fk_libros');
    }

}