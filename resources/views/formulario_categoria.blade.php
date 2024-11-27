<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Categoría') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 grid-container">
                    <!-- Formulario para crear categoría -->
                    <div class="form-container">
                        <h3 class="form-title">Crear Nueva Categoría</h3>
                        <form action="{{ route('categorias.create') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nom_categoria" class="form-label">Nombre de la Categoría</label>
                                <input type="text" id="nom_categoria" name="nom_categoria" class="form-input" placeholder="Ej. Fantasía" required>
                            </div>
                            <div class="form-group">
                                <label for="color" class="form-label">Color de la Categoría</label>
                                <input type="color" id="color" name="color" class="form-input color-picker" required>
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" style="background-color: #000000;">
                                Guardar Categoría
                            </button>
                        </form>
                    </div>

                    <!-- Tabla de Categorías -->
                    <div class="categorias-container">
                        <h3 class="table-title">Categorías Existentes</h3>
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Color</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categorias as $categoria)
                                    <tr>
                                        <td>{{ $categoria->nom_categoria }}</td>
                                        <td>
                                            <div class="color-circle" style="background-color: {{ $categoria->color }};"></div>
                                        </td>
                                        <td>
                                            <a href="{{ route('categorias.edit', $categoria->pk_categoria_libros) }}" class="action-link edit-link">Editar</a>
                                            <form action="{{ route('categorias.destroy', $categoria->pk_categoria_libros) }}" method="POST" class="inline-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-link delete-link">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
/* Contenedor principal con diseño de Grid */
.grid-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

/* Estilo del formulario */
.form-container {
    padding: 20px;
}

.form-title {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 1rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.form-input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
}

.color-picker {
    height: 40px;
    padding: 0;
    border: 1px solid #ddd;
}

.submit-button {
    background-color: #007acc;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: bold;
    transition: background-color 0.3s;
}

.submit-button:hover {
    background-color: #005fa3;
}

/* Tabla de categorías */
.categorias-container {
    background-color: #ffffff;
    padding: 20px;
}

.table-title {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 1rem;
}

.custom-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 1rem;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #ddd;
}

.custom-table thead {
    background-color: #000000;
    color: white;
}

.custom-table th, .custom-table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}


.color-circle {
    width: 20px;
    height: 20px;
    border-radius: 50%;
}

/* Acciones */
.action-link {
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    margin-right: 10px;
}

.edit-link {
    color: #007acc;
}

.delete-link {
    color: #d32f2f;
}

.delete-link:hover {
    color: #b71c1c;
}
</style>
