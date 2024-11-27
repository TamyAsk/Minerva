<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Categoría') }}
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

                    <!-- Formulario para editar categoría -->
                    <form action="{{ route('categorias.update', $categoria->pk_categoria_libros) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center space-x-4">
                            <!-- Campo de Nombre de la Categoría -->
                            <div class="flex-1">
                                <label for="nom_categoria" class="block font-medium text-sm text-gray-700">Nombre de la Categoría</label>
                                <input type="text" id="nom_categoria" name="nom_categoria" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ $categoria->nom_categoria }}" placeholder="Ej. Fantasía" required>
                            </div>

                            <!-- Selector de Color -->
                            <div class="flex-1">
                                <label for="color" class="block font-medium text-sm text-gray-700">Color de la Categoría</label>
                                <div class="relative mt-1">
                                    <input type="color" id="color" name="color" class="form-input rounded-md shadow-sm block w-full p-0" value="{{ $categoria->color }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Botón de Guardar alineado a la derecha -->
                        <div class="flex justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" style="background-color: #000000;">
                                Actualizar Categoría
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    /* Estilos personalizados para el input de color */
    #color {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        width: 100%;
        height: 38px;
        border: 1px solid #000000;
        border-radius: 0.375rem;
        padding: 5px;
        cursor: pointer;
    }

    #color::-webkit-color-swatch-wrapper {
        padding: 0;
    }

    #color::-webkit-color-swatch {
        border: none;
        border-radius: 0.375rem;
    }

    #color::-moz-color-swatch {
        border: none;
        border-radius: 0.375rem;
    }

    .space-x-4 > * {
        margin-right: 16px;
    }

    .space-x-4 > *:last-child {
        margin-right: 0;
    }
</style>
