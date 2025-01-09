<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usuario_libro_like;
use App\Models\usuario_libro_ver_despues;
use App\Models\usuario_libro_visto;
use Illuminate\Support\Facades\Auth; 

class UsuarioLibroLikeController extends Controller
{
    public function store($id)
    {
        $user_id = Auth::user()->id;

        $like = usuario_libro_like::where('fk_libros', $id)
                                ->where('usuario_id', $user_id)
                                ->first();

        if ($like) {
            usuario_libro_like::where('pk_usuario_libro_like', $like->pk_usuario_libro_like)->delete();
            return back()->with('message', 'Libro eliminado de favoritos!');
        } else {
            $newLike = new usuario_libro_like();
            $newLike->fk_libros = $id;
            $newLike->usuario_id = $user_id;
            $newLike->save();
            return back()->with('message', 'Libro añadido a favoritos!');
        }
    }

    public function guardarVerDespues($id)
    {
        $user_id = Auth::user()->id;

        $verDespues = usuario_libro_ver_despues::where('fk_libros', $id)
                                               ->where('usuario_id', $user_id)
                                               ->first();

        if ($verDespues) {
            usuario_libro_ver_despues::where('pk_usuario_libro_ver_despues', $verDespues->pk_usuario_libro_ver_despues)->delete();
            return back()->with('message', 'Libro eliminado de la lista de ver después!');
        } else {
            $newVerDespues = new usuario_libro_ver_despues();
            $newVerDespues->fk_libros = $id;
            $newVerDespues->usuario_id = $user_id;
            $newVerDespues->save();
            return back()->with('message', 'Libro añadido a la lista de ver después!');
        }
    }

    public function guardarVisto($id)
    {
        $user_id = Auth::user()->id;

        $visto = usuario_libro_visto::where('fk_libros', $id)
                                    ->where('usuario_id', $user_id)
                                    ->first();

        if ($visto) {
            usuario_libro_visto::where('pk_usuario_libro_visto', $visto->pk_usuario_libro_visto)->delete();
            return back()->with('message', 'Libro eliminado de vistos!');
        } else {
            $newVisto = new usuario_libro_visto();
            $newVisto->fk_libros = $id;
            $newVisto->usuario_id = $user_id;
            $newVisto->save();
            return back()->with('message', 'Libro marcado como visto!');
        }
    }

    public function librosLikes()
    {
        $usuario = Auth::user(); // Obtén el usuario autenticado
        $librosLikes = $usuario->librosLikes; // Obtén los libros a los que ha dado "like"

        $librosVerDespues = $usuario->librosVerDespues; // Asegúrate de tener una relación definida

        $librosVistos = $usuario->librosVistos; // Asegúrate de tener una relación definida
        
        return view('favoritos', compact('librosLikes','librosVerDespues','librosVistos'));
    }
}
