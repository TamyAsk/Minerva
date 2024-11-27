@if($libros->isEmpty())
    <p style="text-align: center; color: #7f8c8d; font-size: 1.2rem;">{{ __('No hay libros disponibles para mostrar.') }}</p>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
        @foreach($libros as $libro)
            <a href="{{ route('leer', ['id' => $libro->pk_libros]) }}">
                <div class="bg-white p-4 rounded-lg shadow-md transform transition-transform hover:scale-105">
                    <!-- Contenido del libro -->
                    <div class="flex flex-col items-center cursor-pointer">
                        <img src="{{ asset($libro->portada) }}" alt="{{ $libro->titulo }} Portada" class="h-64 object-cover rounded-lg mb-4" style="width: 195px; height: 340px;">
                        <h3 class="text-lg font-semibold mb-2 text-center">{{ $libro->titulo }}</h3>    
                        <div class="flex flex-wrap gap-2 mt-2"> 
                            @foreach($libro->categorias as $categoria)
                                <div class="categoria_color" style="background-color: {{ $categoria->color }}; color: black;">
                                    {{ $categoria->nom_categoria }}
                                </div>                                    
                            @endforeach 
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endif
