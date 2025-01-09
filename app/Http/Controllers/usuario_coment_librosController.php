<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usuario_coment_libros;

class usuario_coment_librosController extends Controller
{
    public function eliminar_coment($id){
        // Eliminar el comentario de la base de datos
        $comentario = usuario_coment_libros::find($id);
        $comentario->delete();

        // Redireccionar a la página de comentarios
        return back();
    }
}
