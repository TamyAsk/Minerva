<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset('css/mostrar_libro.css')}}">
    <title>{{ $libro->titulo }}</title>
</head>
<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $libro->titulo }}
            </h2>
        </x-slot>

        <div class="max-w-7xl mx-auto py-12 flex">
            <img src="{{ asset($libro->portada) }}" alt="{{ $libro->titulo }}" style="width: 230px; height: 340px">
            
            <div class="px-6">
                <p>{{ $libro->introduccion }}</p>
                <br>
                <div class="icon-container">
                    <div class="left-icons">
                        <!-- Botones de like, guardar, etc. -->
                        <form action="{{route('like',['id' => $libro->pk_libros,])}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-like">  
                                @if ($tieneLike)
                                    <i class="fa-solid fa-heart icon"></i>
                                @else
                                    <i class="fa-regular fa-heart icon"></i>
                                @endif                          
                            </button>          
                        </form>
                        
                        <form action="{{route('ver_despues',['id' => $libro->pk_libros,])}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-ver-despues">
                                @if ($tieneVerDespues)
                                    <i class="fa-solid fa-bookmark icon"></i>
                                @else
                                    <i class="fa-regular fa-bookmark icon"></i>
                                @endif
                            </button>
                        </form>
                        
                        <form action="{{route('visto', ['id' => $libro->pk_libros,])}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-visto">
                                @if ($tieneVisto)
                                    <i class="fa-solid fa-eye icon"></i>
                                @else
                                    <i class="fa-regular fa-eye icon"></i>
                                @endif
                            </button>
                        </form>
                                <br><!-- Sistema de calificación -->
                        <div class="rating-container">
                            <a href="{{route('calificarlibro',['id' => $libro->pk_libros,'valor' => 1])}}"><i class="fa-regular fa-star star" data-value="1"></i></a>
                            <a href="{{route('calificarlibro',['id' => $libro->pk_libros,'valor' => 2])}}"><i class="fa-regular fa-star star" data-value="2"></i></a>
                            <a href="{{route('calificarlibro',['id' => $libro->pk_libros,'valor' => 3])}}"><i class="fa-regular fa-star star" data-value="3"></i></a>
                            <a href="{{route('calificarlibro',['id' => $libro->pk_libros,'valor' => 4])}}"><i class="fa-regular fa-star star" data-value="4"></i></a>
                            <a href="{{route('calificarlibro',['id' => $libro->pk_libros,'valor' => 5])}}"><i class="fa-regular fa-star star" data-value="5"></i></a>
                        </div>
                    
                    </div>
                

                    <a href="{{route('libro.leer',['id'=>$libro->pk_libros])}}" class="btn-leer">Leer</a>
                </div>                

                <!-- Formulario de comentarios debajo de los iconos -->
                <form class="form-comentario" action="{{route('libro.crear_comentario')}}" method="POST">
                    @csrf
                    <input type="hidden" name="fk_libros" value="{{ $libro->pk_libros }}">
                    <input type="text" name="comentarios" placeholder="Escribe un comentario..." required>
                    <button type="submit">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>

                <!-- Mostrar comentarios --> <br>
                <h3 class="comentarios-titulo">Comentarios:</h3>
                <div class="comentarios-container">
                    @forelse($libro->comentarios as $comentario)
                        <div class="comentario-item">
                            <div class="comentario-text">
                                <p>
                                    <strong>{{ ucfirst(strtolower($comentario->usuario->name)) }}:</strong>
                                    {{ $comentario->comentarios }}
                                </p>
                            </div>
                            <div class="comentario-fecha">
                                @if (auth()->user()->rango)
                                    <a href="{{ route('comentario.eliminar', ['id' => $comentario->id]) }}" class="comentario-eliminar">
                                        Eliminar
                                    </a>
                                @else
                                    @if (auth()->id() == $comentario->usuario_id)
                                        <a href="{{ route('comentario.eliminar', ['id' => $comentario->id]) }}" class="comentario-eliminar">
                                            Eliminar
                                        </a>
                                    @endif    
                                @endif                                                       
                                <small>{{ $comentario->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="sin-comentarios">No hay comentarios para este libro.</p>
                    @endforelse
                </div>                                  
            </div>
        </div>
    </x-app-layout>
    <script src="{{asset('js/mostrar_libro.js')}}"></script>
</body>
</html>
