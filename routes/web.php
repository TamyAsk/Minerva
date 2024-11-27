<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LibroController;
use App\Http\Controllers\usuario_coment_librosController;
use App\Http\Controllers\CategoriaLibrosController;
use App\Http\Controllers\UsuarioLibroLikeController;

Route::get('/', function () {
    return view('../auth/login');
});

Route::get('/dashboard', [LibroController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/mis_libros', [LibroController::class, 'show_my_books'])->middleware(['auth', 'verified'])->name('mis_libros');

Route::get('/crear_libros', [CategoriaLibrosController::class, 'index'])->middleware(['auth', 'verified'])->name('crear_libros');

Route::get('/libro/{id}/editar', [LibroController::class, 'edit'])->name('libro.editar');
Route::post('/libro/{id}/actualizar', [LibroController::class, 'update'])->name('libro.actualizar');

Route::get('/libro/publicar/{id}/{estatus}', [LibroController::class, 'publicar'])->name('libro.publicar');
Route::get('/libro/{id}/eliminar', [LibroController::class, 'eliminar'])->name('libro.eliminar');

Route::get('/crear-libro', [LibroController::class, 'create'])->name('crear-libro');
Route::post('/guardar-libro', [LibroController::class, 'store'])->name('guardar-libro');

Route::get('/leer_libro/{id}', [LibroController::class, 'buscar_id'])->name('leer');

Route::get('/favoitos', [UsuarioLibroLikeController::class, 'librosLikes'])->name('fav.libros');   

Route::post('/favoritos/{id}', [UsuarioLibroLikeController::class, 'store'])->name('like');
Route::post('/libro/{id}/ver-despues', [UsuarioLibroLikeController::class, 'guardarVerDespues'])->name('ver_despues');
Route::post('/libro/{id}/visto', [UsuarioLibroLikeController::class, 'guardarVisto'])->name('visto');


//categoria


Route::post('/categorias', [CategoriaLibrosController::class, 'store'])->name('categorias.create');
Route::get('/categorias', [CategoriaLibrosController::class, 'index2'])->name('categorias.form');
Route::get('/categorias/{id}/edit', [CategoriaLibrosController::class, 'edit'])->name('categorias.edit');
Route::put('/categorias/{id}', [CategoriaLibrosController::class, 'update'])->name('categorias.update');
Route::delete('/categorias/{id}', [CategoriaLibrosController::class, 'destroy'])->name('categorias.destroy');

//leer
Route::get('/libro/leer/{id}', [LibroController::class, 'buscar_id_leer'])->name('libro.leer');

//comentario
Route::post('/leer_libro',[LibroController::class, 'crear_comentario'])->name('libro.crear_comentario');

Route::get('/libro/comentario/eliminar/{id}', [usuario_coment_librosController::class,'eliminar_coment'])->name('comentario.eliminar');

Route::get('/libro/calificar/{id}{valor}',[LibroController::class,'calificacion'])->name('calificarlibro');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
