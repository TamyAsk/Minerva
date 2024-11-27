<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($libro) ? __('Editar Libro') : __('Crea tu libro') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ isset($libro) ? route('libro.actualizar', ['id' => $libro->pk_libros]) : route('guardar-libro') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="titulo" class="block font-medium text-sm text-gray-700">Título</label>
                            <input type="text" id="titulo" name="titulo" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ $libro->titulo ?? '' }}">
                        </div>

                        <div class="mb-4">
                            <label for="introduccion" class="block font-medium text-sm text-gray-700">Introducción</label>
                            <textarea id="introduccion" name="introduccion" rows='4' class="form-textarea rounded-md shadow-sm mt-1 block w-full">{{ $libro->introduccion ?? '' }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="portada" class="block font-medium text-sm text-gray-700">Portada</label>
                            <input type="file" id="portada" name="portada" class="form-input rounded-md shadow-sm mt-1 block w-full">
                        </div>

                        <div class="flex flex-wrap -mx-2 mb-4">
                            @php
                                $categorias = isset($libro) ? $libro->categorias->pluck('pk_categoria_libros')->toArray() : [];
                                $categoriaPrincipal = $categorias[0] ?? '';
                                $categoriaSecundaria = $categorias[1] ?? '';
                                $categoriaTerciaria = $categorias[2] ?? '';
                            @endphp
                            <div class="w-full md:w-1/3 mb-4 md:mb-0">
                                <label class="block font-medium text-sm text-gray-700">Categoría Principal</label>
                                <select name="fk_categoria_libros[]" class="form-select rounded-md shadow-sm mt-1 block w-full" required onchange="updateOptions(this)">
                                    <option value="">Seleccione una categoría</option>
                                    @foreach ($categoria_libros as $categoria)
                                        <option value="{{ $categoria->pk_categoria_libros }}" 
                                            {{ $categoria->pk_categoria_libros == $categoriaPrincipal ? 'selected' : '' }}>
                                            {{ $categoria->nom_categoria }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="w-full md:w-1/3 px-2 mb-4 md:mb-0">
                                <label class="block font-medium text-sm text-gray-700">Categoría Secundaria</label>
                                <select name="fk_categoria_libros[]" class="form-select rounded-md shadow-sm mt-1 block w-full" onchange="updateOptions(this)">
                                    <option value="">Seleccione una categoría</option>
                                    @foreach ($categoria_libros as $categoria)
                                        <option value="{{ $categoria->pk_categoria_libros }}" 
                                            {{ $categoria->pk_categoria_libros == $categoriaSecundaria ? 'selected' : '' }}>
                                            {{ $categoria->nom_categoria }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="w-full md:w-1/3 px-2">
                                <label class="block font-medium text-sm text-gray-700">Categoría Terciaria</label>
                                <select name="fk_categoria_libros[]" class="form-select rounded-md shadow-sm mt-1 block w-full" onchange="updateOptions(this)">
                                    <option value="">Seleccione una categoría</option>
                                    @foreach ($categoria_libros as $categoria)
                                        <option value="{{ $categoria->pk_categoria_libros }}" 
                                            {{ $categoria->pk_categoria_libros == $categoriaTerciaria ? 'selected' : '' }}>
                                            {{ $categoria->nom_categoria }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="contenido" class="block font-medium text-sm text-gray-700">Contenido</label>
                            <textarea rows='10' id="contenido" name="contenido" class="form-textarea rounded-md shadow-sm mt-1 block w-full">{{ $libro->contenido ?? '' }}</textarea>
                        </div>

                        <div class="flex flex-wrap -mx-2 mb-4">
                            <div class="w-full md:w-1/2">
                                <label for="usuario" class="block font-medium text-sm text-gray-700">Usuario</label>
                                <input type="text" id="usuario" name="usuario" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ Auth::user()->name }}" disabled>
                            </div>

                            <div class="w-full md:w-1/2 px-4">
                                <label for="publico_edad" class="block font-medium text-sm text-gray-700">Público Objetivo</label>
                                <select id="publico_edad" name="publico_edad" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                    <option value="">Seleccione el público</option>
                                    <option value="8" {{ isset($libro) && $libro->publico_edad == 8 ? 'selected' : '' }}>Infantil</option>
                                    <option value="17" {{ isset($libro) && $libro->publico_edad == 17 ? 'selected' : '' }}>Juvenil</option>
                                    <option value="18" {{ isset($libro) && $libro->publico_edad == 18 ? 'selected' : '' }}>Adulto</option>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" value="1" name="estatus">

                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" style="background-color: #000000;">
                                {{ isset($libro) ? 'Actualizar' : 'Guardar borrador' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateOptions(selected) {
            var selects = document.querySelectorAll('select[name="fk_categoria_libros[]"]');
            var selectedValues = Array.from(selects).map(select => select.value).filter(value => value !== "");

            selects.forEach((select) => {
                Array.from(select.options).forEach(option => {
                    if (selectedValues.includes(option.value) && option.value !== "" && option.value !== select.value) {
                        option.disabled = true;
                    } else {
                        option.disabled = false;
                    }
                });
            });
        }

        // Inicializa las opciones cuando la página se carga
        document.addEventListener('DOMContentLoaded', function() {
            updateOptions(document.querySelector('select[name="fk_categoria_libros[]"]'));
        });
    </script>
</x-app-layout>
