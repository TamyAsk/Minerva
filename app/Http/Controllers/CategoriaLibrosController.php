<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\categoria_libros;

class CategoriaLibrosController extends Controller
{
    public function index()
    {
        $caregoria_libros = categoria_libros::all();
        return view('creacion_libros', ['caregoria_libros' => $caregoria_libros]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_categoria' => 'required|string|max:255',
            'color' => 'required|string|size:7', // Validar que el color es un código hexadecimal
        ]);

        categoria_libros::create([
            'nom_categoria' => $request->nom_categoria,
            'color' => $request->color,
        ]);

        return redirect()->back()->with('success', 'Categoría creada exitosamente');
    }

    public function edit($id)
    {
        $categoria = categoria_libros::findOrFail($id);
        return view('categoria_edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_categoria' => 'required|string|max:255',
            'color' => 'required|string|size:7',
        ]);

        $categoria = categoria_libros::findOrFail($id);
        $categoria->update([
            'nom_categoria' => $request->nom_categoria,
            'color' => $request->color,
        ]);

        return redirect()->route('categorias.form')->with('success', 'Categoría actualizada exitosamente');
    }

    public function destroy($id)
    {
        $categoria = categoria_libros::findOrFail($id);
        $categoria->delete();

        return redirect()->back()->with('success', 'Categoría eliminada exitosamente');
    }

    public function index2()
    { 
        $categorias = categoria_libros::all(); 
        return view('formulario_categoria', compact('categorias'));
    }

}
