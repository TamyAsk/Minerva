<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro;
use App\Models\categoria_libros;
use App\Models\usuario_coment_libros;
use App\Models\categoria_as_libros;
use App\Models\calificacion_libros;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LibroController extends Controller
{
    public function create()
    {
        return view('creacion_libros');
    }

    public function index(Request $request)
        {
            $categorias = categoria_libros::all(); 
            $categoriaSeleccionada = $request->get('categoria');
            $buscador = $request->get('buscador');
            
            // Obtener la edad del usuario autenticado
            $edadUsuario = auth()->user()->age;
    
            // Filtrar libros según la categoría seleccionada y la edad del usuario
            $libros = Libro::with('categorias')
                ->when($categoriaSeleccionada, function ($query) use ($categoriaSeleccionada) {
                    return $query->whereHas('categorias', function ($q) use ($categoriaSeleccionada) {
                        $q->where('nom_categoria', $categoriaSeleccionada);
                    });
                })
                ->when($buscador, function ($query) use ($buscador) {
                    return $query->where('titulo', 'like', "%{$buscador}%");
                })
                ->when($edadUsuario <= 12, function ($query) {
                    return $query->where('publico_edad', 12);
                })
                ->when($edadUsuario >= 13 && $edadUsuario <= 17, function ($query) {
                    return $query->whereIn('publico_edad', [12, 17]);
                })
                ->when($edadUsuario >= 18, function ($query) {
                    return $query;
                })
                ->get();
    
            if ($request->ajax()) {
                return view('partials.libros_list', compact('libros'))->render();
            }
    
            return view('dashboard', compact('libros', 'categorias', 'categoriaSeleccionada'));
        }

        public function show_my_books()
        {
            $user = Auth::user(); // Obtener al usuario autenticado
        
            // Verificar el rango del usuario
            if ($user->rango == 1) {
                // Si el usuario es administrador, mostrar todos los libros
                $libros = Libro::all();
            } else {
                // Si el usuario no es administrador, mostrar solo sus libros
                $libros = Libro::where('usuario_id', $user->id)->get();
            }
        
            return view('mis_libros', ['libros' => $libros]);
        }
        

    public function store(Request $request)
{
    $request->validate([
        'titulo' => 'required|string|max:255',
        'introduccion' => 'required|string|max:1000',
        'portada' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Cambiado a nullable
        'contenido' => 'required|string',
        'estatus' => 'required|integer|max:2',
        'fk_categoria_libros' => 'required|array|min:1|max:3', // Validar arreglo de categorías
        'fk_categoria_libros.*' => 'nullable|exists:categoria_libros,pk_categoria_libros', // Validar cada categoría
    ]);

    // Procesar la portada
    if ($request->hasFile('portada')) {
        $filename = time() . '_' . $request->file('portada')->getClientOriginalName();
        $request->file('portada')->move(public_path('portadas'), $filename);
        $portadaPath = 'portadas/' . $filename;
    } else {
        $portadaPath = 'portadas/Portada_ejemplo.jpg'; // Imagen predeterminada
    }

    // Crear el libro
    $libro = Libro::create([
        'titulo' => $request->titulo,
        'usuario_id' => Auth::id(),
        'introduccion' => $request->introduccion,
        'portada' => $portadaPath,
        'contenido' => $request->contenido,
        'estatus' => $request->estatus,
        'publico_edad' => $request->publico_edad
    ]);

    // Asignar las categorías al libro
    foreach ($request->fk_categoria_libros as $categoria_id) {
        if (!empty($categoria_id)) {
            categoria_as_Libros::create([
                'fk_libros' => $libro->pk_libros,
                'fk_categoria_libros' => $categoria_id,
            ]);
        }
    }

    return redirect()->route('mis_libros')->with('success', 'Libro creado exitosamente');
}


    public function edit($id)
    {
        $libro = Libro::findOrFail($id);
        $categoria_libros = categoria_libros::all(); // Asegúrate de que `CategoriaLibro` sea el modelo correcto de las categorías

        return view('editar_libros', compact('libro', 'categoria_libros'));
    }


    // Método para actualizar el libro en la base de datos
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'introduccion' => 'required|string|max:1000',
            'contenido' => 'required|string',
            'fk_categoria_libros' => 'required|array|min:1|max:3', // Asegúrate de que solo se pueda seleccionar hasta 3 categorías
        ]);
    
        $libro = Libro::findOrFail($id);
        $libro->titulo = $request->input('titulo');
        $libro->introduccion = $request->input('introduccion');
        $libro->contenido = $request->input('contenido');
    
        // Si hay una nueva portada, actualizarla
        if ($request->hasFile('portada')) {
            $filename = $request->file('portada')->getClientOriginalName();
            $request->file('portada')->move(public_path('portadas'), $filename);
            $libro->portada = 'portadas/' . $filename;
        }
    
        $libro->save();
    
        // Actualizar las categorías del libro
        // Primero, eliminar las categorías antiguas
        // Primero, eliminar las categorías antiguas
        $libro->categorias()->detach();

        // Luego, asignar las nuevas categorías seleccionadas
        foreach ($request->fk_categoria_libros as $categoria_id) {
            if (!empty($categoria_id)) {
                $libro->categorias()->attach($categoria_id);
            }
        }

    
        return redirect()->route('mis_libros')->with('success', 'Libro actualizado exitosamente!');
    }
    

    public function publicar(Request $request, $id, $estatus)
    {
        $libro = Libro::findOrFail($id);
        
        // Cambia el estatus del libro
        $libro->estatus = $estatus; // 2 para publicar, 1 para bajar
        $libro->save();
    
        // Mensaje basado en el estatus
        $mensaje = $estatus == 2 ? 'Libro publicado exitosamente!' : 'Libro bajado exitosamente!';
    
        return redirect()->route('mis_libros')->with('success', $mensaje);
    }
    

    public function eliminar(Request $request, $id)
    {
        $libro = Libro::findOrFail($id);
        $libro->estatus = 0; // Publicado
        $libro->save();

        return redirect()->route('mis_libros')->with('success', 'Libro publicado exitosamente!');
    }

public function buscar_id(Request $request, $id)
{
    $libro = Libro::with(['comentarios', 'calificaciones'])->findOrFail($id);
    $usuario = Auth::user();
    
    // Verifica si el usuario ha interactuado con el libro
    $tieneLike = $usuario->librosLikes->contains($libro);
    $tieneVerDespues = $usuario->librosVerDespues->contains($libro);
    $tieneVisto = $usuario->librosVistos->contains($libro);

    // Calcula el promedio de las calificaciones
    $promedioCalificacion = $libro->calificaciones->avg('calificacion');

    return view('mostrar_libro', compact('libro', 'tieneLike', 'tieneVerDespues', 'tieneVisto', 'promedioCalificacion'));
}

    
    public function buscar_id_leer(Request $request,$id){

        $libro = Libro::find($id);

        return view('leer_libro', compact('libro'));
    }

    public function crear_comentario(Request $request){
        // Verifica los datos que se están recibiendo
    
        $comentario = new usuario_coment_libros();
        $comentario->comentarios = $request->comentarios;
        $comentario->usuario_id = auth()->id();
        $comentario->fk_libros = $request->fk_libros;
        $comentario->save();
    
        // Redirigir con mensaje de éxito
        return redirect()->back()->with('success', 'Comentario agregado correctamente.');
    }
    
    public function show($id)
    {
        $libro = Libro::with('comentarios')->findOrFail($id);
        
        return view('libros.show', compact('libro'));
    }

public function calificacion($id, $valor)
{
    $usuarioId = auth()->id();
    
    // Verifica si el usuario ya ha calificado este libro
    $calificacionExistente = calificacion_libros::where('fk_libros', $id)
        ->where('usuario_id', $usuarioId)
        ->first();
    
    // Si ya existe una calificación, elimínala
    if ($calificacionExistente) {
        $calificacionExistente->delete();
    }

    // Ahora guarda la nueva calificación
    $calificacion_libros = new calificacion_libros();
    $calificacion_libros->calificacion = $valor;
    $calificacion_libros->usuario_id = $usuarioId;
    $calificacion_libros->fk_libros = $id;
    $calificacion_libros->save();
    
    return redirect()->back()->with('success', 'Calificación actualizada correctamente.');
}


}