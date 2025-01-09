<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Librería') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-12">
        
        <form method="GET" action="{{ route('dashboard') }}" class="form-container">
            <div class="max-w-7xl mx-auto pb-2">
                <div class="flex items-center gap-4 mb-4">
                    <!-- Buscador -->
                    <div class="input-container">
                        <label for="buscador" class="label">Buscar</label>
                        <input type="text" name="buscador" id="buscador" placeholder="Buscar un libro..." class="input-text" onkeyup="buscarLibro()">
                    </div>
        
                    
                    <!-- Filtro -->
                    <div class="select-container">
                        <label for="categoria" class="label">Filtrar por categoría</label>
                        <select name="categoria" id="categoria" class="input-select" onchange="redireccionarCategoria(this)">
                            <option value="">Selecciona una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->nom_categoria }}" {{ $categoriaSeleccionada == $categoria->nom_categoria ? 'selected' : '' }}>
                                    {{ $categoria->nom_categoria }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>            
        </form>

        <div id="libros-list">
            @if($libros->whereIn('estatus', 2)->isEmpty())
                <p style="text-align: center; color: #7f8c8d; font-size: 1.2rem;">{{ __('No hay libros disponibles para mostrar.') }}</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                    @foreach($libros as $libro)
                        @if ($libro->estatus == 2)
                        <a href="{{route('leer',['id'=> $libro->pk_libros])}}">
                            <div class="bg-white p-4 rounded-lg shadow-md transform transition-transform hover:scale-105">
                                <!-- Contenido del libro -->
                                <div class="flex flex-col items-center cursor-pointer">
                                    <img src="{{ asset($libro->portada) }}" alt="{{ $libro->titulo }} Portada" class="h-64 object-cover rounded-lg mb-4" style="width: 195px; height: 340px;">
                                    <h3 class="text-lg font-semibold mb-2 text-center">{{ $libro->titulo }}</h3>    
                                    <div class="flex flex-wrap gap-2 mt-2"> 
                                        @foreach($libro->categorias as $categoria)
                                        <div class="categoria_color" style="background-color: {{$categoria->color}}; color: black;">
                                            {{ $categoria->nom_categoria }}
                                        </div>                                    
                                        @endforeach 
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

<script>
    function buscarLibro() {
        let buscador = document.getElementById('buscador').value;
        if (buscador.length >= 2) {
            $.ajax({
                url: "{{ route('dashboard') }}",
                method: "GET",
                data: { buscador: buscador },
                success: function(data) {
                    $('#libros-list').html(data);
                }
            });
        } else {
            $('#libros-list').html(''); // Limpiar la lista si la búsqueda es muy corta
        }
    }

    function redireccionarCategoria(select) {
        const categoriaSeleccionada = select.value;
        const baseUrl = "{{ route('dashboard') }}";
        const url = categoriaSeleccionada ? `${baseUrl}?categoria=${categoriaSeleccionada}` : baseUrl;
        window.location.href = url;
    }
</script>

<style> 

.categoria_color {
    display: inline-block;
    padding: 5px 10px;
    color: #ffffff; /* Asegura que el texto sea blanco */
    border-radius: 9999px; /* Hace que los bordes sean completamente redondeados */
    font-size: 14px; /* Tamaño del texto */
    text-align: center;
    font-weight: bold; /* Hace el texto más legible */
}


/* Estilo para el formulario general */
.form-container {
    border-radius: 0.5rem; /* Bordes redondeados */
}

/* Estilo para las etiquetas */
.label {
    font-weight: 600; /* Texto destacado */
    color: #4b5563; /* Color gris oscuro */
    font-size: 0.875rem; /* Tamaño de fuente pequeño */
    display: block; /* Para que cada etiqueta ocupe una línea */
    margin-bottom: 0.5rem; /* Espaciado entre la etiqueta y el input */
}

/* Estilo para los contenedores de los inputs */

.select-container {
    flex-grow: 1;
    margin-bottom: 1rem; /* Espaciado entre elementos */
}

.input-container {
    flex-grow: 3;
    margin-bottom: 1rem; /* Espaciado entre elementos */
}

/* Estilo para los inputs de texto */
.input-text {
    font-size: 1rem; /* Tamaño de texto */
    padding: 0.5rem; /* Espaciado interno */
    border: 1px solid #d1d5db; /* Bordes gris claro */
    border-radius: 0.375rem; /* Bordes redondeados */
    outline: none; /* Sin borde azul al seleccionar */
    transition: all 0.2s ease-in-out; /* Transición suave */
    width: 100%; /* Asegura que el input ocupe todo el ancho disponible */
}

/* Estilo para los inputs de texto al enfocar */
.input-text:focus {
    border-color: #6366f1; /* Color del borde al enfocar */
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3); /* Efecto de foco */
}

/* Estilo para los selectores */
.input-select {
    font-size: 1rem; /* Tamaño de texto */
    padding: 0.5rem; /* Espaciado interno */
    border: 1px solid #d1d5db; /* Bordes gris claro */
    border-radius: 0.375rem; /* Bordes redondeados */
    outline: none; /* Sin borde azul al seleccionar */
    transition: all 0.2s ease-in-out; /* Transición suave */
    width: 100%; /* Asegura que el select ocupe todo el ancho disponible */
}

/* Estilo para los selectores al enfocar */
.input-select:focus {
    border-color: #6366f1; /* Color del borde al enfocar */
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3); /* Efecto de foco */
}


</style>

